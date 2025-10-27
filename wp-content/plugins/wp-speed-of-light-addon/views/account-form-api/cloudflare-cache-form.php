<?php
if (!defined('ABSPATH')) {
    exit;
}

$cloudflare = get_option('wpsol_addon_author_cloudflare');
$cf_selected = isset($cloudflare['purge_type']) ? $cloudflare['purge_type'] : 'everything';
$cf_purge_urls = isset($cloudflare['purge_urls']) ? $cloudflare['purge_urls'] : '';
?>
<div class="account-form" id="cloudflare-cache-form">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td><label><?php esc_html_e('Email', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($cloudflare['username']) ? esc_html($cloudflare['username']) : '') ?>"
                     class="ju-input"  name="cloudflare-username"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('API Key', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($cloudflare['key']) ? esc_html($cloudflare['key']) : '') ?>"
                       class="ju-input"    name="cloudflare-key"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Domains', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($cloudflare['domain']) ? esc_html($cloudflare['domain']) : '') ?>"
                       class="ju-input"     name="cloudflare-domain"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Purge type', 'wp-speed-of-light-addon'); ?></label></td>
            <td>
                <select name="cloudflare-purgetype" class="ju-select" style="max-width: 100%" id="cf-pruge-type">
                    <option <?php selected($cf_selected, 'everything') ?> value="everything"><?php esc_html_e('Purge Everything', 'wp-speed-of-light-addon'); ?></option>
                    <option <?php selected($cf_selected, 'individual') ?> value="individual"><?php esc_html_e('Purge Individual Files', 'wp-speed-of-light-addon'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><textarea
                        placeholder="<?php echo esc_attr('One file per line, example: '. get_site_url() . '/css/styles.css'); ?>"
                        name="cloudflare-urls" id="cf-purge-urls" rows="8" class="ju-textarea">
                    <?php echo esc_textarea($cf_purge_urls); ?>
                </textarea></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button style="padding: 10px; margin-top: 10px" type="button" class="ju-button orange-button" name="purge-cf-cache-btn" id="purge-cf-cache-btn">
                    <span><?php esc_html_e('Purge CloudFlare', 'wp-speed-of-light-addon'); ?></span>
                </button>
            </td>
        </tr>
    </table>

</div>