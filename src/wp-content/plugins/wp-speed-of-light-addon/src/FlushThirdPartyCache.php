<?php
namespace Joomunited\WPSOLADDON;

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class FlushThirdPartyCache
 */
class FlushThirdPartyCache
{
    /**
     * Init third party params
     *
     * @var array
     */
    private $third_party = array();
    /**
     * Init error message params
     *
     * @var array
     */
    private $error_message = array();

    /**
     * FlushThirdPartyCache constructor.
     */
    public function __construct()
    {
        $configuration = get_option('wpsol_cdn_integration');
        if (!empty($configuration['third_parts'])) {
            $this->third_party = $configuration['third_parts'];
        }
    }

    /**
     * Execute purge third party
     *
     * @return array|boolean
     */
    public function runPurgeThirdparty()
    {
        if (empty($this->third_party)) {
            return false;
        }
        foreach ($this->third_party as $third_party) {
            $third = str_replace('-cache', '', $third_party);
            // Call function bellow class to purge cache
            $this->error_message[] = call_user_func(array($this, 'purge' . $third . 'cache'));
        }

        return $this->error_message;
    }

    /**
     * Execute single purge Cloud Flare cache
     *
     * @return void
     */
    public static function singlePurgeCFCache()
    {
        if (!wp_verify_nonce($_REQUEST['wpsol_ajax_nonce'], 'wpsol-addon-advanced-cdn-nonce')) {
            die('wpsol_verify_nonce');
        }

        if (is_plugin_active('wp-speed-of-light-addon/wp-speed-of-light-addon.php')) {
            if (!empty($_REQUEST['params'])) {
                $message = self::purgecloudflarecache($_REQUEST['params']);
                wp_send_json(array('message' => $message));
            } else {
                wp_send_json(array('message' => 'Ops!, something went wrong!'));
            }
        }
    }

    /**
     * Key CDN cache
     *
     * @return boolean|string
     */
    public function purgekeycdncache()
    {
        // Get authorization
        $params = get_option('wpsol_addon_author_key_cdn');

        if (empty($params) || empty($params['authorization']) || empty($params['zone'])) {
            return 'Empty field !';
        }
        // Get api
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/cache-library-api/KeyCDN.php');
        $keyCDN = new KeyCDN($params['authorization']);

        // Get zone ids
        $zone_ids = explode(',', trim($params['zone']));

        $error_flush = '';

        foreach ($zone_ids as $zone_id) {
            //Using API keycdn to purge zone id
            //https://www.keycdn.com/api
            $execute = $keyCDN->get('zones/purge/' . $zone_id . '.json');
            $execute = json_decode($execute);

            if (is_null($execute) || $execute->status !== 'success') {
                $error_flush = 'KeyCDN Cache: ' . $execute->description;
                continue;
            }
        }

        if (empty($error_flush)) {
            return true;
        }

        return $error_flush;
    }

    /**
     * Key CDN cache
     *
     * @return boolean|string
     */
    public function purgemaxcdncache()
    {
        // Get authorization
        $params = get_option('wpsol_addon_author_max_cdn');

        if (empty($params) || empty($params['consumer-key']) ||
            empty($params['consumer-secret']) || empty($params['alias']) || empty($params['zone'])) {
            return 'Empty field !';
        }

        // Get api
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/cache-library-api/NetDNA.php');
        $maxCDN = new NetDNA(trim($params['alias']), trim($params['consumer-key']), trim($params['consumer-secret']));

        $zones = explode(',', $params['zone']);
        $error_flush = '';
        foreach ($zones as $zone) {
            // Using API to delete site cache by site id
            //https://api.stackpath.com/
            $api_call = json_decode($maxCDN->delete('/sites/' . $zone . '/cache'));

            if ($api_call->code !== 200 || isset($api_call->error)) {
                // Display error messages
                $error_flush = 'MaxCDN Cache: ' . $api_call->error->message;
                continue;
            }
        }
        if (!empty($error_flush)) {
            return $error_flush;
        }

        return true;
    }

