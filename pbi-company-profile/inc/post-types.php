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

// 2b. Register Registration / Pendaftar CPT (Private Archive)
if (!function_exists('pbi_register_registration_cpt')) {
    function pbi_register_registration_cpt() {
        $labels = array(
            'name'                  => _x('Arsip Pendaftar', 'Post type general name', 'pbi-theme'),
            'singular_name'         => _x('Pendaftar', 'Post type singular name', 'pbi-theme'),
            'menu_name'             => _x('Arsip Pendaftar', 'Admin Menu text', 'pbi-theme'),
            'add_new'               => __('Tambah Baru', 'pbi-theme'),
            'add_new_item'          => __('Tambah Pendaftar Baru', 'pbi-theme'),
            'edit_item'             => __('Edit Pendaftar', 'pbi-theme'),
            'new_item'              => __('Pendaftar Baru', 'pbi-theme'),
            'view_item'             => __('Lihat Pendaftar', 'pbi-theme'),
            'all_items'             => __('Semua Pendaftar', 'pbi-theme'),
            'search_items'          => __('Cari Pendaftar', 'pbi-theme'),
            'not_found'             => __('Pendaftar tidak ditemukan.', 'pbi-theme'),
            'not_found_in_trash'    => __('Pendaftar tidak ditemukan di tempat sampah.', 'pbi-theme'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false, // Penting: Jangan publikasikan ke web frontend (akses privat internal)
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 7,
            'menu_icon'          => 'dashicons-id-alt',
            'supports'           => array('title'), // Cukup judul (Nama Pendaftar)
            'show_in_rest'       => true,
        );

        register_post_type('pbi_registration', $args);
    }
}
add_action('init', 'pbi_register_registration_cpt');


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

// Register Business Korda Taxonomy
if (!function_exists('pbi_register_business_korda_taxonomy')) {
    function pbi_register_business_korda_taxonomy() {
        $labels = array(
            'name'              => _x('Korda / Wilayah', 'taxonomy general name', 'pbi-theme'),
            'singular_name'     => _x('Korda / Wilayah', 'taxonomy singular name', 'pbi-theme'),
            'search_items'      => __('Cari Korda / Wilayah', 'pbi-theme'),
            'all_items'         => __('Semua Korda / Wilayah', 'pbi-theme'),
            'edit_item'         => __('Edit Korda / Wilayah', 'pbi-theme'),
            'update_item'       => __('Perbarui Korda / Wilayah', 'pbi-theme'),
            'add_new_item'      => __('Tambah Korda Baru', 'pbi-theme'),
            'new_item_name'     => __('Nama Korda Baru', 'pbi-theme'),
            'menu_name'         => __('Korda / Wilayah', 'pbi-theme'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'business-korda'),
            'show_in_rest'      => true,
        );

        register_taxonomy('business_korda', array('pbi_directory'), $args);
    }
}
add_action('init', 'pbi_register_business_korda_taxonomy');

// Register Business Event Taxonomy
if (!function_exists('pbi_register_business_event_taxonomy')) {
    function pbi_register_business_event_taxonomy() {
        $labels = array(
            'name'              => _x('Event Alumni', 'taxonomy general name', 'pbi-theme'),
            'singular_name'     => _x('Event Alumni', 'taxonomy singular name', 'pbi-theme'),
            'search_items'      => __('Cari Event Alumni', 'pbi-theme'),
            'all_items'         => __('Semua Event Alumni', 'pbi-theme'),
            'edit_item'         => __('Edit Event Alumni', 'pbi-theme'),
            'update_item'       => __('Perbarui Event Alumni', 'pbi-theme'),
            'add_new_item'      => __('Tambah Event Alumni Baru', 'pbi-theme'),
            'new_item_name'     => __('Nama Event Alumni Baru', 'pbi-theme'),
            'menu_name'         => __('Event Alumni', 'pbi-theme'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'business-event'),
            'show_in_rest'      => true,
        );

        register_taxonomy('business_event', array('pbi_directory'), $args);
    }
}
add_action('init', 'pbi_register_business_event_taxonomy');

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

        // Meta box untuk Arsip Pendaftar CPT
        add_meta_box(
            'pbi_registration_details_meta',
            __('Informasi Detail Calon Peserta / Pendaftar', 'pbi-theme'),
            'pbi_render_registration_meta_box',
            'pbi_registration',
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
        $reg_url   = get_post_meta($post->ID, '_pbi_program_reg_url', true);
        $status    = get_post_meta($post->ID, '_pbi_program_status', true);

        if (empty($status)) {
            $status = 'buka';
        }

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
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: var(--pbi-primary);" for="pbi_program_reg_url">Link Pendaftaran (Form / Website) - Opsional</label>
                <input type="url" id="pbi_program_reg_url" name="pbi_program_reg_url" value="<?php echo esc_url($reg_url); ?>" placeholder="Contoh: https://registrasi.pesantrenbisnisindonesia.org/" style="width: 100%; padding: 8px; font-size: 14px;" />
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Jika dikosongkan, tombol pendaftaran di website akan otomatis diarahkan ke WhatsApp Panitia.</p>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_program_status">Status Pendaftaran</label>
                <select id="pbi_program_status" name="pbi_program_status" style="width: 100%; padding: 8px; font-size: 14px;">
                    <option value="buka" <?php selected($status, 'buka'); ?>>Buka (Daftar Sekarang)</option>
                    <option value="tutup" <?php selected($status, 'tutup'); ?>>Tutup (Pendaftaran Ditutup)</option>
                </select>
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Menentukan apakah pendaftaran di halaman depan masih dibuka atau ditutup.</p>
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

        $owner     = get_post_meta($post->ID, '_pbi_business_owner', true);
        $address   = get_post_meta($post->ID, '_pbi_business_address', true);
        $wa        = get_post_meta($post->ID, '_pbi_business_wa', true);
        $email     = get_post_meta($post->ID, '_pbi_business_email', true);
        $website   = get_post_meta($post->ID, '_pbi_business_website', true);
        $shopee    = get_post_meta($post->ID, '_pbi_business_shopee', true);
        $tokopedia = get_post_meta($post->ID, '_pbi_business_tokopedia', true);
        $maps      = get_post_meta($post->ID, '_pbi_business_maps', true);
        $price     = get_post_meta($post->ID, '_pbi_business_price', true);
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
                <?php if (!empty($wa)) : 
                    $clean_wa = preg_replace('/[^0-9]/', '', $wa);
                    $message = sprintf(
                        "Assalamualaikum %s, kami dari Admin PBI ingin mengonfirmasi apakah nomor WhatsApp ini masih aktif dan apakah Anda masih siap bergabung di Direktori Bisnis PBI?",
                        $owner
                    );
                    $wa_url = 'https://wa.me/' . $clean_wa . '?text=' . rawurlencode($message);
                ?>
                    <p style="margin: 8px 0 0 0;">
                        <a href="<?php echo esc_url($wa_url); ?>" class="button button-secondary" target="_blank" style="background-color: #25D366; color: #fff; border-color: #128C7E; text-shadow: none; display: inline-flex; align-items: center; gap: 4px; padding: 0 10px; height: 28px; line-height: 26px;">
                            <span class="dashicons dashicons-whatsapp" style="font-size: 16px; width: 16px; height: 16px; margin-top: 3px; color: white;"></span> Hubungi Owner (Cek Keaktifan)
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_email">Email Usaha</label>
                <input type="email" id="pbi_business_email" name="pbi_business_email" value="<?php echo esc_attr($email); ?>" placeholder="Contoh: admin@bisnissaya.com" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_website">Website Usaha (Jika Ada)</label>
                <input type="url" id="pbi_business_website" name="pbi_business_website" value="<?php echo esc_url($website); ?>" placeholder="Contoh: https://bisnissaya.com" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_shopee">Toko Shopee (URL) - Opsional</label>
                <input type="url" id="pbi_business_shopee" name="pbi_business_shopee" value="<?php echo esc_url($shopee); ?>" placeholder="Contoh: https://shopee.co.id/tokosejahtera" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_tokopedia">Toko Tokopedia (URL) - Opsional</label>
                <input type="url" id="pbi_business_tokopedia" name="pbi_business_tokopedia" value="<?php echo esc_url($tokopedia); ?>" placeholder="Contoh: https://tokopedia.com/tokosejahtera" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_maps">Google Maps Lokasi Usaha (URL) - Opsional</label>
                <input type="url" id="pbi_business_maps" name="pbi_business_maps" value="<?php echo esc_url($maps); ?>" placeholder="Contoh: https://maps.google.com/?q=..." style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_business_price">Kisaran Harga Produk/Jasa - Opsional</label>
                <input type="text" id="pbi_business_price" name="pbi_business_price" value="<?php echo esc_attr($price); ?>" placeholder="Contoh: Rp 50.000 - Rp 200.000" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>
        </div>
        <?php
    }
}

