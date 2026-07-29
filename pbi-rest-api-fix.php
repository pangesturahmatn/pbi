<?php
/**
 * Plugin Name: PBI REST API Fix
 * Description: Memastikan WordPress REST API bekerja normal untuk Gutenberg editor.
 * Version: 1.0
 * Author: Official PBI
 */

defined('ABSPATH') || exit;

/**
 * 1. Mulai output buffering di awal request
 *    Mencegah output tidak terduga (PHP warning/notice/BOM) merusak JSON response
 */
if (!ob_get_level()) {
    ob_start();
}

/**
 * 2. Paksa bersihkan buffer tepat sebelum REST API mengirim response
 */
add_filter('rest_pre_serve_request', function ($served, $result, $request) {
    if (ob_get_length() > 0) {
        ob_clean();
    }
    return $served;
}, 1, 3);

/**
 * 3. Pastikan REST API autentikasi tidak diblokir
 *    Return null = biarkan WordPress handle secara normal
 */
add_filter('rest_authentication_errors', function ($result) {
    if (is_wp_error($result)) {
        return $result; // Hanya kembalikan error asli jika ada
    }
    return null; // Izinkan WordPress verifikasi sendiri
}, 100);

/**
 * 4. Fix untuk hosting dengan HTTPS/SSL di balik reverse proxy
 *    (Sangat umum di cPanel shared hosting)
 */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
    $_SERVER['HTTPS'] = 'on';
}

/**
 * 5. Paksa WordPress URL menggunakan HTTPS agar nonce cocok
 */
add_filter('rest_url', function ($url) {
    if (is_ssl() || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
        $url = str_replace('http://', 'https://', $url);
    }
    return $url;
});

/**
 * 6. Tambah header CORS untuk mencegah pemblokiran cross-origin
 */
add_action('rest_api_init', function () {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function ($value) {
        $origin = get_http_origin();
        if ($origin) {
            header('Access-Control-Allow-Origin: ' . esc_url_raw($origin));
        } else {
            header('Access-Control-Allow-Origin: *');
        }
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce');
        return $value;
    });
}, 15);

/**
 * 7. Nonaktifkan XML-RPC jika tidak dipakai (keamanan)
 */
add_filter('xmlrpc_enabled', '__return_false');
