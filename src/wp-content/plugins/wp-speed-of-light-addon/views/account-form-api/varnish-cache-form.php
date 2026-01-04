<?php
if (!defined('ABSPATH')) {
    exit;
}

$varnish = get_option('wpsol_addon_varnish_ip');
?>
<div class="account-form" id="varnish-cache-form">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="2">
                <span class="ip-label">
                    <?php esc_html_e('A custom IP Address may be needed to properly communicate with the cache service (like Cloudflare, Sucuri, Nginx cache or other).', 'wp-speed-of-light-addon'); ?>
                </span>
            </td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Varnish Server IP', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(isset($varnish['ip']) && !empty($varnish['ip']) ? esc_html($varnish['ip']) : '127.0.0.1') ?>"
                       class="ju-input"  name="varnish-ip"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Varnish Key', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(isset($varnish['key']) && !empty($varnish['key']) ? esc_html($varnish['key']) : '') ?>"
                       class="ju-input"  name="varnish-key"/></td>
        </tr>
    </table>
</div>