// Render Registration CPT Meta Box Fields
if (!function_exists('pbi_render_registration_meta_box')) {
    function pbi_render_registration_meta_box($post) {
        wp_nonce_field('pbi_save_registration_meta_nonce', 'pbi_registration_meta_nonce');

        $wa           = get_post_meta($post->ID, '_pbi_reg_wa', true);
        $korda        = get_post_meta($post->ID, '_pbi_reg_korda', true);
        $provinsi     = get_post_meta($post->ID, '_pbi_reg_provinsi', true);
        $alamat       = get_post_meta($post->ID, '_pbi_reg_alamat', true);
        $nama_usaha   = get_post_meta($post->ID, '_pbi_reg_nama_usaha', true);
        $bidang_usaha = get_post_meta($post->ID, '_pbi_reg_bidang_usaha', true);
        $event        = get_post_meta($post->ID, '_pbi_reg_event', true);
        $status       = get_post_meta($post->ID, '_pbi_reg_status', true);

        if (empty($status)) {
            $status = 'PENDING';
        }
        ?>
        <div class="pbi-meta-wrapper" style="padding: 10px 0;">
            <p style="margin-bottom: 15px; color: #64748b; font-style: italic;">Informasi arsip data pendaftar Google Form / Calon Peserta Basic Training (BT) PBI.</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_wa">No. WhatsApp / HP</label>
                <input type="text" id="pbi_reg_wa" name="pbi_reg_wa" value="<?php echo esc_attr($wa); ?>" placeholder="Contoh: 628..." style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_korda">Korda / Kabupaten</label>
                <input type="text" id="pbi_reg_korda" name="pbi_reg_korda" value="<?php echo esc_attr($korda); ?>" placeholder="Contoh: Brebes" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_provinsi">Provinsi</label>
                <input type="text" id="pbi_reg_provinsi" name="pbi_reg_provinsi" value="<?php echo esc_attr($provinsi); ?>" placeholder="Contoh: Jawa Tengah" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_alamat">Alamat Lengkap</label>
                <textarea id="pbi_reg_alamat" name="pbi_reg_alamat" rows="3" style="width: 100%; padding: 8px; font-size: 14px;"><?php echo esc_textarea($alamat); ?></textarea>
            </div>

            <div style="margin-bottom: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_nama_usaha">Nama Bisnis / Usaha</label>
                <input type="text" id="pbi_reg_nama_usaha" name="pbi_reg_nama_usaha" value="<?php echo esc_attr($nama_usaha); ?>" placeholder="Contoh: Bakso Barokah" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_bidang_usaha">Bidang Usaha</label>
                <input type="text" id="pbi_reg_bidang_usaha" name="pbi_reg_bidang_usaha" value="<?php echo esc_attr($bidang_usaha); ?>" placeholder="Contoh: Kuliner" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_event">Event Sumber / Batch Pendaftaran</label>
                <input type="text" id="pbi_reg_event" name="pbi_reg_event" value="<?php echo esc_attr($event); ?>" placeholder="Contoh: Basic Training (BT) 18 - Jabodetabek" style="width: 100%; padding: 8px; font-size: 14px;" />
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;" for="pbi_reg_status">Status Pendaftaran</label>
                <select id="pbi_reg_status" name="pbi_reg_status" style="width: 100%; padding: 8px; font-size: 14px;">
                    <option value="PENDING" <?php selected($status, 'PENDING'); ?>>PENDING (Menunggu Seleksi)</option>
                    <option value="LOLOS" <?php selected($status, 'LOLOS'); ?>>LOLOS (Terverifikasi Alumni)</option>
                    <option value="TIDAK_LOLOS" <?php selected($status, 'TIDAK_LOLOS'); ?>>TIDAK LOLOS</option>
                </select>
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
            if (isset($_POST['pbi_program_reg_url'])) {
                update_post_meta($post_id, '_pbi_program_reg_url', esc_url_raw($_POST['pbi_program_reg_url']));
            }
            if (isset($_POST['pbi_program_status'])) {
                update_post_meta($post_id, '_pbi_program_status', sanitize_text_field($_POST['pbi_program_status']));
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
            if (isset($_POST['pbi_business_shopee'])) {
                update_post_meta($post_id, '_pbi_business_shopee', esc_url_raw($_POST['pbi_business_shopee']));
            }
            if (isset($_POST['pbi_business_tokopedia'])) {
                update_post_meta($post_id, '_pbi_business_tokopedia', esc_url_raw($_POST['pbi_business_tokopedia']));
            }
            if (isset($_POST['pbi_business_maps'])) {
                update_post_meta($post_id, '_pbi_business_maps', esc_url_raw($_POST['pbi_business_maps']));
            }
            if (isset($_POST['pbi_business_price'])) {
                update_post_meta($post_id, '_pbi_business_price', sanitize_text_field($_POST['pbi_business_price']));
            }
        }

        // Save Registration Meta Fields
        if (isset($_POST['pbi_registration_meta_nonce']) && wp_verify_nonce($_POST['pbi_registration_meta_nonce'], 'pbi_save_registration_meta_nonce')) {
            if (isset($_POST['pbi_reg_wa'])) {
                $clean_wa = preg_replace('/[^0-9]/', '', $_POST['pbi_reg_wa']);
                update_post_meta($post_id, '_pbi_reg_wa', sanitize_text_field($clean_wa));
            }
            if (isset($_POST['pbi_reg_korda'])) {
                update_post_meta($post_id, '_pbi_reg_korda', sanitize_text_field($_POST['pbi_reg_korda']));
            }
            if (isset($_POST['pbi_reg_provinsi'])) {
                update_post_meta($post_id, '_pbi_reg_provinsi', sanitize_text_field($_POST['pbi_reg_provinsi']));
            }
            if (isset($_POST['pbi_reg_alamat'])) {
                update_post_meta($post_id, '_pbi_reg_alamat', sanitize_textarea_field($_POST['pbi_reg_alamat']));
            }
            if (isset($_POST['pbi_reg_nama_usaha'])) {
                update_post_meta($post_id, '_pbi_reg_nama_usaha', sanitize_text_field($_POST['pbi_reg_nama_usaha']));
            }
            if (isset($_POST['pbi_reg_bidang_usaha'])) {
                update_post_meta($post_id, '_pbi_reg_bidang_usaha', sanitize_text_field($_POST['pbi_reg_bidang_usaha']));
            }
            if (isset($_POST['pbi_reg_event'])) {
                update_post_meta($post_id, '_pbi_reg_event', sanitize_text_field($_POST['pbi_reg_event']));
            }
            if (isset($_POST['pbi_reg_status'])) {
                update_post_meta($post_id, '_pbi_reg_status', sanitize_text_field($_POST['pbi_reg_status']));
            }
        }
    }
}
add_action('save_post', 'pbi_save_custom_meta_boxes_data');

