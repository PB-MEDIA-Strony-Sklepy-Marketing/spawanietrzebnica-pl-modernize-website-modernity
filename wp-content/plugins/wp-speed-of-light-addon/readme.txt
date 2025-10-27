=== WP Speed of Light Addon ===
Contributors: JoomUnited
Tags: cache, caching, performance, speed test, performance test, wp-cache, cdn, combine, compress, speed plugin, database cache, deflate, gzip, http compression, js cache, minify, optimize, optimizer, page cache, performance, speed, expire headers, mobile cache
Requires at least: 4.7
Tested up to: 6.6
Stable tag: 3.3.4
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Speed of Light Addon is a WordPress speedup plugin and load time testing. Cache, Gzip, minify, group, Lazy Loading, CDN

== Description ==

== Changelog ==

= 3.3.4 =
 * Fix : Lazy loading conflicts with the 'Hide My WP' plugin

= 3.3.3 =
 * Fix : Reduce CPU usage when running preload page cache
 * Fix : Some PHP warnings

= 3.3.2 =
 * Fix : Speed optimization page can't access because conflict with Elementor

= 3.3.1 =
 * Fix : Some warnings when using image dimension option

= 3.3.0 =
 * Add : Image dimensions
 * Fix : Error when clear WooCommerce transients

= 3.2.0 =
 * Add : Cleanup only specific URL(s) from Cloudflare cache
 * Add : Iframe & HTML v5 video lazy loading
 * Add : Page exclusion from file group and minify optimizations
 * Add : Exclude inline style

= 3.1.1 =
 * Add : Cache preload using multiple XML sitemap URL(s)

= 3.1.0 =
 * Add : Cache preload using XML sitemap URL
 * Add : Defer inline script

= 3.0.0 =
 * Add : [breaking changes] Rewriting code base to follow PSR4

= 2.6.7 =
 * Fix : Lazy loading: resize loaded image

= 2.6.6 =
 * Add : Defer option into file grouping and file minification

= 2.6.5 =
 * Fix : Remove webpagetest api key
 * Fix : Save post error when using lazy loading

= 2.6.4 =
 * Fix : JoomUnited Updater compatible with WordPress 5.5

= 2.6.3 =
 * Fix : Clearing Cloudflare cache does not work correctly on API

= 2.6.2 =
 * Fix : Add notify by email script

= 2.6.1 =
 * Fix : Fix lazyloading errors after completing ajax

= 2.6.0 =
 * Add : WooCommerce Speedup: Disable Cart Fragments
 * Add : WooCommerce Speedup: disable styles for non WooCommerce pages
 * Add : WooCommerce Speedup: disable JS scripts for non WooCommerce pages
 * Add : WooCommerce Speedup: clear customer cart and sessions
 * Add : Automatic customer cart and sessions cleanup after a delay
 * Add : Control the Heartbeat API by defining the execution frequency
 * Fix : Lazy load not working correctly in safari & opera browser
 * Fix : Conflict with DIVI theme builder

= 2.5.3 =
 * Fix : Purge the varnish cache not working with multi object

= 2.5.2 =
 * Add : Possibility to exclude image width & height from lazy loading
 * Add : Possibility to exclude one screen height from lazy loading
 * Fix : Lazy loading compatible with IE11

= 2.5.1 =
 * Fix : Solve memory leaks on image lazy loading

= 2.5.0 =
 * Add : Implement new lazy loading feature
 * Fix : Check version requirements

= 2.4.2 =
 * Add : Implement lazyloading exclusion by id or class selector
 * Fix : Incorrect Plugin URI

= 2.4.1 =
 * Fix : Fix conflict lazyloading with gutenberg

= 2.4.0 =
 * Add : Rewrite code from “Simple Cache” and “Autoptimize”
 * Add :  After a cache cleanup, auto-reload the page
 * Add : Cleanup cache on Gutenberg save content
 * Fix : Remove direct CURL calls (security fix)
 * Fix : Admin responsive configuration & Speed optimization

= 2.3.0 =
 * Add : New UX for Speed Otimization and Speed Testing
 * Add : Possibility to search in plugin menus and settings
 * Add : New plugin installer with quick configuration
 * Add : Environment checker on install (PHP Version, PHP Extensions, Apache Modules)
 * Add : System Check menu to notify of server configuration problems after install
 * Add : Server testing before plugin activation to avoid all fatal errors

= 2.2.0 =
 * Add : Import/Export plugin configuration
 * Add : Exclude URLs from the lazy loading

= 2.1.1 =
 * Add : Enhance code readability and performance with phpcs

= 2.1.0 =
 * Add : Implement image Lazy Loading
 * Add : Implement option to disable WordPress Emoji
 * Add : Implement option to disable WordPress Gravatar
 * Add : Exclude inline JS scripts from minification
 * Add : Possibility to defer script loading in page footer

= 2.0.2 =
 * Fix : Check addon to exclude file from minification

= 2.0.1 =
 * Fix : Using PHPCS to make standard definitions
 * Fix : Change preloading activation method

= 2.0.0 =
 * Add : Database automatic optimization: duplicate post, comment, user, term meta
 * Add : Database automatic optimization: run database tables optimization
 * Add : Flush CDN cache from MaxCDN, KeyCDN and CloudFlare, automatic or manual method
 * Add : Flush cache from Siteground plugin and Varnish, automatic or manual method
 * Add : Change install message to a WP option, and display only once

= 1.0.0 =
 * Add : Disable cache per user role
 * Add : Disable cache per URL using rules like www.domain.com/blog*
 * Add : Automatic database cleanup by interval
 * Add : Preload the cache per URL
 * Add : DNS Prefetching (define custom domains)
 * Add : Option to exclude custom JS/CSS/FONT files from group
 * Add : Add the option to group fonts and Google fonts in optimization
 * Add : Initial release of WP Speed of Light Addon


