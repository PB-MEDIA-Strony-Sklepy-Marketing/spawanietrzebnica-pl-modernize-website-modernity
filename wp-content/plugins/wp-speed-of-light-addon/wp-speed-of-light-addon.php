<?php

/**
 * Plugin Name: WP Speed of Light Addon
 * Plugin URI: https://www.joomunited.com/wordpress-products/wp-speed-of-light
 * Description: WP Speed of Light Addon: Advanced features for WP Speed of Light plugin like image lazy loading, fonts optimization...
 * Version: 3.3.4
 * Text Domain: wp-speed-of-light-addon
 * Domain Path: /languages
 * Author: JoomUnited
 * Author URI: https://www.joomunited.com
 * License: GPL2
 */
/*
 * @copyright 2014  Joomunited  ( email : contact _at_ joomunited.com )
 *
 *  Original development of this plugin was kindly funded by Joomunited
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if (!defined('WPSOL_ADDON_PLUGIN_DIR')) {
    define('WPSOL_ADDON_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

if (!defined('WPSOL_ADDON_PLUGIN_URL')) {
    define('WPSOL_ADDON_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('WPSOL_ADDON_VERSION')) {
    define('WPSOL_ADDON_VERSION', '3.3.4');
}

if (!defined('WPSOL_UPLOAD_AVATAR')) {
    define('WPSOL_UPLOAD_AVATAR', WP_CONTENT_DIR . '/uploads/wpsol-avatar');
}

include_once(WPSOL_ADDON_PLUGIN_DIR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

// Check plugin requirements
if (version_compare(PHP_VERSION, '5.6', '<')) {
    if (!function_exists('wpsol_addon_disable_plugin')) {
        /**
         * Check version to disable plugin
         *
         * @return void
         */
        function wpsol_addon_disable_plugin()
        {
            if (current_user_can('activate_plugins') && is_plugin_active(plugin_basename(__FILE__))) {
                deactivate_plugins(__FILE__);
                //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- disable plugins
                unset($_GET['activate']);
            }
        }
    }
    if (!function_exists('wpsol_addon_show_error')) {
        /**
         * Show error when check php
         *
         * @return void
         */
        function wpsol_addon_show_error()
        {
            echo '<div class="error"><p>
            <strong>WP Speed Of Light Addon</strong>
             need at least PHP 5.6 version, please update php before installing the plugin.</p></div>';
        }
    }

    //Add actions
    add_action('admin_init', 'wpsol_addon_disable_plugin');
    add_action('admin_notices', 'wpsol_addon_show_error');

    //Do not load anything more
    return;
}

if (is_admin()) {
    register_activation_hook(__FILE__, array('\Joomunited\WPSOLADDON\Admin', 'wpsolAddonPluginActivation'));
    register_deactivation_hook(__FILE__, array('\Joomunited\WPSOLADDON\Admin', 'wpsolAddonPluginDeactivation'));
}


/**
 * Get addon path for requirement check
 *
 * @return string
 */
function wpsolAddons_getPath()
{
    if (!function_exists('plugin_basename')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    return plugin_basename(__FILE__);
}


//JU requirements
if (!class_exists('\Joomunited\WPSOLADDON\JUCheckRequirements')) {
    include_once(WPSOL_ADDON_PLUGIN_DIR . 'requirements.php');
}

if (class_exists('\Joomunited\WPSOLADDON\JUCheckRequirements')) {
    // Plugins name for translate
    $args           = array(
        'plugin_name'       => esc_html__('WP Speed Of Light Addon', 'wp-speed-of-light-addon'),
        'plugin_path'       => 'wp-speed-of-light-addon/wp-speed-of-light-addon.php',
        'plugin_textdomain' => 'wp-speed-of-light-addon',
        'plugin_version'    => WPSOL_ADDON_VERSION,
        'requirements'      => array(
            'plugins'     => array(
                array(
                    'name' => 'WP Speed Of Light',
                    'path' => 'wp-speed-of-light/wp-speed-of-light.php',
                    'requireVersion' => '2.3.0'
                )
            ),
            'php_version' => '5.6'
        ),
    );

    $wpsolAddonCheck = call_user_func('\Joomunited\WPSOLADDON\JUCheckRequirements::init', $args);
    if (!$wpsolAddonCheck['success']) {
        //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Do not load anything more
        unset($_GET['activate']);

        return;
    }
}
//Configuration
new \Joomunited\WPSOLADDON\Configuration();

// Advanced optimization
new \Joomunited\WPSOLADDON\AdvancedOptimization();

// Advanced optimization disable emojis
new \Joomunited\WPSOLADDON\DisableEmojis();

// Filter lazy load
new \Joomunited\WPSOLADDON\DisableGravatar();

// Include inc file
new \Joomunited\WPSOLADDON\SpeedOptimization();

// Database cleanup
new \Joomunited\WPSOLADDON\DatabaseCleanup();

// Filter lazy load
new \Joomunited\WPSOLADDON\FilterLoading();

// Filter lazy load
new \Joomunited\WPSOLADDON\WoocommerceSpeedup();

// Filter image dimensions
new \Joomunited\WPSOLADDON\ImageDimensions();

/**
 * Run this addon
 *
 * @return void
 */
function wpsolAddonsInit()
{
    if (is_admin()) {
        new \Joomunited\WPSOLADDON\Admin();

        $third = new \Joomunited\WPSOLADDON\FlushThirdPartyCache();

        //CDN Integration
        new \Joomunited\WPSOLADDON\CdnIntegration();

        //config section
        if (!defined('JU_BASE')) {
            define('JU_BASE', 'https://www.joomunited.com/');
        }

        $remote_updateinfo = JU_BASE . 'juupdater_files/wp-speed-of-light-addon.json';
        //end config
        require 'juupdater/juupdater.php';
        $UpdateChecker = Jufactory::buildUpdateChecker(
            $remote_updateinfo,
            __FILE__
        );

        // PROCESS PRELOAD
        //phpcs:ignore WordPress.Security.NonceVerification -- Check request, exist check token after
        if (isset($_REQUEST['task']) && $_REQUEST['task'] === 'wpsol-preload') {
            \Joomunited\WPSOLADDON\AdvancedOptimization::preloadProcess();
        }

        //JUtranslation
        add_filter('wpsol_get_addons', function ($addons) {
            $language_folder = plugin_dir_path(__FILE__) . 'languages';
            $language_folder .= DIRECTORY_SEPARATOR . 'wp-speed-of-light-addon-en_US.mo';
            $addon = new stdClass();
            $addon->main_plugin_file = __FILE__;
            $addon->extension_name = 'WP Speed Of Light Addon';
            $addon->extension_slug = 'wp-speed-of-light-addon';
            $addon->text_domain = 'wp-speed-of-light-addon';
            $addon->language_file = $language_folder;
            $addons[$addon->extension_slug] = $addon;
            return $addons;
        });
    }
}