// Register REST API Custom Fields for Business Directory CPT (pbi_directory)
add_action('rest_api_init', function () {
    $fields = array(
        'owner'     => '_pbi_business_owner',
        'address'   => '_pbi_business_address',
        'wa'        => '_pbi_business_wa',
        'email'     => '_pbi_business_email',
        'website'   => '_pbi_business_website',
        'shopee'    => '_pbi_business_shopee',
        'tokopedia' => '_pbi_business_tokopedia',
        'maps'      => '_pbi_business_maps',
        'price'     => '_pbi_business_price',
    );

    foreach ($fields as $field_name => $meta_key) {
        register_rest_field('pbi_directory', $field_name, array(
            'get_callback' => function ($post_arr) use ($meta_key) {
                return get_post_meta($post_arr['id'], $meta_key, true);
            },
            'update_callback' => function ($value, $post_obj) use ($meta_key) {
                return update_post_meta($post_obj->ID, $meta_key, $value);
            },
            'schema' => array(
                'description' => $meta_key,
                'type'        => 'string',
            ),
        ));
    }

    // Register plain text description field from post content
    register_rest_field('pbi_directory', 'description', array(
        'get_callback' => function ($post_arr) {
            $post = get_post($post_arr['id']);
            if ($post) {
                return wp_strip_all_tags($post->post_content);
            }
            return '';
        },
        'schema' => array(
            'description' => 'Plain text description of the business CPT',
            'type'        => 'string',
        ),
    ));

    // Register business_korda names field
    register_rest_field('pbi_directory', 'korda_name', array(
        'get_callback' => function ($post_arr) {
            $terms = wp_get_object_terms($post_arr['id'], 'business_korda');
            if (!is_wp_error($terms) && !empty($terms)) {
                return $terms[0]->name;
            }
            return '';
        },
        'schema' => array(
            'description' => 'Nama Korda / Wilayah Alumni',
            'type'        => 'string',
        ),
    ));

    // Register business_event names field
    register_rest_field('pbi_directory', 'event_name', array(
        'get_callback' => function ($post_arr) {
            $terms = wp_get_object_terms($post_arr['id'], 'business_event');
            if (!is_wp_error($terms) && !empty($terms)) {
                return $terms[0]->name;
            }
            return '';
        },
        'schema' => array(
            'description' => 'Nama Event Alumni PBI',
            'type'        => 'string',
        ),
    ));

    // Register REST API Route to expose active theme colors to Flutter app
    register_rest_route('pbi/v1', '/theme-colors', array(
        'methods'             => 'GET',
        'callback'            => 'pbi_get_rest_theme_colors',
        'permission_callback' => '__return_true', // Publicly available
    ));
});

