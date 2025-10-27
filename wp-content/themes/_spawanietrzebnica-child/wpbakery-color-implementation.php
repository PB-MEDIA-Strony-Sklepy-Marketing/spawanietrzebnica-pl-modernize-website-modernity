<?php
/**
 * Przykład implementacji kolorów w custom elemencie WPBakery
 */

// Custom element z wykorzystaniem systemu kolorów
add_action('vc_before_init', 'st_vc_service_card');
function st_vc_service_card() {
    vc_map(array(
        'name' => __('Karta usługi TOLL-SPAW', 'spawanie-trzebnica'),
        'base' => 'st_service_card',
        'category' => __('Spawanie Trzebnica', 'spawanie-trzebnica'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => __('Schemat kolorów', 'spawanie-trzebnica'),
                'param_name' => 'color_scheme',
                'value' => array(
                    __('Złoty (główny)', 'spawanie-trzebnica') => 'primary',
                    __('Stalowy niebieski', 'spawanie-trzebnica') => 'secondary',
                    __('Pomarańcz spawalniczy', 'spawanie-trzebnica') => 'accent',
                    __('Gradient płomienia', 'spawanie-trzebnica') => 'gradient-flame',
                    __('Ciemny industrial', 'spawanie-trzebnica') => 'dark',
                ),
                'std' => 'primary',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Tytuł usługi', 'spawanie-trzebnica'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Opis', 'spawanie-trzebnica'),
                'param_name' => 'description',
            ),
        ),
    ));
}

// Shortcode handler
add_shortcode('st_service_card', 'st_service_card_shortcode');
function st_service_card_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'color_scheme' => 'primary',
        'title' => '',
        'description' => '',
    ), $atts);
    
    $color_classes = array(
        'primary' => 'st-card--primary',
        'secondary' => 'st-card--secondary',
        'accent' => 'st-card--accent',
        'gradient-flame' => 'st-card--gradient-flame',
        'dark' => 'st-card--dark',
    );
    
    $class = isset($color_classes[$atts['color_scheme']]) 
        ? $color_classes[$atts['color_scheme']] 
        : 'st-card--primary';
    
    ob_start();
    ?>
    <div class="st-service-card <?php echo esc_attr($class); ?>">
        <div class="st-service-card__icon">
            <svg class="st-service-card__icon-svg" width="48" height="48">
                <!-- Ikona spawania -->
            </svg>
        </div>
        <h3 class="st-service-card__title">
            <?php echo esc_html($atts['title']); ?>
        </h3>
        <p class="st-service-card__description">
            <?php echo esc_html($atts['description']); ?>
        </p>
        <a href="#" class="st-service-card__link">
            <?php _e('Dowiedz się więcej', 'spawanie-trzebnica'); ?>
            <span class="st-service-card__arrow">→</span>
        </a>
    </div>
    <?php
    return ob_get_clean();
}