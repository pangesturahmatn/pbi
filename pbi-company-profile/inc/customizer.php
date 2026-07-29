<?php
/**
 * WordPress Customizer Integration
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

if (!function_exists('pbi_customize_register')) {
    function pbi_customize_register($wp_customize) {
        
        // 1. Section: Desain & Warna
        $wp_customize->add_section('pbi_design_section', array(
            'title'       => __('Desain & Warna PBI', 'pbi-theme'),
            'priority'    => 30,
            'description' => __('Kustomisasi skema warna tema kustom PBI.', 'pbi-theme'),
        ));

        // Primary Color
        $wp_customize->add_setting('pbi_primary_color', array(
            'default'           => '#0B4628',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pbi_primary_color', array(
            'label'    => __('Warna Utama (Hijau Emerald)', 'pbi-theme'),
            'section'  => 'pbi_design_section',
            'settings' => 'pbi_primary_color',
        )));

        // Accent Color
        $wp_customize->add_setting('pbi_accent_color', array(
            'default'           => '#D4AF37',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pbi_accent_color', array(
            'label'    => __('Warna Aksen (Emas Amber)', 'pbi-theme'),
            'section'  => 'pbi_design_section',
            'settings' => 'pbi_accent_color',
        )));


        // 2. Section: Konten Beranda
        $wp_customize->add_section('pbi_homepage_section', array(
            'title'       => __('Konten Beranda PBI', 'pbi-theme'),
            'priority'    => 31,
            'description' => __('Atur teks Hero Banner dan Tombol CTA Beranda.', 'pbi-theme'),
        ));

        // Hero Title
        $wp_customize->add_setting('pbi_hero_title', array(
            'default'           => 'Membangun Pengusaha Tangguh, Mulia, & Gemar Berbagi',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_hero_title', array(
            'label'    => __('Judul Utama Hero', 'pbi-theme'),
            'section'  => 'pbi_homepage_section',
            'type'     => 'text',
        ));

        // Hero Subtitle
        $wp_customize->add_setting('pbi_hero_subtitle', array(
            'default'           => 'Lembaga pelatihan bisnis non-profit untuk melahirkan pengusaha Muslim yang mengutamakan keberkahan dunia dan akhirat.',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control('pbi_hero_subtitle', array(
            'label'    => __('Sub-judul Hero', 'pbi-theme'),
            'section'  => 'pbi_homepage_section',
            'type'     => 'textarea',
        ));

        // Hero CTA Text
        $wp_customize->add_setting('pbi_hero_cta_text', array(
            'default'           => 'Ikuti Pelatihan Gratis',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_hero_cta_text', array(
            'label'    => __('Teks Tombol CTA', 'pbi-theme'),
            'section'  => 'pbi_homepage_section',
            'type'     => 'text',
        ));

        // Hero CTA URL
        $wp_customize->add_setting('pbi_hero_cta_url', array(
            'default'           => '#program-terdekat',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('pbi_hero_cta_url', array(
            'label'    => __('Tautan Tombol CTA (URL)', 'pbi-theme'),
            'section'  => 'pbi_homepage_section',
            'type'     => 'text',
        ));


        // 3. Section: Statistik Counter
        $wp_customize->add_section('pbi_stats_section', array(
            'title'       => __('Statistik Organisasi', 'pbi-theme'),
            'priority'    => 32,
            'description' => __('Atur statistik angka berhitung untuk ditampilkan di Beranda.', 'pbi-theme'),
        ));

        // Alumni Count
        $wp_customize->add_setting('pbi_stat_alumni_count', array(
            'default'           => '55000',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('pbi_stat_alumni_count', array(
            'label'    => __('Jumlah Alumni', 'pbi-theme'),
            'section'  => 'pbi_stats_section',
            'type'     => 'number',
        ));

        // Event Count
        $wp_customize->add_setting('pbi_stat_event_count', array(
            'default'           => '450',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('pbi_stat_event_count', array(
            'label'    => __('Jumlah Pelatihan diadakan', 'pbi-theme'),
            'section'  => 'pbi_stats_section',
            'type'     => 'number',
        ));

        // Region Count
        $wp_customize->add_setting('pbi_stat_region_count', array(
            'default'           => '34',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('pbi_stat_region_count', array(
            'label'    => __('Jumlah Provinsi/Wilayah', 'pbi-theme'),
            'section'  => 'pbi_stats_section',
            'type'     => 'number',
        ));

        // 4. Section: Pengaturan Footer
        $wp_customize->add_section('pbi_footer_section', array(
            'title'       => __('Pengaturan Footer PBI', 'pbi-theme'),
            'priority'    => 33,
            'description' => __('Atur teks deskripsi dan kontak di bagian kaki halaman.', 'pbi-theme'),
        ));

        // Footer About Title
        $wp_customize->add_setting('pbi_footer_about_title', array(
            'default'           => 'Tentang PBI',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_footer_about_title', array(
            'label'    => __('Judul Tentang PBI', 'pbi-theme'),
            'section'  => 'pbi_footer_section',
            'type'     => 'text',
        ));

        // Footer About Text
        $wp_customize->add_setting('pbi_footer_about_text', array(
            'default'           => 'Pesantren Bisnis Indonesia (PBI) adalah wadah perjuangan dakwah ekonomi umat dalam melahirkan wirausahawan Muslim mandiri yang tangguh, mulia, dan gemar berbagi.',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control('pbi_footer_about_text', array(
            'label'    => __('Deskripsi Tentang PBI', 'pbi-theme'),
            'section'  => 'pbi_footer_section',
            'type'     => 'textarea',
        ));

        // Footer Address
        $wp_customize->add_setting('pbi_footer_address', array(
            'default'           => 'Kantor Pusat PBI, Banjarnegara, Jawa Tengah, Indonesia',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_footer_address', array(
            'label'    => __('Alamat Kontak', 'pbi-theme'),
            'section'  => 'pbi_footer_section',
            'type'     => 'text',
        ));

        // Footer Email
        $wp_customize->add_setting('pbi_footer_email', array(
            'default'           => 'admin@pesantrenbisnisindonesia.org',
            'sanitize_callback' => 'sanitize_email',
        ));
        $wp_customize->add_control('pbi_footer_email', array(
            'label'    => __('Email Kontak', 'pbi-theme'),
            'section'  => 'pbi_footer_section',
            'type'     => 'text',
        ));

        // Footer Phone
        $wp_customize->add_setting('pbi_footer_phone', array(
            'default'           => '+62 813-3453-7381',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_footer_phone', array(
            'label'    => __('Nomor Telepon Kontak', 'pbi-theme'),
            'section'  => 'pbi_footer_section',
            'type'     => 'text',
        ));

        // 5. Section: Media Sosial & Kontak Utama
        $wp_customize->add_section('pbi_socials_section', array(
            'title'       => __('Media Sosial & WhatsApp PBI', 'pbi-theme'),
            'priority'    => 34,
            'description' => __('Atur tautan akun media sosial resmi dan WhatsApp PBI.', 'pbi-theme'),
        ));

        // Facebook URL
        $wp_customize->add_setting('pbi_social_facebook', array(
            'default'           => 'https://facebook.com/pesantrenbisnisindonesia',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('pbi_social_facebook', array(
            'label'    => __('URL Facebook', 'pbi-theme'),
            'section'  => 'pbi_socials_section',
            'type'     => 'text',
        ));

        // Instagram URL
        $wp_customize->add_setting('pbi_social_instagram', array(
            'default'           => 'https://instagram.com/official.pbi',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('pbi_social_instagram', array(
            'label'    => __('URL Instagram', 'pbi-theme'),
            'section'  => 'pbi_socials_section',
            'type'     => 'text',
        ));

        // YouTube URL
        $wp_customize->add_setting('pbi_social_youtube', array(
            'default'           => 'https://youtube.com/pesantrenbisnisindonesia',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('pbi_social_youtube', array(
            'label'    => __('URL YouTube', 'pbi-theme'),
            'section'  => 'pbi_socials_section',
            'type'     => 'text',
        ));

        // WhatsApp Number
        $wp_customize->add_setting('pbi_social_whatsapp', array(
            'default'           => '6281334537381',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_social_whatsapp', array(
            'label'    => __('Nomor WhatsApp (Format: 6281234567890)', 'pbi-theme'),
            'section'  => 'pbi_socials_section',
            'type'     => 'text',
        ));

        // 6. Section: Halaman Tentang PBI
        $wp_customize->add_section('pbi_about_section', array(
            'title'       => __('Halaman Tentang PBI', 'pbi-theme'),
            'priority'    => 35,
            'description' => __('Atur konten video dan kustom script pada Halaman Tentang PBI.', 'pbi-theme'),
        ));

        // Video Embed Code
        $wp_customize->add_setting('pbi_about_video', array(
            'default'           => 'https://youtu.be/aKb3VjlEcCQ',
            'sanitize_callback' => 'pbi_sanitize_raw_code',
        ));
        $wp_customize->add_control('pbi_about_video', array(
            'label'       => __('Kode Semat Video (YouTube/Vimeo Embed Code)', 'pbi-theme'),
            'description' => __('Masukkan link YouTube (cth: https://youtu.be/aKb3VjlEcCQ) atau kode embed <iframe> dari YouTube untuk ditampilkan di halaman.', 'pbi-theme'),
            'section'     => 'pbi_about_section',
            'type'        => 'textarea',
        ));

        // Custom Code
        $wp_customize->add_setting('pbi_about_custom_code', array(
            'default'           => '',
            'sanitize_callback' => 'pbi_sanitize_raw_code',
        ));
        $wp_customize->add_control('pbi_about_custom_code', array(
            'label'       => __('Kustom HTML/Script/CSS', 'pbi-theme'),
            'description' => __('Masukkan script kustom, kode semat, pixel tracking, atau style tambahan khusus untuk halaman Tentang PBI.', 'pbi-theme'),
            'section'     => 'pbi_about_section',
            'type'        => 'textarea',
        ));

        // Founder Name
        $wp_customize->add_setting('pbi_about_founder_name', array(
            'default'           => 'Ust. Arif Abu Syamil',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_about_founder_name', array(
            'label'    => __('Nama Pendiri (Founder)', 'pbi-theme'),
            'section'  => 'pbi_about_section',
            'type'     => 'text',
        ));

        // Board Name
        $wp_customize->add_setting('pbi_about_board_name', array(
            'default'           => 'Bpk. Arif Hastono',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_about_board_name', array(
            'label'    => __('Nama Pengurus Inti', 'pbi-theme'),
            'section'  => 'pbi_about_section',
            'type'     => 'text',
        ));

        // 7. Section: Pengaturan Halaman Blog
        $wp_customize->add_section('pbi_blog_section', array(
            'title'       => __('Pengaturan Halaman Blog', 'pbi-theme'),
            'priority'    => 36,
            'description' => __('Atur sub-judul banner untuk Halaman Blog.', 'pbi-theme'),
        ));

        // Blog Subtitle
        $wp_customize->add_setting('pbi_blog_subtitle', array(
            'default'           => 'Kabar, Berita Terbaru & Artikel Bermanfaat Dari PBI',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('pbi_blog_subtitle', array(
            'label'    => __('Sub-judul Banner Blog', 'pbi-theme'),
            'section'  => 'pbi_blog_section',
            'type'     => 'text',
        ));
    }
}
add_action('customize_register', 'pbi_customize_register');

/**
 * Output Custom CSS dynamic styles based on customizer choices
 */
if (!function_exists('pbi_customize_css')) {
    function pbi_customize_css() {
        $primary = get_theme_mod('pbi_primary_color', '#0B4628');
        $accent  = get_theme_mod('pbi_accent_color', '#D4AF37');
        ?>
        <style type="text/css">
            :root {
                --pbi-primary: <?php echo esc_html($primary); ?>;
                --pbi-primary-hover: <?php echo esc_html(adjust_brightness($primary, -20)); ?>;
                --pbi-accent: <?php echo esc_html($accent); ?>;
                --pbi-accent-glow: rgba(<?php echo esc_html(hex2rgb($accent)); ?>, 0.25);
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'pbi_customize_css');

// Helper functions for brightness and RGB conversion
function adjust_brightness($hex, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

function hex2rgb($hex) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
        $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
        $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    return "$r, $g, $b";
}

if (!function_exists('pbi_sanitize_raw_code')) {
    function pbi_sanitize_raw_code($input) {
        return $input; // Return raw string to preserve scripts/iframes
    }
}
