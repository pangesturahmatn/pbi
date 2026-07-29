<?php
/**
 * PBI Company Profile Theme Functions
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

define('PBI_THEME_DIR', get_template_directory());
define('PBI_THEME_URL', get_template_directory_uri());

// 1. Core theme setup (menus, post-thumbnails, widgets)
require_once PBI_THEME_DIR . '/inc/setup.php';

// 2. Loading stylesheets and scripts enqueues
require_once PBI_THEME_DIR . '/inc/enqueue.php';

// 3. Register Custom Post Types (Programs, Business Directories)
require_once PBI_THEME_DIR . '/inc/post-types.php';

// 4. Register Customizer API Fields and sections
require_once PBI_THEME_DIR . '/inc/customizer.php';

// 5. Shortcode wrapper helpers (consistent syntax [pbi_...] that matches layout)
if (!function_exists('pbi_register_theme_shortcodes')) {
    function pbi_register_theme_shortcodes() {
        
        // Shortcode [pbi_login_btn] to show login/logout button based on status
        add_shortcode('pbi_login_btn', function() {
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                return '<a href="' . esc_url(wp_logout_url(home_url())) . '" class="pbi-btn pbi-btn--accent"><i class="fa-solid fa-right-from-bracket"></i> Keluar (' . esc_html($current_user->display_name) . ')</a>';
            } else {
                return '<a href="' . esc_url(wp_login_url()) . '" class="pbi-btn pbi-btn--primary"><i class="fa-solid fa-user-lock"></i> Masuk Anggota</a>';
            }
        });

        // Shortcode [pbi_cta] to render clean responsive CTA banner
        add_shortcode('pbi_cta', function($atts) {
            $a = shortcode_atts(array(
                'title' => 'Mulai Perjalanan Bisnis Berkah Anda!',
                'text'  => 'Bergabung bersama puluhan ribu wirausahawan Muslim lainnya di PBI.',
                'btn'   => 'Daftar Sekarang',
                'link'  => '#contact'
            ), $atts);

            return '<div class="pbi-cta-block">
                <h3>' . esc_html($a['title']) . '</h3>
                <p>' . esc_html($a['text']) . '</p>
                <a href="' . esc_url($a['link']) . '" class="pbi-btn pbi-btn--accent">' . esc_html($a['btn']) . '</a>
            </div>';
        });
    }
}
add_action('init', 'pbi_register_theme_shortcodes');

// =====================================================================
// 6. FIX: REST API & Gutenberg Editor Error Prevention
//    Solves "Updating failed: not a valid JSON response"
// =====================================================================

// Pastikan tidak ada output/whitespace sebelum JSON REST API response
// (mencegah "not valid JSON" akibat PHP warning/notice yang tercetak)
add_filter('rest_pre_serve_request', function($served, $result, $request) {
    if (strpos($request->get_route(), '/wp/v2/') !== false) {
        if (ob_get_length() > 0) {
            ob_clean();
        }
    }
    return $served;
}, 10, 3);

// Pastikan REST API TIDAK diblokir untuk user yang sedang login
add_filter('rest_authentication_errors', function($result) {
    // Kembalikan null = biarkan WordPress handle autentikasi normal
    // Jangan return error kecuali ada error yang sudah ada
    if (is_wp_error($result)) {
        return $result;
    }
    return null; // Izinkan semua request, WordPress yang verifikasi
});

// Tambah batas ukuran upload gambar (32MB)
if (!function_exists('pbi_increase_upload_size')) {
    function pbi_increase_upload_size() {
        return 33554432; // 32MB dalam bytes
    }
}
add_filter('upload_size_limit', 'pbi_increase_upload_size');

// Izinkan REST API headers yang dibutuhkan Gutenberg
add_filter('rest_send_nocache_headers', '__return_true');

// =====================================================================
// 7. FIX: Tambah dukungan upload gambar di editor Gutenberg
// =====================================================================
add_theme_support('post-thumbnails');
add_theme_support('html5', array(
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script'
));

// =====================================================================
// 8. AUTO-SETUP: Buat halaman default saat tema diaktifkan
//    Semua halaman penting beserta kontennya akan otomatis dibuat
//    sehingga tidak perlu diinput ulang saat fresh install.
// =====================================================================
if (!function_exists('pbi_create_default_pages')) {
    function pbi_create_default_pages() {

        $pages = array(
            array(
                'title'    => 'Beranda',
                'slug'     => 'beranda',
                'content'  => '',
                'template' => 'page-templates/template-home.php',
            ),
            array(
                'title'   => 'Blog',
                'slug'    => 'blog',
                'content' => '',
            ),
            array(
                'title'   => 'Program',
                'slug'    => 'program',
                'content' => '<p>Temukan berbagai program pelatihan bisnis unggulan dari Pesantren Bisnis Indonesia yang dirancang untuk melahirkan pengusaha Muslim yang tangguh, mulia, dan gemar berbagi.</p>',
            ),
            array(
                'title'   => 'Direktori UMKM',
                'slug'    => 'direktori-umkm',
                'content' => '<p>Daftar bisnis dan usaha para alumni dan anggota Pesantren Bisnis Indonesia dari seluruh Indonesia.</p>',
            ),
            array(
                'title'   => 'Tentang PBI',
                'slug'    => 'tentang-pbi',
                'content' => '<p>Pesantren Bisnis Indonesia (PBI) adalah lembaga pelatihan bisnis non-profit yang berfokus pada pengembangan wirausahawan Muslim yang mengutamakan keberkahan dunia dan akhirat.</p>',
            ),
            array(
                'title'    => 'Hubungi Kami',
                'slug'     => 'hubungi-kami',
                'content'  => '',
                'template' => 'page-templates/template-contact.php',
            ),
            array(
                'title'   => 'Kebijakan Privasi',
                'slug'    => 'privacy-policy',
                'content' => '<h2>Kebijakan Privasi - Pesantren Bisnis Indonesia (PBI)</h2><p>Di PBI, kami sangat menghargai privasi pengunjung dan anggota kami. Kebijakan Privasi ini menjelaskan jenis informasi pribadi yang kami kumpulkan, bagaimana digunakan, dan langkah keamanan yang kami ambil.</p><h3>1. Informasi yang Kami Kumpulkan</h3><p>Kami mengumpulkan informasi ketika Anda mendaftar program, mengisi formulir kontak, atau mendaftarkan usaha di direktori UMKM kami, meliputi: Nama Lengkap, Alamat Email, Nomor Telepon/WhatsApp, Nama Usaha dan Informasi Bisnis.</p><h3>2. Penggunaan Informasi</h3><ul><li>Memproses pendaftaran program pelatihan dan acara PBI.</li><li>Menghubungi Anda via email atau WhatsApp terkait informasi program.</li><li>Menampilkan profil bisnis Anda di Direktori UMKM atas persetujuan Anda.</li><li>Meningkatkan kualitas layanan dan website kami.</li></ul><h3>3. Perlindungan Informasi</h3><p>Kami menerapkan langkah keamanan untuk menjaga informasi pribadi Anda. Kami tidak menjual atau memberikan informasi Anda kepada pihak ketiga tanpa persetujuan Anda.</p><h3>4. Cookie Website</h3><p>Website kami menggunakan cookie untuk menyimpan preferensi kunjungan Anda demi pengalaman navigasi yang lebih baik.</p><h3>5. Persetujuan Anda</h3><p>Dengan menggunakan website kami, Anda menyetujui Kebijakan Privasi ini beserta ketentuan-ketentuannya.</p><h3>6. Kontak Kami</h3><p>Pertanyaan mengenai kebijakan privasi dapat dikirimkan ke: <a href="mailto:admin@pesantrenbisnisindonesia.org">admin@pesantrenbisnisindonesia.org</a></p>',
            ),
            array(
                'title'   => 'Syarat dan Ketentuan',
                'slug'    => 'terms',
                'content' => '<h2>Syarat dan Ketentuan Layanan</h2><p>Selamat datang di website resmi Pesantren Bisnis Indonesia (PBI). Dengan mengakses website ini, Anda dianggap telah membaca, memahami, dan menyetujui Syarat dan Ketentuan di bawah ini.</p><h3>1. Penggunaan Website</h3><ul><li>Website ini ditujukan untuk informasi program pelatihan bisnis, artikel edukasi, serta direktori bagi pengusaha Muslim di bawah naungan PBI.</li><li>Anda setuju menggunakan website ini hanya untuk tujuan yang sah dan tidak melanggar hukum.</li></ul><h3>2. Pendaftaran Program dan Keanggotaan</h3><ul><li>Setiap program pelatihan PBI memiliki syarat kepesertaan yang wajib dipenuhi.</li><li>Informasi pendaftaran yang Anda berikan harus akurat, lengkap, dan terbaru.</li><li>PBI berhak menolak atau membatalkan kepesertaan jika ditemukan informasi tidak benar.</li></ul><h3>3. Direktori Bisnis UMKM</h3><ul><li>Data usaha yang didaftarkan di Direktori UMKM menjadi tanggung jawab pemilik usaha.</li><li>PBI tidak bertanggung jawab atas transaksi antar-anggota atau pihak ketiga melalui direktori ini.</li></ul><h3>4. Hak Kekayaan Intelektual</h3><p>Semua materi, logo, desain, teks, dan grafis di website ini adalah milik sah PBI. Penggunaan materi untuk tujuan komersil pribadi membutuhkan izin tertulis dari PBI.</p><h3>5. Batasan Tanggung Jawab</h3><p>PBI tidak memberikan jaminan keuntungan finansial. Hasil perkembangan bisnis bergantung pada praktik, kesungguhan, serta izin Allah SWT.</p><h3>6. Perubahan Ketentuan</h3><p>PBI berhak mengubah Syarat dan Ketentuan ini sewaktu-waktu. Perubahan berlaku segera setelah dipublikasikan.</p>',
            ),
        );

        foreach ($pages as $page_data) {
            $existing = get_page_by_path($page_data['slug'], OBJECT, 'page');
            if ($existing) {
                continue;
            }
            $new_page = array(
                'post_title'   => $page_data['title'],
                'post_name'    => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            );
            $page_id = wp_insert_post($new_page);
            if ($page_id && !is_wp_error($page_id) && !empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }

        $front_page = get_page_by_path('beranda', OBJECT, 'page');
        $blog_page  = get_page_by_path('blog', OBJECT, 'page');
        if ($front_page) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page->ID);
        }
        if ($blog_page) {
            update_option('page_for_posts', $blog_page->ID);
        }

        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();
    }
}
add_action('after_switch_theme', 'pbi_create_default_pages');

// =====================================================================
// 9. FIX: Auto-flush rewrite rules sekali saat tema baru aktif
//    Memastikan halaman Program & Direktori Bisnis tidak 404
//    Tanpa perlu manual Save di Settings > Permalinks
// =====================================================================
add_action('after_switch_theme', function() {
    set_transient('pbi_flush_rewrite_needed', '1', 60);
});

add_action('init', function() {
    if (get_transient('pbi_flush_rewrite_needed')) {
        flush_rewrite_rules();
        delete_transient('pbi_flush_rewrite_needed');
    }
}, 99); // Prioritas 99: setelah semua CPT terdaftar
