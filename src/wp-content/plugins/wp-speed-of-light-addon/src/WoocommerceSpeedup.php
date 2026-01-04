<?php
namespace Joomunited\WPSOLADDON;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WoocommerceSpeedup
 */
class WoocommerceSpeedup
{
    /**
     * Init woocommerce settings
     *
     * @var array
     */
    protected $woo_speedup = array();

    /**
     * WpsolAddonWoocommerceSpeedup constructor.
     */
    public function __construct()
    {
        //Get settings
        $this->woo_speedup = get_option('wpsol_woocommerce_speedup');

        //Init cleanup crons
        $cron = new WoocommerceSchedules($this->woo_speedup);
        $cron->automaticCleanup();

        if (is_admin()) {
            return;
        }

        // Set heartbeat frequency
        if (isset($this->woo_speedup['heartbeat_frequency']) && 'disable' === $this->woo_speedup['heartbeat_frequency']) {
            add_action('init', array($this, 'disableWPHeartbeatAPI'), 1);
        } else {
            add_filter('heartbeat_settings', array($this, 'reduceWPHeartbeatAPI'), 10, 1);
        }

        /**
         * Disable Ajax Call from WooCommerce
        */
        add_action('wp_enqueue_scripts', array($this, 'wpsolManageWoocommerceScripts'), 99);
    }

    /**
     * Manage woocommerce scripts
     *
     * @return void
     */
    public function wpsolManageWoocommerceScripts()
    {
        //check that woo exists to prevent fatal errors
        if (function_exists('is_woocommerce')) {
            //dequeue scripts and styles
            if (!is_woocommerce() && !is_cart() && !is_checkout()) {
                if (isset($this->woo_speedup['woo_disable_fragments']) && $this->woo_speedup['woo_disable_fragments']) {
                    wp_dequeue_script('wc-cart-fragments');
                }

                //Scripts
                if (isset($this->woo_speedup['woo_disable_scripts']) && $this->woo_speedup['woo_disable_scripts']) {
                    //remove generator meta tag
                    remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator'));
                    wp_dequeue_script('wc_price_slider');
                    wp_dequeue_script('wc-single-product');
                    wp_dequeue_script('wc-add-to-cart');
                    wp_dequeue_script('wc-cart-fragments');
                    wp_dequeue_script('wc-checkout');
                    wp_dequeue_script('wc-add-to-cart-variation');
                    wp_dequeue_script('wc-single-product');
                    wp_dequeue_script('wc-cart');
                    wp_dequeue_script('wc-chosen');
                    wp_dequeue_script('woocommerce');
                    wp_dequeue_script('prettyPhoto');
                    wp_dequeue_script('prettyPhoto-init');
                    wp_dequeue_script('jquery-blockui');
                    wp_dequeue_script('jquery-placeholder');
                    wp_dequeue_script('fancybox');
                    wp_dequeue_script('jqueryui');
                }

                //Styles
                if (isset($this->woo_speedup['woo_disable_styles']) && $this->woo_speedup['woo_disable_styles']) {
                    wp_dequeue_style('woocommerce-general');
                    wp_dequeue_style('woocommerce-layout');
                    wp_dequeue_style('woocommerce-smallscreen');
                    wp_dequeue_style('woocommerce_frontend_styles');
                    wp_dequeue_style('woocommerce_fancybox_styles');
                    wp_dequeue_style('woocommerce_chosen_styles');
                    wp_dequeue_style('woocommerce_prettyPhoto_css');
                }
            }
        }
    }

    /**
     * Disable Wordpress Heartbeat API
     *
     * @return void
     */
    public function disableWPHeartbeatAPI()
    {
        wp_deregister_script('heartbeat');
    }

