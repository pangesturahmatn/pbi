<?php
/**
 * Theme Setup Functions
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

if (!function_exists('pbi_theme_setup')) {
    function pbi_theme_setup() {
        // Support translation
        load_theme_textdomain('pbi-theme', get_template_directory() . '/languages');

        // Dynamic title tag support
        add_theme_support('title-tag');

        // Featured images support
        add_theme_support('post-thumbnails');

        // Custom logo support
        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 240,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // HTML5 markup support
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Register navigation menus
        register_nav_menus(array(
            'primary' => __('Navigasi Utama', 'pbi-theme'),
            'footer'  => __('Navigasi Footer', 'pbi-theme'),
        ));
    }
}
add_action('after_setup_theme', 'pbi_theme_setup');

if (!function_exists('pbi_theme_widgets_init')) {
    function pbi_theme_widgets_init() {
        // Register sidebar/widget areas for footer
        register_sidebar(array(
            'name'          => __('Footer Widget Area 1', 'pbi-theme'),
            'id'            => 'footer-1',
            'description'   => __('Widget di kolom pertama footer (Tentang PBI).', 'pbi-theme'),
            'before_widget' => '<div id="%1$s" class="pbi-footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="pbi-footer-widget__title">',
            'after_title'   => '</h4>',
        ));

        register_sidebar(array(
            'name'          => __('Footer Widget Area 2', 'pbi-theme'),
            'id'            => 'footer-2',
            'description'   => __('Widget di kolom kedua footer (Link Cepat).', 'pbi-theme'),
            'before_widget' => '<div id="%1$s" class="pbi-footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="pbi-footer-widget__title">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'pbi_theme_widgets_init');

/**
 * Automatically create and assign default menus on theme activation
 */