if (!function_exists('pbi_get_rest_theme_colors')) {
    function pbi_get_rest_theme_colors() {
        $preset = get_theme_mod('pbi_color_preset', 'emerald_gold');
        $preset_colors = array(
            'maroon_gold'  => array('primary' => '#9B1C1C', 'accent' => '#D4AF37'),
            'emerald_gold' => array('primary' => '#0B4628', 'accent' => '#D4AF37'),
            'blue_gold'    => array('primary' => '#1E3A8A', 'accent' => '#D4AF37'),
            'teal_gold'    => array('primary' => '#0F766E', 'accent' => '#D4AF37'),
        );

        $default_primary = isset($preset_colors[$preset]) ? $preset_colors[$preset]['primary'] : '#0B4628';
        $default_accent  = isset($preset_colors[$preset]) ? $preset_colors[$preset]['accent'] : '#D4AF37';

        $primary_mod = get_theme_mod('pbi_primary_color', '#0B4628');
        $accent_mod  = get_theme_mod('pbi_accent_color', '#D4AF37');

        $primary = (strcasecmp($primary_mod, '#0B4628') === 0) ? $default_primary : $primary_mod;
        $accent  = (strcasecmp($accent_mod, '#D4AF37') === 0) ? $default_accent : $accent_mod;

        return array(
            'primary' => $primary,
            'accent'  => $accent,
        );
    }
}

