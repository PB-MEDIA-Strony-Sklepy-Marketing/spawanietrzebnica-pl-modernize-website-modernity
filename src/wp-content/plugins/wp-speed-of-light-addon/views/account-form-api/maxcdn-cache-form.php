<?php
if (!defined('ABSPATH')) {
    exit;
}

$max_cdn = get_option('wpsol_addon_author_max_cdn');
?>
<div class="account-form" id="maxcdn-cache-form">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td><label><?php esc_html_e('Consumer Key', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text"
                       value="<?php echo(!empty($max_cdn['consumer-key']) ? esc_html($max_cdn['consumer-key']) : '') ?>"
                       class="ju-input"     name="maxcdn-consumer-key"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Consumer Secret', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text"
                       value="<?php echo(!empty($max_cdn['consumer-secret']) ? esc_html($max_cdn['consumer-secret']) : '') ?>"
                       class="ju-input"    name="maxcdn-consumer-secret"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Alias', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($max_cdn['alias']) ? esc_html($max_cdn['alias']) : '') ?>"
                       class="ju-input"     name="maxcdn-alias"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Zone IDs', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($max_cdn['zone']) ? esc_html($max_cdn['zone']) : '') ?>"
                       class="ju-input"    name="maxcdn-zone-ids"/></td>
        </tr>
    </table>
</div>