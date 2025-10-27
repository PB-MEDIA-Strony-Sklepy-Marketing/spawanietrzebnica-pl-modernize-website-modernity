# Combined VCL for all hosts

# Marker to tell the VCL compiler that this VCL has been adapted to the
# new 4.0 format.
vcl 4.0;

# Backend definition
backend default {
	.host = "127.0.0.1";
	.port = "8080";
	.connect_timeout = 600s;
	.first_byte_timeout = 600s;
	.between_bytes_timeout = 600s;
	.max_connections = 800;
}

# Import Varnish Standard Module so I can serve custom error pages
import std;

acl purge {
	"127.0.0.1";
	"localhost";
}

sub vcl_recv {

	if (req.restarts == 0) {
		if (req.http.x-forwarded-for) {
			set req.http.X-Forwarded-For = req.http.X-Forwarded-For + ", " + client.ip;
		} else {
			set req.http.X-Forwarded-For = client.ip;
		}
	}

	if (req.method == "POST") {
		return (pass);
	}

	if (req.http.upgrade ~ "(?i)websocket") {
		return (pipe);
	}

	set req.backend_hint = default;

	# Remove cookies from things that should be static, if any are set
	if (req.url ~ "\.(png|gif|jpg|swf|css|js|ico|css|js|woff|ttf|eot|svg)(\?.*|)$") {
		unset req.http.Cookie;
		return (hash);
	}
	if (req.url ~ "^/images") {
		unset req.http.cookie;
		return (hash);
	}

	# Added by me to see if I can force Varnish to use X-Forwarded-For
	unset req.http.X-Forwarded-For;
	set req.http.X-Forwarded-For = client.ip;

	# allow PURGE from localhost, server's public IP, and my static IP
	if (req.method == "PURGE") {
		if (std.ip(req.http.X-forwarded-for, "0.0.0.0") !~ purge) {
			return (synth(405,"No purge 4 U."));
		}
        if (client.ip !~ purge) {
            return (synth(405, "Not allowed from " + client.ip));
        }
		if (req.http.X-Purge-Method == "regex") {
			ban("req.url ~ " + req.url + " && req.http.host ~ " + req.http.host);
			return (synth(200, "Purge block regex ban added."));
		}
	return (purge);
	}

	if (req.method == "BAN") {
		if (std.ip(req.http.X-forwarded-for, "0.0.0.0") !~ purge) {
			return (synth(405,"No ban 4 U."));
		}
		if (client.ip !~ purge) {
            return (synth(405, "Not allowed from " + client.ip));
        }
		if (req.http.X-Purge-Method == "regex") {
		    ban("req.url ~ " + req.url + " && req.http.host ~ " + req.http.host);
			ban("req.url ~ " + req.url + " && req.http.host ~ " + req.http.host);
			return (synth(200, "Ban block regex ban added."));
		}
		ban("req.http.host == " + req.http.host + " && req.url == " + req.url);
		return(synth(200, "Ban block ban added"));
	}

	# Remove Google Analytics and Piwik cookies so pages can be cached
	if (req.http.Cookie) {
		set req.http.Cookie = regsuball(req.http.Cookie, "(^|;\s*)(__[a-z]+|has_js)=[^;]*", "");
		set req.http.Cookie = regsuball(req.http.Cookie, "(^|;\s*)(_pk_(ses|id)[\.a-z0-9]*)=[^;]*", "");
	}
	if (req.http.Cookie == "") {
		unset req.http.Cookie;
	}

	return (hash);
}

sub vcl_pass {
	set req.http.connection = "close";
	# Fix broken behavior showing tons of requests from 127.0.0.1 with Discourse
	if (req.http.X-Forwarded-For) {
		set req.http.X-Forwarded-For = req.http.X-Forwarded-For;
	} else {
		set req.http.X-Forwarded-For = regsub(client.ip, ":.*", "");
	}
}

sub vcl_pipe {
	if (req.http.upgrade) {
		set bereq.http.upgrade = req.http.upgrade;
	}
}

sub vcl_backend_response {
	set beresp.http.x-url = bereq.url;
	set beresp.http.X-Host = bereq.http.host;

	# Strip cookies before static items are inserted into cache.
	if (bereq.url ~ "\.(png|gif|jpg|swf|css|js|ico|html|htm|woff|eof|ttf|svg)$") {
		unset beresp.http.set-cookie;
	}
	if (beresp.ttl < 24h) {
        if (beresp.http.Cache-Control ~ "(private|no-cache|no-store)") {
            set beresp.ttl = 60s;
        }
        else {
            set beresp.ttl = 24h;
        }
    }
}

sub vcl_deliver {

	# Display hit/miss info
	if (obj.hits > 0) {
		set resp.http.X-Cache = "HIT";
	}
	else {
		set resp.http.X-Cache = "MISS";
	}
	# Remove the Varnish header
	unset resp.http.X-Varnish;
	unset resp.http.Via;
	unset resp.http.X-Powered-By;
	unset resp.http.Server;

	# HTTP headers for all sites
	set resp.http.Server = "on fire";
	set resp.http.X-Hack = "Don't hack me bro, speed of light";
	set resp.http.Referrer-Policy = "strict-origin-when-cross-origin";
	set resp.http.Strict-Transport-Security = "max-age=31536000; includeSubDomains; preload;";
	set resp.http.X-Content-Type-Options = "nosniff";
	set resp.http.X-XSS-Protection = "1; mode=block";
	set resp.http.X-Frame-Options = "DENY";
	set resp.http.Expect-CT = {"Expect-CT: max-age=0; report-uri="""};

	# Remove custom error header
	unset resp.http.MyError;
	return (deliver);
}

sub vcl_synth {

	if (resp.status == 750) {
		set resp.status = 404 ;
		return(deliver);
	}

	if (resp.status == 405) {
		set resp.http.Content-Type = "text/html; charset=utf-8";
		set resp.http.MyError = std.fileread("/var/www/error/varnisherr.html");
		synthetic(resp.http.MyError);
		return(deliver);
	}
}
