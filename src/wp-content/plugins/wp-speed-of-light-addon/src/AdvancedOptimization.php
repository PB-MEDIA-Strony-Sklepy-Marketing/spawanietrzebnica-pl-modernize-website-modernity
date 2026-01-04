<?php
namespace Joomunited\WPSOLADDON;

use Joomunited\WPSOL\Cache;

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class AdvancedOptimization
 */
class AdvancedOptimization
{
    /**
     * AdvancedOptimization constructor.
     */
    public function __construct()
    {
        add_action('wp_head', array($this, 'wpsolDnsFetching'));
    }

    /**
     *  Preload cache for guest
     *
     * @return void
     */
    public static function preloadCache()
    {
        $settings = get_option('wpsol_advanced_settings');

        if (!empty($settings['cache_preload'])) {
            $nonce = rand(time(), true);
            update_option('wpsol-addon-preload-nonce', $nonce);
            $url = home_url().'/wp-admin/admin.php?page=wpsol_speed_optimization&task=wpsol-preload&token='.$nonce;
            $args = array(
                'httpversion' => '1.1',
            );
            //Start preload
            wp_remote_get($url, $args);
        }
    }

    /**
     * Execute preload cache for guest
     *
     * @return void
     */
    public static function preloadProcess()
    {
        $settings = get_option('wpsol_advanced_settings');
        $nonce = get_option('wpsol-addon-preload-nonce');
        //phpcs:ignore WordPress.Security.NonceVerification -- Check request, exist check token after
        if ($_REQUEST['token'] !== $nonce) {
            exit;
        }

        ignore_user_abort(true);

        while (ob_get_level() !== 0) {
            ob_end_clean();
        }

        header('Connection: close', true);
        header("Content-Encoding: none\r\n");

        $args = array(
            'timeout'     => 30,
            'httpversion' => '1.1',
            'headers' => array('Authorpreload' => 'WPSOL_PRELOAD'),
        );

        //Make a request for each url
        $urls = $settings['preload_url'];
        $urls[] = home_url(); // preload from home page
        $preloaded = array();
        $host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
        // flexible ssl
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
        } elseif ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        $domain = $protocol . '://' . rtrim($host, '/');

        $urls = array_unique($urls);
        foreach ($urls as $url) {
            // trim slash(/) at the end
            $url = rtrim($url, '/');

            // check url
            $parsed = parse_url($url);
            $urlDomain = $parsed['scheme'] . '://' . $parsed['host'];
            if (empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false || $urlDomain !== $domain || strlen($url) > 2048) {
                continue;
            }

            // Looks great, preload for guest
            if (!in_array($url, $preloaded)) {
                sleep(4);
                $res = wp_remote_get($url, $args);
                if (!is_wp_error($res)) {
                    $preloaded[] = $url;
                    $body = wp_remote_retrieve_body($res);
                    // scan links from url page to preload them
                    $scan = Cache::scanLinks($body);
                    if ($scan) {
                        foreach ($scan as $sc) {
                            if (!in_array($sc, $preloaded)) {
                                sleep(4);
                                $res = wp_remote_get($sc, $args);
                                if (!is_wp_error($res)) {
                                    $preloaded[] = $sc;
                                }
                            }
                        }
                    }
                }
            }
        }

        // Get sitemap urls and preload
        $sitemap_links = array();
        if (isset($settings['sitemap_link'])) {
            if (is_array($settings['sitemap_link'])) {
                $sitemap_links = $settings['sitemap_link'];
            } else {
                $sitemap_links[] = $settings['sitemap_link']; // old value;
            }
        }
        $sitemapUrls = self::wpsolGetSitemapUrls($sitemap_links);
        if (!empty($sitemap_links) && $sitemapUrls) {
            $remain = array_diff($sitemapUrls, $preloaded);
            // preload all urls from sitemap that doesn't preloaded
            if (!empty($remain)) {
                foreach ($remain as $rm) {
                    sleep(4);
                    wp_remote_get($rm, $args);
                }
            }
        }

        exit();
    }

    /**
     * Get urls from multiple sitemaps
     *
     * @param string $sitemap_links Sitemap links
     *
     * @return array|false
     */
    public static function wpsolGetSitemapUrls($sitemap_links)
    {
        if (is_array($sitemap_links) && !empty($sitemap_links)) {
            $sitemapUrls = array();
            $homeUrl = get_home_url();
            if (!function_exists('get_home_path')) {
                include_once ABSPATH . '/wp-admin/includes/file.php';
            }
            $homePath = get_home_path();
            foreach ($sitemap_links as $sitemap_link) {
                $sitemap_path = str_replace($homeUrl, rtrim($homePath, '/'), $sitemap_link);
                if (empty($sitemap_path) || !file_exists($sitemap_path)) {
                    continue;
                }
                $sitemap = simplexml_load_file($sitemap_path);
                if ($sitemap !== false) {
                    foreach ($sitemap as $sm) {
                        $url = $sm->loc;
                        if (!empty($url)) {
                            $sitemapUrls[] = rtrim($url, '/');
                        }
                    }
                }
            }
            return array_unique($sitemapUrls);
        }

        return false;
    }

    /**
     * DNS pre fetching
     *
     * @return void
     */
    public function wpsolDnsFetching()
    {
        $advanced = get_option('wpsol_advanced_settings');

        if (!empty($advanced['dns_prefetching'])) {
            $dns_string = '<meta http-equiv="x-dns-prefetch-control" content="on">';
            if (!empty($advanced['prefetching_domain'])) {
                $domain_dns = array_map('esc_url', $advanced['prefetching_domain']);

                foreach ($domain_dns as $domain_name) {
                    $dns_string .= '<link rel="dns-prefetch" href="' . esc_url($domain_name) . '">';
                }
            }
            //phpcs:ignore WordPress.Security.EscapeOutput -- Echo meta tag to content, exist escaping url
            echo $dns_string;
        }
    }
}