if (!function_exists('pbi_create_default_menus')) {
    function pbi_create_default_menus() {
        // Check current location settings
        // One-time menu and page rebuild to ensure correct order:
        // Beranda, Program, Direktori UMKM, Blog, Tentang PBI, Hubungi Kami
        if (!get_option('pbi_menu_rebuilt_v6')) {
            $old_primary = wp_get_nav_menu_object('Navigasi Utama PBI');
            if ($old_primary) {
                wp_delete_nav_menu($old_primary->term_id);
            }
            $old_footer = wp_get_nav_menu_object('Navigasi Footer PBI');
            if ($old_footer) {
                wp_delete_nav_menu($old_footer->term_id);
            }

            // 1. Create Pages if they don't exist
            
            // A. Beranda
            $homepage = get_page_by_path('beranda');
            if (!$homepage) {
                $homepage_id = wp_insert_post(array(
                    'post_title'    => 'Beranda',
                    'post_name'     => 'beranda',
                    'post_content'  => '',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ));
            } else {
                $homepage_id = $homepage->ID;
            }
            if ($homepage_id) {
                update_post_meta($homepage_id, '_wp_page_template', 'page-templates/template-home.php');
                update_option('show_on_front', 'page');
                update_option('page_on_front', $homepage_id);
            }

            // B. Program
            $progpage = get_page_by_path('program');
            if (!$progpage) {
                $progpage_id = wp_insert_post(array(
                    'post_title'    => 'Program',
                    'post_name'     => 'program',
                    'post_content'  => 'Halaman daftar program dan kegiatan pelatihan Pesantren Bisnis Indonesia.',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ));
            } else {
                $progpage_id = $progpage->ID;
            }

            // C. Direktori UMKM
            $dirpage = get_page_by_path('direktori-umkm');
            if (!$dirpage) {
                $dirpage_id = wp_insert_post(array(
                    'post_title'    => 'Direktori UMKM',
                    'post_name'     => 'direktori-umkm',
                    'post_content'  => 'Halaman direktori bisnis member Pesantren Bisnis Indonesia.',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ));
            } else {
                $dirpage_id = $dirpage->ID;
            }

            // D. Blog
            $blogpage = get_page_by_path('blog');
            if (!$blogpage) {
                $blogpage_id = wp_insert_post(array(
                    'post_title'    => 'Blog',
                    'post_name'     => 'blog',
                    'post_content'  => '',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ));
            } else {
                $blogpage_id = $blogpage->ID;
            }
            if ($blogpage_id) {
                update_option('page_for_posts', $blogpage_id);
            }

            // E. Tentang PBI
            $tentangpage = get_page_by_path('tentang-pbi');
            if (!$tentangpage) {
                $tentangpage_id = wp_insert_post(array(
                    'post_title'    => 'Tentang PBI',
                    'post_name'     => 'tentang-pbi',
                    'post_content'  => 'Pesantren Bisnis Indonesia (PBI) adalah wadah perjuangan dakwah ekonomi umat dalam melahirkan wirausahawan Muslim mandiri yang tangguh, mulia, dan gemar berbagi.',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ));
            } else {
                $tentangpage_id = $tentangpage->ID;
            }
            if ($tentangpage_id) {
                update_post_meta($tentangpage_id, '_wp_page_template', 'page-templates/template-about.php');
            }

            // F. Hubungi Kami
            $hubungipage = get_page_by_path('hubungi-kami');
            if (!$hubungipage) {
                $hubungipage_id = wp_insert_post(array(
                    'post_title'    => 'Hubungi Kami',
                    'post_name'     => 'hubungi-kami',
                    'post_content'  => 'Hubungi kami di Kantor Pusat PBI Jawa Barat, Indonesia. Email: info@pesantrenbisnis.id, Telp: +62 812-3456-7890.',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ));
            } else {
                $hubungipage_id = $hubungipage->ID;
            }

            // 2. Create primary menu and update items in exact order:
            // Beranda, Program, Direktori UMKM, Blog, Tentang PBI, Hubungi Kami
            $primary_menu_name = 'Navigasi Utama PBI';
            $menu_id = wp_create_nav_menu($primary_menu_name);
            
            $locations = array();
            if ($menu_id) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => 'Beranda',
                    'menu-item-url'     => home_url('/'),
                    'menu-item-status'  => 'publish'
                ));
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => 'Program',
                    'menu-item-url'     => home_url('/program/'),
                    'menu-item-status'  => 'publish'
                ));
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => 'Direktori UMKM',
                    'menu-item-url'     => home_url('/direktori-umkm/'),
                    'menu-item-status'  => 'publish'
                ));
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => 'Blog',
                    'menu-item-url'     => home_url('/blog/'),
                    'menu-item-status'  => 'publish'
                ));
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => 'Tentang PBI',
                    'menu-item-url'     => home_url('/tentang-pbi/'),
                    'menu-item-status'  => 'publish'
                ));
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'   => 'Hubungi Kami',
                    'menu-item-url'     => home_url('/hubungi-kami/'),
                    'menu-item-status'  => 'publish'
                ));

                $locations['primary'] = $menu_id;
            }

            // 3. Create footer menu
            $footer_menu_name = 'Navigasi Footer PBI';
            $footer_menu_id = wp_create_nav_menu($footer_menu_name);
            if ($footer_menu_id) {
                wp_update_nav_menu_item($footer_menu_id, 0, array(
                    'menu-item-title'   => 'Kebijakan Privasi',
                    'menu-item-url'     => home_url('/privacy-policy/'),
                    'menu-item-status'  => 'publish'
                ));
                wp_update_nav_menu_item($footer_menu_id, 0, array(
                    'menu-item-title'   => 'Syarat & Ketentuan',
                    'menu-item-url'     => home_url('/terms/'),
                    'menu-item-status'  => 'publish'
                ));
                $locations['footer'] = $footer_menu_id;
            }

            set_theme_mod('nav_menu_locations', $locations);
            update_option('pbi_menu_rebuilt_v6', true);
            flush_rewrite_rules();
        }

        // 4. Auto insert 5 Blog Posts, 3 Programs CPT, and 3 Business Directory CPT if empty
        pbi_insert_demo_content();
    }
}
add_action('init', 'pbi_create_default_menus', 20);

/**
 * Helper to insert high-quality default content on install
 */