    /**
     * Reduce Wordpress Heartbeat API
     *
     * @param array $settings Default heartbeat settings
     *
     * @return mixed
     */
    public function reduceWPHeartbeatAPI($settings)
    {
        if (isset($this->woo_speedup['heartbeat_frequency']) && $this->woo_speedup['heartbeat_frequency']) {
            $heartbeat            = (int) $this->woo_speedup['heartbeat_frequency'];
            $settings['interval'] = $heartbeat;
        }

        return $settings;
    }

    /**
     * Ajax clear woocommerce customer sessions
     *
     * @return void
     */
    public static function ajaxClearWooCustomerSessions()
    {
        check_ajax_referer('wpsolSpeedOptimizationSystem', 'ajaxnonce');

        $result = self::deleteWoocommerceSessions();

        echo json_encode($result);
        die;
    }

    /**
     * Delete woocommerce session
     *
     * @return array
     */
    public static function deleteWoocommerceSessions()
    {
        global $wpdb;

        $showtable = $wpdb->query("SHOW TABLES LIKE '" . $wpdb->prefix . "woocommerce_sessions'");

        $status = false;
        $message = __('An error occurred, maybe the table does not exist!', 'wp-speed-of-light-addon');

        if ($showtable > 0) {
            $wpdb->query('TRUNCATE ' . $wpdb->prefix . 'woocommerce_sessions');
            $result = $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->usermeta . " WHERE meta_key='_woocommerce_persistent_cart_%d';", get_current_blog_id()));
            /* translators: %d: amount of sessions */
            $message = sprintf(__('Deleted all active customer sessions and %d carts cleared!', 'wp-speed-of-light-addon'), absint($result));
            $status = true;
        }

        return array('status' => $status, 'message' => $message);
    }

    /**
     * Ajax clear woocommerce transients
     *
     * @return void
     */
    public static function ajaxClearWoocommerceTransients()
    {
        check_ajax_referer('wpsolSpeedOptimizationSystem', 'ajaxnonce');

        self::deleteProductTransients();
        self::deleteShopOderTransients();
        self::deleteAtributeTaxonomiesTransients();

        echo json_encode(array('status' => true, 'message' => __('Woocommerce transients cleared!', 'wp-speed-of-light-addon')));
        die;
    }

    /**
     * Delete woocommerce product transients
     *
     * @return void
     */
    public static function deleteProductTransients()
    {
        // Core transients.
        $transients_to_clear = array(
            'wc_products_onsale',
            'wc_featured_products',
            'wc_outofstock_count',
            'wc_low_stock_count',
            'wc_count_comments',
        );
        // Delete transients.
        foreach ($transients_to_clear as $transient) {
            delete_transient($transient);
        }
    }

    /**
     * Delete woocommerce shop order transients
     *
     * @return void
     */
    public static function deleteShopOderTransients()
    {
        $transients_to_clear = array(
            'wc_admin_report',
        );

        if (class_exists('WC_Admin_Reports')) {
            $reports = \WC_Admin_Reports::get_reports();

            if (!empty($reports)) {
                foreach ($reports as $report_group) {
                    foreach ($report_group['reports'] as $report_key => $report) {
                        $transients_to_clear[] = 'wc_report_' . $report_key;
                    }
                }
            }
        }

        foreach ($transients_to_clear as $transient) {
            delete_transient($transient);
        }
    }

    /**
     * Delete atribute taxonomies transients
     *
     * @return void
     */
    public static function deleteAtributeTaxonomiesTransients()
    {
        $attribute_taxonomies = get_transient('wc_attribute_taxonomies');

        if (false === $attribute_taxonomies) {
            global $wpdb;

            $showtable = $wpdb->query("SHOW TABLES LIKE '" . $wpdb->prefix . "woocommerce_attribute_taxonomies'");

            if ($showtable > 0) {
                $attribute_taxonomies = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;");

                set_transient('wc_attribute_taxonomies', $attribute_taxonomies);
            }
        }

        if (!empty($attribute_taxonomies)) {
            foreach ($attribute_taxonomies as $attribute) {
                delete_transient('wc_layered_nav_counts_pa_' . $attribute->attribute_name);
            }
        }
    }
}
