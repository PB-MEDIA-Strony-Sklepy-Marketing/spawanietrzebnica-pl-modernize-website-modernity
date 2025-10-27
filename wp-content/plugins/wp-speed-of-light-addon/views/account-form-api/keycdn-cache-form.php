<?php
if (!defined('ABSPATH')) {
    exit;
}

$key_cdn = get_option('wpsol_addon_author_key_cdn');
?>
<div class="account-form" id="keycdn-cache-form">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td><label><?php esc_html_e('API Authentication Key', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text"
                       value="<?php echo(!empty($key_cdn['authorization']) ? esc_html($key_cdn['authorization']) : '') ?>"
                       class="ju-input"   name="keycdn-authorization-key"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Zone IDs', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($key_cdn['zone']) ? esc_html($key_cdn['zone']) : '') ?>"
                       class="ju-input"  name="keycdn-zone-ids"/></td>
        </tr>
    </table>
</div>