function pbi_insert_demo_content() {
    // 1. Check and insert 5 Blog Posts
    $blog_count = wp_count_posts('post');
    $published_blogs = isset($blog_count->publish) ? intval($blog_count->publish) : 0;
    if ($published_blogs <= 1) {
        // Delete "Hello World" post if exists
        $hello_post = get_page_by_path('hello-world', OBJECT, 'post');
        if ($hello_post) {
            wp_delete_post($hello_post->ID, true);
        }

        $posts_data = array(
            array(
                'title'   => '5 Prinsip Bisnis Syariah untuk Keberkahan Usaha',
                'slug'    => 'prinsip-bisnis-syariah',
                'content' => 'Bisnis syariah bukan sekadar label halal, melainkan pondasi keberkahan. Terdapat 5 prinsip utama muamalah: menghindari riba, menjunjung tinggi kejujuran, menjauhi gharar (ketidakjelasan), bersikap adil kepada karyawan, serta konsisten mengeluarkan zakat perniagaan. Dengan menerapkan hal ini, bisnis tidak hanya mendatangkan profit finansial, melainkan juga ketenangan hati.'
            ),
            array(
                'title'   => 'Mengintegrasikan Nilai Spiritual dalam Manajemen Bisnis',
                'slug'    => 'spiritual-manajemen-bisnis',
                'content' => 'Manajemen modern yang sukses selalu menyertakan integritas spiritual. Di PBI, kami mengajarkan bahwa shalat tepat waktu berjamaah, tilawah harian di tempat kerja, serta sedekah pagi bagi perusahaan mampu melipatgandakan produktivitas dan keharmonisan tim kerja secara signifikan.'
            ),
            array(
                'title'   => 'Zakat dan Sedekah sebagai Penggerak Pertumbuhan Usaha',
                'slug'    => 'zakat-sedekah-penggerak-usaha',
                'content' => 'Banyak pengusaha takut bersedekah karena khawatir hartanya berkurang. Padahal, Allah menjanjikan pelipatgandaan rezeki bagi yang gemar berbagi. Zakat perniagaan membersihkan harta, sementara sedekah melancarkan aliran rezeki dan menjauhkan usaha dari berbagai macam musibah.'
            ),
            array(
                'title'   => 'Pentingnya Kejujuran dan Amanah dalam Muamalah Dagang',
                'slug'    => 'pentingnya-kejujuran-dagang',
                'content' => 'Kejujuran adalah mata uang yang berlaku di mana saja. Seorang pengusaha Muslim wajib menyampaikan cacat produk secara transparan kepada pembeli. Sikap amanah inilah yang akan membangun loyalitas pelanggan jangka panjang dan mendatangkan keberkahan berlipat.'
            ),
            array(
                'title'   => 'Kisah Sukses Pengusaha Muslim di Zaman Keemasan Islam',
                'slug'    => 'pengusaha-muslim-zaman-emas',
                'content' => 'Belajar dari Abdurrahman bin Auf dan Utsman bin Affan, mereka adalah konglomerat sahabat Nabi yang memadukan keahlian dagang tinggi dengan kedermawanan luar biasa. Kunci sukses mereka adalah memegang dunia di tangan, bukan di dalam hati, sehingga seluruh hartanya digunakan untuk dakwah dan umat.'
            )
        );

        foreach ($posts_data as $p) {
            wp_insert_post(array(
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_content' => $p['content'],
                'post_status'  => 'publish',
                'post_type'    => 'post'
            ));
        }
    }

    // 2. Check and insert Quantum Spiritual Business event specifically
    $quantum_post = get_page_by_path('quantum-spiritual-business', OBJECT, 'pbi_program');
    if (!$quantum_post) {
        $pid = wp_insert_post(array(
            'post_title'  => 'Quantum Spiritual Business',
            'post_name'   => 'quantum-spiritual-business',
            'post_status' => 'publish',
            'post_type'   => 'pbi_program'
        ));
        if ($pid) {
            update_post_meta($pid, '_pbi_program_date', '2026-07-31');
            update_post_meta($pid, '_pbi_program_location', 'Sanyuwa House, Banjarnegara');
            update_post_meta($pid, '_pbi_program_status', 'buka');
            update_post_meta($pid, '_pbi_program_reg_url', 'https://registrasi.pesantrenbisnisindonesia.org/');
        }
    }

    // 2b. Check and insert 3 Program Posts
    $program_count = wp_count_posts('pbi_program');
    $published_programs = isset($program_count->publish) ? intval($program_count->publish) : 0;
    if ($published_programs === 0) {
        $programs_data = array(
            array(
                'title' => 'PBI Business Bootcamp #1',
                'slug'  => 'pbi-business-bootcamp',
                'date'  => date('Y-m-d', strtotime('+15 days')),
                'loc'   => 'Hotel Horison, Bandung',
                'status'=> 'buka',
                'url'   => 'https://wa.me/6281234567890'
            ),
            array(
                'title' => 'Kajian Pengusaha Rindu Syurga',
                'slug'  => 'kajian-pengusaha-rindu-syurga',
                'date'  => date('Y-m-d', strtotime('+22 days')),
                'loc'   => 'Masjid Raya PBI, Bekasi',
                'status'=> 'buka',
                'url'   => 'https://wa.me/6281234567890'
            ),
            array(
                'title' => 'Majelis Ekonomi Umat',
                'slug'  => 'majelis-ekonomi-umat',
                'date'  => date('Y-m-d', strtotime('+30 days')),
                'loc'   => 'Aula PBI, Tasikmalaya',
                'status'=> 'buka',
                'url'   => 'https://wa.me/6281234567890'
            )
        );

        foreach ($programs_data as $prog) {
            $pid = wp_insert_post(array(
                'post_title'  => $prog['title'],
                'post_name'   => $prog['slug'],
                'post_status' => 'publish',
                'post_type'   => 'pbi_program'
            ));

            if ($pid) {
                update_post_meta($pid, '_pbi_program_date', $prog['date']);
                update_post_meta($pid, '_pbi_program_location', $prog['loc']);
                update_post_meta($pid, '_pbi_program_status', $prog['status']);
                update_post_meta($pid, '_pbi_program_reg_url', $prog['url']);
            }
        }
    }

    // 3. Check and insert 3 Business Directory Posts
    $dir_count = wp_count_posts('pbi_directory');
    $published_dirs = isset($dir_count->publish) ? intval($dir_count->publish) : 0;
    if ($published_dirs === 0) {
        $dirs_data = array(
            array(
                'title' => 'Kripik Singkong Berkah',
                'slug'  => 'kripik-singkong-berkah',
                'owner' => 'Ibu Nani',
                'phone' => '6281234567890',
                'web'   => 'https://arumsaricorporation.co.id'
            ),
            array(
                'title' => 'Madu Murni Al-Amin',
                'slug'  => 'madu-murni-al-amin',
                'owner' => 'Pak Fulan',
                'phone' => '6281234567891',
                'web'   => 'https://arumsaricorporation.co.id'
            ),
            array(
                'title' => 'Busana Muslim Syari',
                'slug'  => 'busana-muslim-syari',
                'owner' => 'Teh Maryam',
                'phone' => '6281234567892',
                'web'   => 'https://arumsaricorporation.co.id'
            )
        );

        foreach ($dirs_data as $d) {
            $did = wp_insert_post(array(
                'post_title'  => $d['title'],
                'post_name'   => $d['slug'],
                'post_status' => 'publish',
                'post_type'   => 'pbi_directory'
            ));

            if ($did) {
                update_post_meta($did, '_pbi_biz_owner', $d['owner']);
                update_post_meta($did, '_pbi_biz_phone', $d['phone']);
                update_post_meta($did, '_pbi_biz_website', $d['web']);
            }
        }
    }

    // 4. Check and insert 60+ Past Programs (Riwayat)
    if (!get_option('pbi_past_programs_populated_v5')) {
        // Register 'Riwayat' category if it doesn't exist
        $term = get_term_by('slug', 'riwayat', 'program_cat');
        if (!$term) {
            $term_data = wp_insert_term('Riwayat', 'program_cat', array('slug' => 'riwayat'));
            $term_id = is_wp_error($term_data) ? 0 : $term_data['term_id'];
        } else {
            $term_id = $term->term_id;
        }

        $past_programs = array(
            // 2016
            array('title' => 'PB 1 Purwokerto', 'date' => '2016-06-01', 'loc' => 'The Forest, Purwokerto', 'desc' => 'Pesantren Bisnis (PB) 1 dilaksanakan pada bulan Juni 2016.'),
            array('title' => 'PB 2 Baturraden', 'date' => '2016-07-01', 'loc' => 'Baturraden, Purwokerto', 'desc' => 'Pesantren Bisnis (PB) 2 dilaksanakan pada bulan Juli 2016.'),
            array('title' => 'PB 3 Wonosobo', 'date' => '2016-08-01', 'loc' => 'Gedung BLK, Wonosobo', 'desc' => 'Pesantren Bisnis (PB) 3 dilaksanakan pada bulan Agustus 2016.'),
            array('title' => 'PB 4 Banjarnegara', 'date' => '2016-09-01', 'loc' => 'Pikas, Banjarnegara', 'desc' => 'Pesantren Bisnis (PB) 4 dilaksanakan pada bulan September 2016.'),
            array('title' => 'PB 5 Yogyakarta', 'date' => '2016-10-01', 'loc' => 'Kaliurang, Yogyakarta', 'desc' => 'Pesantren Bisnis (PB) 5 dilaksanakan pada bulan Oktober 2016.'),
            array('title' => 'PB 5 Wonosobo', 'date' => '2016-10-15', 'loc' => 'Wonosobo', 'desc' => 'Pesantren Bisnis (PB) 5 Wonosobo dilaksanakan pada bulan Oktober 2016.'),
            array('title' => 'PB 6 Malino', 'date' => '2016-11-01', 'loc' => 'Malino Sulawesi Selatan Goa', 'desc' => 'Pesantren Bisnis (PB) 6 dilaksanakan pada bulan November 2016.'),
            array('title' => 'PB 7 Bogor', 'date' => '2016-12-01', 'loc' => 'Puncak Bogor, Jabar', 'desc' => 'Pesantren Bisnis (PB) 7 dilaksanakan pada bulan Desember 2016.'),
            // 2017
            array('title' => 'BT 1 Purwokerto', 'date' => '2017-02-01', 'loc' => 'Wisma Taurus, Purwokerto', 'desc' => 'Basic Training (BT) 1 dilaksanakan pada bulan Februari 2017.'),
            array('title' => 'BT 2 Tegal', 'date' => '2017-03-01', 'loc' => 'Gedung Yaumi, Slawi Tegal', 'desc' => 'Basic Training (BT) 2 dilaksanakan pada bulan Maret 2017.'),
            array('title' => 'BT 3 Yogyakarta', 'date' => '2017-05-01', 'loc' => 'Youth Center Yogyakarta', 'desc' => 'Basic Training (BT) 3 dilaksanakan pada bulan Mei 2017.'),
            array('title' => 'BT 4 Semarang', 'date' => '2017-06-01', 'loc' => 'Gedung PMI, Semarang', 'desc' => 'Basic Training (BT) 4 dilaksanakan pada bulan Juni 2017.'),
            array('title' => 'BT 5 Magetan', 'date' => '2017-07-01', 'loc' => 'Sarangan, Magetan, Jatim', 'desc' => 'Basic Training (BT) 5 dilaksanakan pada bulan Juli 2017.'),
            array('title' => 'BT 6 Solo', 'date' => '2017-07-15', 'loc' => 'Asrama Haji Donohudan, Solo', 'desc' => 'Basic Training (BT) 6 dilaksanakan pada bulan Juli 2017.'),
            array('title' => 'BT 7 Barru', 'date' => '2017-08-01', 'loc' => 'Pesantren Alam Indonesia, Barru Sulsel', 'desc' => 'Basic Training (BT) 7 dilaksanakan pada bulan Agustus 2017.'),
            array('title' => 'BT 8 Purbalingga', 'date' => '2017-08-15', 'loc' => 'Bumper Mujuluhur, Purbalingga', 'desc' => 'Basic Training (BT) 8 dilaksanakan pada bulan Agustus 2017.'),
            array('title' => 'BT 9 Cilacap', 'date' => '2017-09-01', 'loc' => 'Cilacap', 'desc' => 'Basic Training (BT) 9 dilaksanakan pada bulan September 2017.'),
            array('title' => 'BT 10 Pasuruan', 'date' => '2017-10-01', 'loc' => 'Prigen, Pasuruan Jatim', 'desc' => 'Basic Training (BT) 10 dilaksanakan pada bulan Oktober 2017.'),
            array('title' => 'BT 11 Bandung', 'date' => '2017-11-01', 'loc' => 'Kampus 2, UNISBA, Bandung', 'desc' => 'Basic Training (BT) 11 dilaksanakan pada bulan November 2017.'),
            array('title' => 'BT 12 Boyolali', 'date' => '2017-11-15', 'loc' => 'Selo, Boyolali', 'desc' => 'Basic Training (BT) 12 dilaksanakan pada bulan November 2017.'),
            array('title' => 'BT 13 Semarang', 'date' => '2017-12-01', 'loc' => 'Bandungan, Pondok Tauhid Fullah, Semarang', 'desc' => 'Basic Training (BT) 13 dilaksanakan pada bulan Desember 2017.'),
            array('title' => 'BT 14 Maros', 'date' => '2017-12-10', 'loc' => 'Wisma Kalla, Maros, Makassar', 'desc' => 'Basic Training (BT) 14 dilaksanakan pada bulan Desember 2017.'),
            array('title' => 'BT 15 Banjarnegara', 'date' => '2017-12-20', 'loc' => 'The Pikas, Banjarnegara', 'desc' => 'Basic Training (BT) 15 dilaksanakan pada bulan Desember 2017.'),
            // 2018
            array('title' => 'BBT 16 Gontor', 'date' => '2018-01-01', 'loc' => 'Wisma Darusaalam, Gontor', 'desc' => 'Business Basic Training (BBT) 16 dilaksanakan pada bulan Januari 2018.'),
            array('title' => 'BBT 17 Brebes', 'date' => '2018-02-01', 'loc' => 'Asrama Haji, Brebes', 'desc' => 'Business Basic Training (BBT) 17 dilaksanakan pada bulan Februari 2018.'),
            array('title' => 'BBT 18 Bekasi', 'date' => '2018-03-01', 'loc' => 'Bumper Karang Kintri, Bekasi', 'desc' => 'Business Basic Training (BBT) 18 dilaksanakan pada bulan Maret 2018.'),
            array('title' => 'BBT 19 Sleman', 'date' => '2018-03-15', 'loc' => 'Youth Center, DIY Sleman', 'desc' => 'Business Basic Training (BBT) 19 dilaksanakan pada bulan Maret 2018.'),
            array('title' => 'BBT 20 Luwu Utara', 'date' => '2018-04-01', 'loc' => 'Wisma Melly Masamba, Luwu Utara, Sulawesi Selatan', 'desc' => 'Business Basic Training (BBT) 20 dilaksanakan pada bulan April 2018.'),
            array('title' => 'BBT 21 Pati', 'date' => '2018-04-15', 'loc' => 'Smk Nasional, Pati', 'desc' => 'Business Basic Training (BBT) 21 dilaksanakan pada bulan April 2018.'),
            array('title' => 'BBT 22 Kuningan', 'date' => '2018-05-01', 'loc' => 'Kebun Raya Kuningan, Jabar', 'desc' => 'Business Basic Training (BBT) 22 dilaksanakan pada bulan Mei 2018.'),
            array('title' => 'BBT 23 Lamongan', 'date' => '2018-05-15', 'loc' => 'Lamongan, Jatim', 'desc' => 'Business Basic Training (BBT) 23 dilaksanakan pada bulan Mei 2018.'),
            array('title' => 'BBT 24 Purwokerto', 'date' => '2018-06-01', 'loc' => 'Wisma Taurus, Purwokerto', 'desc' => 'Business Basic Training (BBT) 24 dilaksanakan pada bulan Juni 2018.'),
            array('title' => 'BBT 25 Wonosobo', 'date' => '2018-08-01', 'loc' => 'BLK (Balai Latihan Kerja) Wonosobo', 'desc' => 'Business Basic Training (BBT) 25 dilaksanakan pada bulan Agustus 2018.'),
            array('title' => 'BBT 26 Maros', 'date' => '2018-09-01', 'loc' => 'Pucak Teaching, Maros - Sulawesi Selatan', 'desc' => 'Business Basic Training (BBT) 26 dilaksanakan pada bulan September 2018.'),
            array('title' => 'BBT 27 Kendal', 'date' => '2018-10-01', 'loc' => 'SKB (Sekolah Kegiatan Belajar) Kendal, Jateng.', 'desc' => 'Business Basic Training (BBT) 27 dilaksanakan pada bulan Oktober 2018.'),
            array('title' => 'BBT 28 Lumajang', 'date' => '2018-11-01', 'loc' => 'Lumajang, Jatim', 'desc' => 'Business Basic Training (BBT) 28 dilaksanakan pada bulan November 2018.'),
            array('title' => 'BBT 29 Maros', 'date' => '2018-11-15', 'loc' => 'Pucak Teaching, Maros(Sulsel)', 'desc' => 'Business Basic Training (BBT) 29 dilaksanakan pada bulan November 2018.'),
            array('title' => 'BBT 30 Lombok Barat', 'date' => '2018-12-01', 'loc' => 'Lombok NTB Saudagar Tahfidz Lembar Lombok Barat', 'desc' => 'Business Basic Training (BBT) 30 dilaksanakan pada bulan Desember 2018.'),
            // 2019
            array('title' => 'BBT 31 Banjarnegara', 'date' => '2019-01-01', 'loc' => 'The Pikas, Banjarnegara', 'desc' => 'Business Basic Training (BBT) 31 dilaksanakan pada bulan Januari 2019.'),
            array('title' => 'BBT 32 Purwokerto', 'date' => '2019-05-01', 'loc' => 'Kampus VII Purwokerto', 'desc' => 'Business Basic Training (BBT) 32 dilaksanakan pada bulan Mei 2019.'),
            array('title' => 'BBT 33 Purwokerto', 'date' => '2019-06-01', 'loc' => 'Kampus VII Purwokerto', 'desc' => 'Business Basic Training (BBT) 33 dilaksanakan pada bulan Juni 2019.'),
            array('title' => 'BBT 34 Malang', 'date' => '2019-07-01', 'loc' => 'Pusdiklat Hidayatullah, Malang', 'desc' => 'Business Basic Training (BBT) 34 dilaksanakan pada bulan Juli 2019.'),
            array('title' => 'BBT 35 Grobogan', 'date' => '2019-09-01', 'loc' => 'SKB Grobogan', 'desc' => 'Business Basic Training (BBT) 35 dilaksanakan pada bulan September 2019.'),
            array('title' => 'BBT 36 Purwokerto', 'date' => '2019-09-15', 'loc' => 'Kampus VII Purwokerto', 'desc' => 'Business Basic Training (BBT) 36 dilaksanakan pada bulan September 2019.'),
            array('title' => 'BBT 37 Batu', 'date' => '2019-10-01', 'loc' => 'Batu', 'desc' => 'Business Basic Training (BBT) 37 dilaksanakan pada bulan Oktober 2019.'),
            array('title' => 'BBT 38 Purbalingga', 'date' => '2019-11-01', 'loc' => 'Bumi Perkemahan Purbalinga', 'desc' => 'Business Basic Training (BBT) 38 dilaksanakan pada bulan November 2019.'),
            array('title' => 'BBT 39 Surabaya', 'date' => '2019-11-15', 'loc' => 'Surabaya', 'desc' => 'Business Basic Training (BBT) 39 dilaksanakan pada bulan November 2019.'),
            array('title' => 'BBT 40 Pekalongan', 'date' => '2019-12-01', 'loc' => 'Batalyon Infantri 407 Pekalongan', 'desc' => 'Business Basic Training (BBT) 40 dilaksanakan pada bulan Desember 2019.'),
            array('title' => 'BBT 41 Palopo', 'date' => '2019-12-10', 'loc' => 'Palopo Sulawesi Selatan', 'desc' => 'Business Basic Training (BBT) 41 dilaksanakan pada bulan Desember 2019.'),
            array('title' => 'BBT 42 Tegal', 'date' => '2019-12-20', 'loc' => 'Bumi Jawa Tegal', 'desc' => 'Business Basic Training (BBT) 42 dilaksanakan pada bulan Desember 2019.'),
            // 2022
            array('title' => 'BBT 43 Luwu Raya', 'date' => '2022-01-01', 'loc' => 'Bone – Bone Luwu Raya', 'desc' => 'Business Basic Training (BBT) 43 dilaksanakan pada tahun 2022.'),
            array('title' => 'BBT 44 Pati', 'date' => '2022-02-01', 'loc' => 'Pati', 'desc' => 'Business Basic Training (BBT) 44 dilaksanakan pada tahun 2022.'),
            array('title' => 'BBT 45 Malang', 'date' => '2022-03-01', 'loc' => 'Malang', 'desc' => 'Business Basic Training (BBT) 45 dilaksanakan pada tahun 2022.'),
            array('title' => 'BBT 46 Kebumen', 'date' => '2022-04-01', 'loc' => 'Kebumen', 'desc' => 'Business Basic Training (BBT) 46 dilaksanakan pada tahun 2022.'),
            array('title' => 'BOT 1 Barru', 'date' => '2022-05-01', 'loc' => 'Barru Sulsel', 'desc' => 'Business Owner Training (BOT) 1 dilaksanakan pada tahun 2022.'),
            array('title' => 'BOT 2 Cilacap', 'date' => '2022-09-01', 'loc' => 'Lapangan Daun Lumbung Cilacap', 'desc' => 'Business Owner Training (BOT) 2 dilaksanakan pada bulan September 2022.'),
            array('title' => 'BOT 4 Banyuwangi', 'date' => '2022-10-01', 'loc' => 'Banyuwangi', 'desc' => 'Business Owner Training (BOT) 4 dilaksanakan pada tahun 2022.'),
            array('title' => 'BOT 5 Madura', 'date' => '2022-11-01', 'loc' => 'Madura', 'desc' => 'Business Owner Training (BOT) 5 dilaksanakan pada tahun 2022.'),
            array('title' => 'BOT 6 Wonosobo', 'date' => '2022-12-01', 'loc' => 'Wonoland Wonosobo', 'desc' => 'Business Owner Training (BOT) 6 dilaksanakan pada tahun 2022.'),
            array('title' => 'BOT 7 Lampung', 'date' => '2022-12-15', 'loc' => 'Lampung', 'desc' => 'Business Owner Training (BOT) 7 dilaksanakan pada tahun 2022.'),
            // 2023 - 2026
            array('title' => 'SPC 1 Tegal', 'date' => '2023-09-08', 'loc' => 'Tegal (8-10 September 2023)', 'desc' => 'Spiritual Preneur Camp (SPC) 1 dilaksanakan di Tegal.'),
            array('title' => 'SPC 2 Banyumas', 'date' => '2023-11-17', 'loc' => 'Banyumas (17-19 November 2023)', 'desc' => 'Spiritual Preneur Camp (SPC) 2 dilaksanakan di Banyumas.'),
            array('title' => 'SPC 3 Bandung', 'date' => '2024-01-26', 'loc' => 'Bandung (26 - 28 Januari 2024)', 'desc' => 'Spiritual Preneur Camp (SPC) 3 dilaksanakan di Bandung.'),
            array('title' => 'SPC 4 Cilacap', 'date' => '2024-09-20', 'loc' => 'Cilacap (20 - 22 September 2024)', 'desc' => 'Spiritual Preneur Camp (SPC) 4 dilaksanakan di Cilacap.'),
            array('title' => 'SPC 5 Malang', 'date' => '2024-12-06', 'loc' => 'Malang (06 - 08 Desember 2024)', 'desc' => 'Spiritual Preneur Camp (SPC) 5 dilaksanakan di Malang.'),
            array('title' => 'SPC 6 Indramayu', 'date' => '2025-05-10', 'loc' => 'Islamic Center Indramayu (10 - 12 Mei 2025)', 'desc' => 'Spiritual Preneur Camp (SPC) 6 dilaksanakan di Islamic Center Indramayu.'),
            array('title' => 'SPC 7 Purbalingga', 'date' => '2025-07-04', 'loc' => 'SMK N 1 Kaligondang, Purbalingga (4 - 6 Juli 2025)', 'desc' => 'Spiritual Preneur Camp (SPC) 7 dilaksanakan di SMK N 1 Kaligondang Purbalingga.'),
            array('title' => 'SB 01 Banjarnegara', 'date' => '2026-06-05', 'loc' => 'Pikas Banjarnegara (5 - 7 Juni 2026)', 'desc' => 'Sinergi Bisnis (SB) 01 dilaksanakan di Pikas Banjarnegara.'),
            array('title' => 'QSB 2026', 'date' => '2026-07-20', 'loc' => 'Wonosobo (sedang berlangsung bulan ini 2026)', 'desc' => 'Quantum Spiritual Business (QSB) sedang berlangsung bulan ini.')
        );

        foreach ($past_programs as $p) {
            // Slug check to avoid duplicate inserts if seeder runs
            $slug = sanitize_title($p['title'] . '-' . date('Y', strtotime($p['date'])));
            $existing_post = get_page_by_path($slug, OBJECT, 'pbi_program');
            
            if (!$existing_post) {
                $pid = wp_insert_post(array(
                    'post_title'   => $p['title'],
                    'post_name'    => $slug,
                    'post_content' => $p['desc'],
                    'post_status'  => 'publish',
                    'post_type'    => 'pbi_program'
                ));
                if ($pid) {
                    update_post_meta($pid, '_pbi_program_date', $p['date']);
                    update_post_meta($pid, '_pbi_program_location', $p['loc']);
                    update_post_meta($pid, '_pbi_program_status', 'tutup');
                    if (!empty($term_id)) {
                        wp_set_object_terms($pid, intval($term_id), 'program_cat');
                    }
                }
            }
        }
        update_option('pbi_past_programs_populated_v5', true);
    }
}
