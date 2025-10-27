<?php
namespace Joomunited\WPSOLADDON;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WoocommerceSchedules
 */
class WoocommerceSchedules
{
    /**
     * Init woocommerce settings
     *
     * @var array
     */
    private $settings = array();
    /**
     * WoocommerceSchedules constructor.
     *
     * @param array $settings List settings
     */
    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    /**
     * Automatic cleanup woocommerce
     *
     * @return void
     */
    public function automaticCleanup()
    {
        add_action('wpsol_addon_woocommerce_automatic_cleanup', array($this, 'wpsolWoocommerceAutomaticCleanup'));
        add_action('init', array($this, 'wpsolWoocommerceScheduleCleanup'));
        add_filter('cron_schedules', array($this, 'wpsolWoocommercefilterCronSchedules'));
    }

    /**
     * Set up schedule_events
     *
     * @return void
     */
    public function wpsolWoocommerceScheduleCleanup()
    {
        $timestamp = wp_next_scheduled('wpsol_addon_woocommerce_automatic_cleanup');

        // Expire cache never
        if (isset($this->settings['woo_auto_cleanup']) && 'disable' === $this->settings['woo_auto_cleanup']) {
            wp_unschedule_event($timestamp, 'wpsol_addon_woocommerce_automatic_cleanup');
            return;
        }

        if (!$timestamp) {
            wp_schedule_event(time(), 'wpsol_woocommerce_cleanup', 'wpsol_addon_woocommerce_automatic_cleanup');
        }
    }

    /**
     *  Unschedule events
     *
     * @return void
     */
    public static function unWoocommerceScheduleCleanup()
    {
        $timestamp = wp_next_scheduled('wpsol_addon_woocommerce_automatic_cleanup');
        wp_unschedule_event($timestamp, 'wpsol_addon_woocommerce_automatic_cleanup');
    }

    /**
     * Add custom cron schedule
     *
     * @param array $schedules Time to schedules
     *
     * @return array
     */
    public function wpsolWoocommercefilterCronSchedules($schedules)
    {
        $interval = HOUR_IN_SECONDS;
        if (isset($this->settings['woo_auto_cleanup']) && 'disable' !== $this->settings['woo_auto_cleanup']) {
            // check parameter
            $interval = (int)$this->settings['woo_auto_cleanup'] * HOUR_IN_SECONDS;
        }

        $schedules['wpsol_woocommerce_cleanup'] = array(
            'interval' => $interval,
            'display' => esc_html__('WPSOL Automatic Woocommerce Cleanup Interval', 'wp-speed-of-light-addon'),
        );

        return $schedules;
    }

    /**
     * A purse
     *
     * @return void
     */
    public function wpsolWoocommerceAutomaticCleanup()
    {
        // Do nothing,
        if (isset($this->settings['woo_auto_cleanup']) && 'disable' === $this->settings['woo_auto_cleanup']) {
            return;
        }

        // Clean woocommerce session
        WoocommerceSpeedup::deleteWoocommerceSessions();

        // Clean transients
        WoocommerceSpeedup::deleteShopOderTransients();
        WoocommerceSpeedup::deleteProductTransients();
        WoocommerceSpeedup::deleteAtributeTaxonomiesTransients();
    }
}
