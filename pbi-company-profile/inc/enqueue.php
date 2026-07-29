<?php
/**
 * Theme Assets Enqueue Functions
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

if (!function_exists('pbi_theme_enqueue_assets')) {
    function pbi_theme_enqueue_assets() {
        // Enqueue Google Fonts (Outfit & Inter)
        wp_enqueue_style('pbi-google-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

        // Enqueue FontAwesome for clean icons
        wp_enqueue_style('font-awesome-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

        // Enqueue Main stylesheet
        wp_enqueue_style('pbi-main-css', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');

        // Enqueue Main JavaScript logic
        wp_enqueue_script('pbi-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);

        // Pass settings/state to JS if needed
        wp_localize_script('pbi-main-js', 'pbi_theme_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'home_url' => home_url('/')
        ));

        // Enqueue dynamic counter script only on homepage template
        if (is_page_template('page-templates/template-home.php') || is_front_page()) {
            wp_enqueue_script('pbi-counters-js', get_template_directory_uri() . '/assets/js/counters.js', array(), '1.0.0', true);
        }
    }
}
add_action('wp_enqueue_scripts', 'pbi_theme_enqueue_assets');
