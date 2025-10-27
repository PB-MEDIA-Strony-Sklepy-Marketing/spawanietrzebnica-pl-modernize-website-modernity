<?php
/**
 * Enqueue brand colors and custom properties
 * Dodaj do functions.php motywu WordPress
 */

// Rejestracja głównego pliku CSS z kolorystyką
add_action('wp_enqueue_scripts', 'st_enqueue_brand_colors', 5);
function st_enqueue_brand_colors() {
    // Główny plik z kolorystyką
    wp_register_style(
        'st-brand-colors',
        get_template_directory_uri() . '/assets/css/brand-colors-system.css',
        array(),
        '1.0.0'
    );
    
    // Inline CSS dla krytycznych kolorów (above-the-fold)
    $critical_colors = '
        :root {
            --color-theme-primary: #EEB313;
            --color-theme-secondary: #2C5F7C;
            --button-theme-color: #EEB313;
            --button-theme-color-hover: #D19D0B;
            --background-theme-color: #F7F4E9;
            --color-text-primary: #1A1A1A;
            --color-heading-primary: #1A1A1A;
            --swiper-theme-color: #EEB313;
        }
    ';
    
    wp_add_inline_style('st-brand-colors', $critical_colors);
    wp_enqueue_style('st-brand-colors');
}

// Dodanie kolorów do edytora Gutenberg
add_action('after_setup_theme', 'st_setup_editor_colors');
function st_setup_editor_colors() {
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Główny złoty', 'spawanie-trzebnica'),
            'slug'  => 'primary-gold',
            'color' => '#EEB313',
        ),
        array(
            'name'  => __('Stalowy niebieski', 'spawanie-trzebnica'),
            'slug'  => 'secondary-steel',
            'color' => '#2C5F7C',
        ),
        array(
            'name'  => __('Pomarańcz spawalniczy', 'spawanie-trzebnica'),
            'slug'  => 'accent-orange',
            'color' => '#E85D04',
        ),
        array(
            'name'  => __('Ciemny industrial', 'spawanie-trzebnica'),
            'slug'  => 'dark-industrial',
            'color' => '#1A1A1A',
        ),
        array(
            'name'  => __('Kremowe tło', 'spawanie-trzebnica'),
            'slug'  => 'cream-bg',
            'color' => '#F7F4E9',
        ),
    ));
    
    // Gradienty dla edytora
    add_theme_support('editor-gradient-presets', array(
        array(
            'name'     => __('Płomień', 'spawanie-trzebnica'),
            'gradient' => 'linear-gradient(135deg, #E85D04 0%, #EEB313 50%, #F6D575 100%)',
            'slug'     => 'flame',
        ),
        array(
            'name'     => __('Stal', 'spawanie-trzebnica'),
            'gradient' => 'linear-gradient(180deg, #2C5F7C 0%, #1F4A61 100%)',
            'slug'     => 'steel',
        ),
    ));
}

// Customizer - opcje kolorystyki
add_action('customize_register', 'st_customize_colors');
function st_customize_colors($wp_customize) {
    // Sekcja kolorów
    $wp_customize->add_section('st_brand_colors', array(
        'title'    => __('Kolorystyka marki', 'spawanie-trzebnica'),
        'priority' => 30,
    ));
    
    // Główny kolor
    $wp_customize->add_setting('st_primary_color', array(
        'default'           => '#EEB313',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'st_primary_color', array(
        'label'    => __('Kolor główny', 'spawanie-trzebnica'),
        'section'  => 'st_brand_colors',
        'settings' => 'st_primary_color',
    )));
    
    // Tryb ciemny
    $wp_customize->add_setting('st_dark_mode', array(
        'default'           => 'auto',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('st_dark_mode', array(
        'label'    => __('Tryb ciemny', 'spawanie-trzebnica'),
        'section'  => 'st_brand_colors',
        'type'     => 'select',
        'choices'  => array(
            'auto'  => __('Automatyczny', 'spawanie-trzebnica'),
            'light' => __('Jasny', 'spawanie-trzebnica'),
            'dark'  => __('Ciemny', 'spawanie-trzebnica'),
        ),
    ));
}