<?php
namespace Joomunited\WPSOLADDON;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class CdnIntegration
 */
class CdnIntegration
{

    /**
     * CdnIntegration constructor.
     */
    public function __construct()
    {
        // Filter
        add_filter('wpsol_addon_save_cdn_integration', array($this, 'saveCdnIntegration'), 10, 2);
    }


    /**
     * Storage cdn parameter
     *
     * @param array $settings Option of CDN intergration
     * @param array $request  Request to save
     *
     * @return mixed
     */
    public function saveCdnIntegration($settings, $request)
    {
        $third_parts = array();
        if (isset($request['siteground-cache'])) {
            array_push($third_parts, 'siteground-cache');
        }
        if (isset($request['maxcdn-cache'])) {
            array_push($third_parts, 'maxcdn-cache');
        }
        if (isset($request['keycdn-cache'])) {
            array_push($third_parts, 'keycdn-cache');
        }
        if (isset($request['cloudflare-cache'])) {
            array_push($third_parts, 'cloudflare-cache');
        }
        if (isset($request['varnish-cache'])) {
            array_push($third_parts, 'varnish-cache');
        }
        $settings['third_parts'] = $third_parts;
        return $settings;
    }

    /**
     * Check option cleanup on save
     *
     * @return boolean
     */
    public function checkCleanupOnSave()
    {
        $config = get_option('wpsol_optimization_settings');
        if (!empty($config['speed_optimization']['cleanup_on_save'])) {
            return true;
        }
        return false;
    }

    /**
     *  Save settings of third partty to purge cache
     *
     * @return void
     */
    public static function saveThirdPartyCacheSettings()
    {
        check_admin_referer('wpsol_speed_optimization', '_wpsol_nonce');

        $varnish_config = array(
            'ip' => (isset($_REQUEST['varnish-ip'])) ? $_REQUEST['varnish-ip'] : '',
            'key' => (isset($_REQUEST['varnish-key'])) ? $_REQUEST['varnish-key'] : '',
        );
        update_option('wpsol_addon_varnish_ip', $varnish_config);

        $cloudflare_config = array(
            'username' => (isset($_REQUEST['cloudflare-username'])) ? $_REQUEST['cloudflare-username'] : '',
            'key' => (isset($_REQUEST['cloudflare-key'])) ? $_REQUEST['cloudflare-key'] : '',
            'domain' => (isset($_REQUEST['cloudflare-domain'])) ? $_REQUEST['cloudflare-domain'] : '',
            'purge_type' => (isset($_REQUEST['cloudflare-purgetype'])) ? $_REQUEST['cloudflare-purgetype'] : '',
            'purge_urls' => (isset($_REQUEST['cloudflare-urls'])) ? $_REQUEST['cloudflare-urls'] : '',
        );

        if (!empty($cloudflare_config['purge_urls'])) {
            $purgeUrls = explode("\n", trim($cloudflare_config['purge_urls']));
            $purgeUrls = array_map('trim', $purgeUrls);
            $purgeUrls = array_unique($purgeUrls);
            $cloudflare_config['purge_urls'] = implode("\n", $purgeUrls);
        }
        update_option('wpsol_addon_author_cloudflare', $cloudflare_config);

        $keycdn_config = array(
            'authorization' => (isset($_REQUEST['keycdn-authorization-key'])) ? $_REQUEST['keycdn-authorization-key'] : '',
            'zone' => (isset($_REQUEST['keycdn-zone-ids'])) ? $_REQUEST['keycdn-zone-ids'] : '',
        );
        update_option('wpsol_addon_author_key_cdn', $keycdn_config);

        $maxcdn_config = array(
            'consumer-key' => (isset($_REQUEST['maxcdn-consumer-key'])) ? $_REQUEST['maxcdn-consumer-key'] : '',
            'consumer-secret' => (isset($_REQUEST['maxcdn-consumer-secret'])) ? $_REQUEST['maxcdn-consumer-secret'] : '',
            'alias' => (isset($_REQUEST['maxcdn-alias'])) ? $_REQUEST['maxcdn-alias'] : '',
            'zone' => (isset($_REQUEST['maxcdn-zone-ids'])) ? $_REQUEST['maxcdn-zone-ids'] : '',
        );
        update_option('wpsol_addon_author_max_cdn', $maxcdn_config);
    }
}