// =====================================================================
// 4. REGISTER ADMIN COLUMNS FOR DIREKTORI BISNIS
// =====================================================================

add_filter('manage_pbi_directory_posts_columns', 'pbi_directory_set_custom_columns');
if (!function_exists('pbi_directory_set_custom_columns')) {
    function pbi_directory_set_custom_columns($columns) {
        $new_columns = array();
        foreach ($columns as $key => $title) {
            $new_columns[$key] = $title;
            if ($key === 'title') {
                $new_columns['business_owner'] = __('Pemilik Usaha', 'pbi-theme');
                $new_columns['business_wa']    = __('No. WA', 'pbi-theme');
                $new_columns['korda']          = __('Korda / Wilayah', 'pbi-theme');
                $new_columns['wa_action']      = __('Aksi Japri WA', 'pbi-theme');
            }
        }
        return $new_columns;
    }
}

add_action('manage_pbi_directory_posts_custom_column', 'pbi_directory_populate_custom_columns', 10, 2);
if (!function_exists('pbi_directory_populate_custom_columns')) {
    function pbi_directory_populate_custom_columns($column, $post_id) {
        switch ($column) {
            case 'business_owner':
                $owner = get_post_meta($post_id, '_pbi_business_owner', true);
                echo esc_html($owner ? $owner : '-');
                break;
                
            case 'business_wa':
                $wa = get_post_meta($post_id, '_pbi_business_wa', true);
                echo esc_html($wa ? $wa : '-');
                break;
                
            case 'korda':
                $terms = wp_get_post_terms($post_id, 'business_korda');
                if (!is_wp_error($terms) && !empty($terms)) {
                    echo esc_html($terms[0]->name);
                } else {
                    echo '-';
                }
                break;
                
            case 'wa_action':
                $wa = get_post_meta($post_id, '_pbi_business_wa', true);
                $owner = get_post_meta($post_id, '_pbi_business_owner', true);
                if (!empty($wa)) {
                    $clean_wa = preg_replace('/[^0-9]/', '', $wa);
                    $message = sprintf(
                        "Assalamualaikum %s, kami dari Admin PBI ingin mengonfirmasi apakah nomor WhatsApp ini masih aktif dan apakah Anda masih siap bergabung di Direktori Bisnis PBI?",
                        $owner
                    );
                    $wa_url = 'https://wa.me/' . $clean_wa . '?text=' . rawurlencode($message);
                    echo '<a href="' . esc_url($wa_url) . '" class="button button-small" target="_blank" style="background-color: #25D366; color: #fff; border-color: #128C7E; display: inline-flex; align-items: center; gap: 4px;"><span class="dashicons dashicons-whatsapp" style="font-size: 15px; width:15px; height:15px; margin-top:2px; color:white;"></span> Japri WA</a>';
                } else {
                    echo '-';
                }
                break;
        }
    }
}