    /**
     * Varnish cache flush service
     *
     * @return boolean|string
     */
    public function purgevarnishcache()
    {
        $parseUrl = parse_url(home_url());

        // Bail early if there's no host since some plugins are weird.
        if (!isset($parseUrl['host'])) {
            return true;
        }

        $pregex = '/.*';
        $x_purge_method = 'regex';

        // Determine the schema
        $schema = 'http://';

        // Determine the host
        $config = get_option('wpsol_addon_varnish_ip');
        if (isset($config['ip']) && !empty($config['ip'])) {
            // If we made varniship, let it sail.
            $host = $config['ip'];
        } else {
            $host = $parseUrl['host'];
        }

        // Determine the path
        $path = '';
        if (isset($parseUrl['path'])) {
            $path = $parseUrl['path'];
        }

        $url = $schema . $host . $path . $pregex;

        // Determine the query
        if (isset($parseUrl['query'])) {
            $url .= '?' . $parseUrl['query'];
        }

        //Allow setting of ports in host name
        $host_headers = $parseUrl['host'];
        if (isset($parseUrl['port'])) {
            $host_headers .= ':' . $parseUrl['port'];
        }

        $request_args = array(
            'method' => 'PURGE',
            'headers' => array(
                'host' => $host_headers,
                'X-VC-Purge-Host' => $host_headers,
                'X-Purge-Method' => $x_purge_method,
                'X-VC-Purge-Method' => $x_purge_method,
                'sslverify' => false,
            )
        );

        if (isset($config['key']) && !empty($config['key'])) {
            $request_args['headers']['X-VC-Purge-Key'] = $config['key'];
        }

        $response = wp_remote_request($url, $request_args);

        if (is_wp_error($response) || (isset($response['response']['code']) && $response['response']['code'] !== 200 && $response['response']['code'] !== 404)) {
            $error_flush = 'Varnish Cache: Failed to connect to server ip!';

            if (isset($response->errors) && isset($response->errors['http_request_failed'])) {
                $error_flush = 'Varnish Cache: ' . $response->errors['http_request_failed'][0];
            }
            return $error_flush;
        }

        return 'Varnish Cache: Purge successfully!';
    }

    /**
     * Key Cloudflare cache
     *
     * @param array|boolean $isPurgeBtn Array params
     *
     * @return boolean|string
     */
    public static function purgecloudflarecache($isPurgeBtn = false)
    {
        // Get authorization
        if ($isPurgeBtn === false) {
            $params = get_option('wpsol_addon_author_cloudflare');
        } else {
            // Click to Purge Cloudflare button
            $params = $isPurgeBtn;
        }

        if (empty($params) || empty($params['username']) || empty($params['key']) || empty($params['domain'])) {
            return 'Empty field !';
        }

        // Get api
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/cache-library-api/CloudFlare.php');
        if (class_exists('\Joomunited\WPSOLADDON\CloudFlare')) {
            $cloudFlare = new CloudFlare(trim($params['username']), trim($params['key']));

            // Get zone ids
            $domains = explode(',', trim($params['domain']));

            $error_flush = '';

            if (isset($params['purge_type']) && $params['purge_type'] === 'individual') {
                // Purge individual files
                if (!empty($params['purge_urls'])) {
                    // Detect urls
                    $cfUrls = explode("\n", trim($params['purge_urls']));
                } else {
                    return 'Empty url(s) to purge Cloudflare cache';
                }
            }
            // Purge
            $urls = isset($cfUrls) ? $cfUrls : array();
            foreach ($domains as $domain) {
                // Use API to purge domain cache
                $message = $cloudFlare->purge(trim($domain), $urls);
                if (is_string($message)) {
                    $error_flush .= $message . '<br>';
                }
            }

            if (!empty($error_flush)) {
                return $error_flush;
            }
            // No errors occurs
            return 'CloudFlare purge cache successfully!';
        } else {
            return 'Ops!, something went wrong with CloudFlare api';
        }
    }
    /**
     * Key SiteGround cache
     *
     * @return boolean|string
     */
    public function purgesitegroundcache()
    {

        $purgeRequest = parse_url(home_url(), PHP_URL_PATH) . '/(.*)';
        $sgcache_ip = '/etc/sgcache_ip';
        $hostname = $_SERVER['SERVER_ADDR'];
        $purge_method = 'PURGE';

        // Check if caching server is varnish
        if (file_exists($sgcache_ip)) {
            $hostname = trim(file_get_contents($sgcache_ip, true));
            if (!$hostname) {
                $error = 'SiteGround Cache: Connection to cache server failed!';
                return $error;
            }
            $purge_method = 'BAN';
        }
        $cacheServerSocket = fsockopen($hostname, 80, $errno, $errstr, 2);
        if (!$cacheServerSocket) {
            $error = 'SiteGround Cache: Connection to cache server failed!';
            return $error;
        }

        $request = $purge_method.' '.$purgeRequest.' HTTP/1.0\r\nHost: '.$_SERVER['SERVER_NAME'].'\r\nConnection: Close\r\n\r\n';

        if (preg_match('/^www\./', $_SERVER['SERVER_NAME'])) {
            $domain_no_www = preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']);
            $request2 = 'BAN '.$purgeRequest.' HTTP/1.0\r\nHost: '.$domain_no_www.'\r\nConnection: Close\r\n\r\n';
        } else {
            $request2 = 'BAN '.$purgeRequest.' HTTP/1.0\r\nHost: www.'.$_SERVER['SERVER_NAME'].'\r\nConnection: Close\r\n\r\n';
        }

        fwrite($cacheServerSocket, $request);
        $response = fgets($cacheServerSocket);
        fclose($cacheServerSocket);

        $cacheServerSocket = fsockopen($hostname, 80, $errno, $errstr, 2);
        fwrite($cacheServerSocket, $request2);
        fclose($cacheServerSocket);

        if (!preg_match('/200/', $response)) {
            $error = 'SiteGround Cache: Purge was not successful!';
            return $error;
        }

        return true;
    }
}
