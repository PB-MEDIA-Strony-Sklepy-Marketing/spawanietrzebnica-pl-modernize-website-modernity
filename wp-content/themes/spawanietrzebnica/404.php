<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header();

// Bezpieczne pobranie zmiennej globalnej opcji
global $welderpro_option;

$error_img_url = get_template_directory_uri() . '/img/error.jpg'; // domyślny obraz

if (
    isset($welderpro_option['error']) &&
    is_array($welderpro_option['error']) &&
    !empty($welderpro_option['error']['url'])
) {
    $error_img_url = esc_url($welderpro_option['error']['url']);
}
?>

<section class="error-section" style="background: url('<?php echo $error_img_url; ?>')">
    <div class="error-content">
        <div class="container">
            <h1><?php esc_html_e('oops! Page not found', 'welderpro'); ?></h1>
            <p><?php esc_html_e('The page you are looking for has either moved or does not exist. Please use the link below to return to our home page.', 'welderpro'); ?></p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="button-one">
                <?php esc_html_e('Back To Home', 'welderpro'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>