// =====================================================================
// 5. RESTRICT ACCESS TO DIRECTORIES FOR MEMBERS ONLY (LOGGED IN)
// =====================================================================

add_action('template_redirect', 'pbi_restrict_directory_access');
if (!function_exists('pbi_restrict_directory_access')) {
    function pbi_restrict_directory_access() {
        // Redirect the empty static page to the actual CPT archive
        if (is_page('direktori-umkm')) {
            wp_redirect(get_post_type_archive_link('pbi_directory'));
            exit;
        }

        // Hanya batasi akses halaman detail bisnis (singular) secara ketat untuk user yang belum login
        if (is_singular('pbi_directory')) {
            if (!is_user_logged_in()) {
                // Arahkan ke halaman masuk-anggota agar mereka mendapat info pendaftaran & link login
                wp_redirect(home_url('/masuk-anggota/?redirect_to=' . urlencode(get_permalink())));
                exit;
            }
        }
    }
}

// =====================================================================
// 6. INCLUDE DIREKTORI BISNIS IN TAXONOMY ARCHIVES
// =====================================================================

add_action('pre_get_posts', 'pbi_modify_archive_query');
if (!function_exists('pbi_modify_archive_query')) {
    function pbi_modify_archive_query($query) {
        if (!is_admin() && $query->is_main_query()) {
            if (is_tax('business_korda') || is_tax('business_event') || is_tax('business_cat')) {
                $query->set('post_type', array('pbi_directory'));
            }
        }
    }
}

// =====================================================================
// 7. AUTO-FLUSH REWRITE RULES ON NEW CUSTOM TAXONOMIES REGISTER
// =====================================================================

add_action('init', 'pbi_flush_rules_on_new_register', 99);
if (!function_exists('pbi_flush_rules_on_new_register')) {
    function pbi_flush_rules_on_new_register() {
        if (get_transient('pbi_flush_rewrite_rules_v5')) {
            flush_rewrite_rules(false);
            delete_transient('pbi_flush_rewrite_rules_v5');
        }
    }
}
if (false === get_transient('pbi_flush_rewrite_rules_v5')) {
    set_transient('pbi_flush_rewrite_rules_v5', true, 3600);
}

// =====================================================================
// 8. PROGRAMMATICALLY CREATE "MASUK ANGGOTA" PAGE IF NOT EXISTS
// =====================================================================

add_action('init', 'pbi_create_masuk_anggota_page');
if (!function_exists('pbi_create_masuk_anggota_page')) {
    function pbi_create_masuk_anggota_page() {
        $slug = 'masuk-anggota';
        $page = get_page_by_path($slug);
        if (!$page) {
            wp_insert_post(array(
                'post_title'    => 'Masuk Anggota',
                'post_name'     => $slug,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_content'  => '', // Handled by page-masuk-anggota.php template
            ));
        }
    }
}





