<?php
/**
 * Register Custom Post Types & Taxonomies
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

// 1. Register Program CPT
if (!function_exists('pbi_register_program_cpt')) {
    function pbi_register_program_cpt() {
        $labels = array(
            'name'                  => _x('Program & Kegiatan', 'Post type general name', 'pbi-theme'),
            'singular_name'         => _x('Program', 'Post type singular name', 'pbi-theme'),
            'menu_name'             => _x('Program PBI', 'Admin Menu text', 'pbi-theme'),
            'add_new'               => __('Tambah Baru', 'pbi-theme'),
            'add_new_item'          => __('Tambah Program Baru', 'pbi-theme'),
            'edit_item'             => __('Edit Program', 'pbi-theme'),
            'new_item'              => __('Program Baru', 'pbi-theme'),
            'view_item'             => __('Lihat Program', 'pbi-theme'),
            'all_items'             => __('Semua Program', 'pbi-theme'),
            'search_items'          => __('Cari Program', 'pbi-theme'),
            'not_found'             => __('Program tidak ditemukan.', 'pbi-theme'),
            'not_found_in_trash'    => __('Program tidak ditemukan di tempat sampah.', 'pbi-theme'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'program'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-welcome-learn-more',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'       => true, // Enable Gutenberg editor
        );

        register_post_type('pbi_program', $args);
    }
}
add_action('init', 'pbi_register_program_cpt');

// Register Program Category Taxonomy
if (!function_exists('pbi_register_program_taxonomy')) {
    function pbi_register_program_taxonomy() {
        $labels = array(
            'name'              => _x('Kategori Program', 'taxonomy general name', 'pbi-theme'),
            'singular_name'     => _x('Kategori Program', 'taxonomy singular name', 'pbi-theme'),
            'search_items'      => __('Cari Kategori', 'pbi-theme'),
            'all_items'         => __('Semua Kategori', 'pbi-theme'),
            'parent_item'       => __('Kategori Induk', 'pbi-theme'),
            'parent_item_colon' => __('Kategori Induk:', 'pbi-theme'),
            'edit_item'         => __('Edit Kategori', 'pbi-theme'),
            'update_item'       => __('Perbarui Kategori', 'pbi-theme'),
            'add_new_item'      => __('Tambah Kategori Baru', 'pbi-theme'),
            'new_item_name'     => __('Nama Kategori Baru', 'pbi-theme'),
            'menu_name'         => __('Kategori Program', 'pbi-theme'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'program-cat'),
            'show_in_rest'      => true,
        );

        register_taxonomy('program_cat', array('pbi_program'), $args);
    }
}
add_action('init', 'pbi_register_program_taxonomy');


// 2. Register Business Directory CPT
if (!function_exists('pbi_register_directory_cpt')) {
    function pbi_register_directory_cpt() {
        $labels = array(
            'name'                  => _x('Direktori Bisnis', 'Post type general name', 'pbi-theme'),
            'singular_name'         => _x('Bisnis Member', 'Post type singular name', 'pbi-theme'),
            'menu_name'             => _x('Direktori Bisnis', 'Admin Menu text', 'pbi-theme'),
            'add_new'               => __('Tambah Baru', 'pbi-theme'),
            'add_new_item'          => __('Tambah Bisnis Baru', 'pbi-theme'),
            'edit_item'             => __('Edit Bisnis', 'pbi-theme'),
            'new_item'              => __('Bisnis Baru', 'pbi-theme'),
            'view_item'             => __('Lihat Bisnis', 'pbi-theme'),
            'all_items'             => __('Semua Bisnis', 'pbi-theme'),
            'search_items'          => __('Cari Bisnis', 'pbi-theme'),
            'not_found'             => __('Bisnis tidak ditemukan.', 'pbi-theme'),
            'not_found_in_trash'    => __('Bisnis tidak ditemukan di tempat sampah.', 'pbi-theme'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'bisnis-member'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-store',
            'supports'           => array('title', 'editor', 'thumbnail'),
            'show_in_rest'       => true,
        );

        register_post_type('pbi_directory', $args);
    }
}
add_action('init', 'pbi_register_directory_cpt');

// Register Business Category Taxonomy
if (!function_exists('pbi_register_business_taxonomy')) {
    function pbi_register_business_taxonomy() {
        $labels = array(
            'name'              => _x('Bidang Usaha', 'taxonomy general name', 'pbi-theme'),
            'singular_name'     => _x('Bidang Usaha', 'taxonomy singular name', 'pbi-theme'),
            'search_items'      => __('Cari Bidang Usaha', 'pbi-theme'),
            'all_items'         => __('Semua Bidang Usaha', 'pbi-theme'),
            'edit_item'         => __('Edit Bidang Usaha', 'pbi-theme'),
            'update_item'       => __('Perbarui Bidang Usaha', 'pbi-theme'),
            'add_new_item'      => __('Tambah Bidang Usaha Baru', 'pbi-theme'),
            'new_item_name'     => __('Nama Bidang Usaha Baru', 'pbi-theme'),
            'menu_name'         => __('Bidang Usaha', 'pbi-theme'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'business-cat'),
            'show_in_rest'      => true,
        );

        register_taxonomy('business_cat', array('pbi_directory'), $args);
    }
}
add_action('init', 'pbi_register_business_taxonomy');

// =====================================================================
// 3. REGISTER CUSTOM META BOXES (INPUT FIELDS IN EDITOR PANEL)
//    Membantu user memasukkan tanggal, waktu, lokasi, dan kontak
//    tanpa perlu menulis HTML atau edit manual di dalam kotak teks.
// =====================================================================

// Add Meta Boxes
if (!function_exists('pbi_add_custom_meta_boxes')) {
    function pbi_add_custom_meta_boxes() {
        // Meta box untuk Program CPT
        add_meta_box(
            'pbi_program_details_meta',
            __('Detail Pelaksanaan & Pendaftaran Program', 'pbi-theme'),
            'pbi_render_program_meta_box',
            'pbi_program',
            'normal',
            'high'
        );

        // Meta box untuk Direktori Bisnis CPT
        add_meta_box(
            'pbi_directory_details_meta',
            __('Informasi Detail Usaha / UMKM Member', 'pbi-theme'),
            'pbi_render_directory_meta_box',
            'pbi_directory',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'pbi_add_custom_meta_boxes');

// Render Program CPT Meta Box Fields
if (!function_exists('pbi_render_program_meta_box')) {
    function pbi_render_program_meta_box($post) {
        wp_nonce_field('pbi_save_program_meta_nonce', 'pbi_program_meta_nonce');

        $date      = get_post_meta($post->ID, '_pbi_program_date', true);
        $time      = get_post_meta($post->ID, '_pbi_program_time', true);
        $location  = get_post_meta($post->ID, '_pbi_program_location', true);
        $wa        = get_post_meta($post->ID, '_pbi_program_wa', true);
        $countdown = get_post_meta($post->ID, '_pbi_program_countdown_target', true);

        // Set default WhatsApp if empty
        if (empty($wa)) {
            $wa = get_theme_mod('pbi_social_whatsapp', '6281334537381');
        }
        ?>
        <div class="pbi-meta-wrapper" style="padding: 10px 0;">
            <p style="margin-bottom: 15px; color: #64748b; font-style: italic;">Isi detail pelaksanaan di bawah ini. Informasi ini akan ditampilkan secara otomatis dalam format kartu yang menarik di website.</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_program_date">Tanggal Pelaksanaan *</label>
                <input type="text" id="pbi_program_date" name="pbi_program_date" value="<?php echo esc_attr($date); ?>" placeholder="Contoh: 15 - 18 Agustus 2026" style="width: 100%; padding: 8px; font-size: 14px;" required />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_program_time">Jam / Waktu Pelaksanaan</label>
                <input type="text" id="pbi_program_time" name="pbi_program_time" value="<?php echo esc_attr($time); ?>" placeholder="Contoh: 08.00 WIB - Selesai" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_program_location">Lokasi / Tempat Pelaksanaan</label>
                <input type="text" id="pbi_program_location" name="pbi_program_location" value="<?php echo esc_attr($location); ?>" placeholder="Contoh: Banjarnegara, Jawa Tengah atau Online via Zoom" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_program_wa">No. WhatsApp Panitia Pendaftaran (Khusus Program ini)</label>
                <input type="text" id="pbi_program_wa" name="pbi_program_wa" value="<?php echo esc_attr($wa); ?>" placeholder="Contoh: 6281334537381 (Gunakan awalan 62 tanpa spasi/tanda hubung)" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: var(--pbi-primary);" for="pbi_program_countdown_target">Tanggal Target Hitung Mundur (Countdown Timer) - Optional</label>
                <input type="date" id="pbi_program_countdown_target" name="pbi_program_countdown_target" value="<?php echo esc_attr($countdown); ?>" style="width: 100%; padding: 8px; font-size: 14px;" />
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Pilih tanggal mulai acara jika Anda ingin menampilkan countdown timer interaktif di halaman detail program ini.</p>
            </div>
        </div>
        <?php
    }
}

// Render Directory CPT Meta Box Fields
if (!function_exists('pbi_render_directory_meta_box')) {
    function pbi_render_directory_meta_box($post) {
        wp_nonce_field('pbi_save_directory_meta_nonce', 'pbi_directory_meta_nonce');

        $owner   = get_post_meta($post->ID, '_pbi_business_owner', true);
        $address = get_post_meta($post->ID, '_pbi_business_address', true);
        $wa      = get_post_meta($post->ID, '_pbi_business_wa', true);
        $email   = get_post_meta($post->ID, '_pbi_business_email', true);
        $website = get_post_meta($post->ID, '_pbi_business_website', true);
        ?>
        <div class="pbi-meta-wrapper" style="padding: 10px 0;">
            <p style="margin-bottom: 15px; color: #64748b; font-style: italic;">Lengkapi profil usaha anggota di bawah ini agar terjalin kolaborasi dan jaringan perdagangan nasional yang profesional.</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_owner">Nama Pemilik Usaha (Alumni/Member) *</label>
                <input type="text" id="pbi_business_owner" name="pbi_business_owner" value="<?php echo esc_attr($owner); ?>" placeholder="Contoh: Abu Syamil" style="width: 100%; padding: 8px; font-size: 14px;" required />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_address">Alamat Lengkap Usaha *</label>
                <input type="text" id="pbi_business_address" name="pbi_business_address" value="<?php echo esc_attr($address); ?>" placeholder="Contoh: Jl. Pemuda No. 45, Banjarnegara, Jawa Tengah" style="width: 100%; padding: 8px; font-size: 14px;" required />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_wa">No. WhatsApp Bisnis *</label>
                <input type="text" id="pbi_business_wa" name="pbi_business_wa" value="<?php echo esc_attr($wa); ?>" placeholder="Contoh: 6281334537381 (Gunakan awalan 62 tanpa spasi/tanda hubung)" style="width: 100%; padding: 8px; font-size: 14px;" required />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_email">Email Usaha</label>
                <input type="email" id="pbi_business_email" name="pbi_business_email" value="<?php echo esc_attr($email); ?>" placeholder="Contoh: admin@bisnissaya.com" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_website">Website Usaha (Jika Ada)</label>
                <input type="url" id="pbi_business_website" name="pbi_business_website" value="<?php echo esc_attr($website); ?>" placeholder="Contoh: https://bisnissaya.com" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>
        </div>
        <?php
    }
}

// Save Meta Box Data
if (!function_exists('pbi_save_custom_meta_boxes_data')) {
    function pbi_save_custom_meta_boxes_data($post_id) {
        // Cek jika autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Cek izin akses user
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save Program Meta Fields
        if (isset($_POST['pbi_program_meta_nonce']) && wp_verify_nonce($_POST['pbi_program_meta_nonce'], 'pbi_save_program_meta_nonce')) {
            if (isset($_POST['pbi_program_date'])) {
                update_post_meta($post_id, '_pbi_program_date', sanitize_text_field($_POST['pbi_program_date']));
            }
            if (isset($_POST['pbi_program_time'])) {
                update_post_meta($post_id, '_pbi_program_time', sanitize_text_field($_POST['pbi_program_time']));
            }
            if (isset($_POST['pbi_program_location'])) {
                update_post_meta($post_id, '_pbi_program_location', sanitize_text_field($_POST['pbi_program_location']));
            }
            if (isset($_POST['pbi_program_wa'])) {
                // Bersihkan karakter non-digit untuk WhatsApp
                $clean_wa = preg_replace('/[^0-9]/', '', $_POST['pbi_program_wa']);
                update_post_meta($post_id, '_pbi_program_wa', sanitize_text_field($clean_wa));
            }
            if (isset($_POST['pbi_program_countdown_target'])) {
                update_post_meta($post_id, '_pbi_program_countdown_target', sanitize_text_field($_POST['pbi_program_countdown_target']));
            }
        }

        // Save Directory Meta Fields
        if (isset($_POST['pbi_directory_meta_nonce']) && wp_verify_nonce($_POST['pbi_directory_meta_nonce'], 'pbi_save_directory_meta_nonce')) {
            if (isset($_POST['pbi_business_owner'])) {
                update_post_meta($post_id, '_pbi_business_owner', sanitize_text_field($_POST['pbi_business_owner']));
            }
            if (isset($_POST['pbi_business_address'])) {
                update_post_meta($post_id, '_pbi_business_address', sanitize_text_field($_POST['pbi_business_address']));
            }
            if (isset($_POST['pbi_business_wa'])) {
                $clean_wa = preg_replace('/[^0-9]/', '', $_POST['pbi_business_wa']);
                update_post_meta($post_id, '_pbi_business_wa', sanitize_text_field($clean_wa));
            }
            if (isset($_POST['pbi_business_email'])) {
                update_post_meta($post_id, '_pbi_business_email', sanitize_email($_POST['pbi_business_email']));
            }
            if (isset($_POST['pbi_business_website'])) {
                update_post_meta($post_id, '_pbi_business_website', esc_url_raw($_POST['pbi_business_website']));
            }
        }
    }
}
add_action('save_post', 'pbi_save_custom_meta_boxes_data');

