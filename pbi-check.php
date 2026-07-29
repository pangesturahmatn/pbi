<?php
/**
 * PBI REST API Diagnostic
 * Upload ke: public_html/pbi-check.php
 * Akses via browser: https://pesantrenbisnisindonesia.org/pbi-check.php
 * HAPUS FILE INI SETELAH SELESAI DIAGNOSA!
 */

// Load WordPress minimal
define('SHORTINIT', true);
require_once(dirname(__FILE__) . '/wp-load.php');

$results = [];

// Test 1: WordPress URL settings
$results['wp_siteurl'] = get_option('siteurl');
$results['wp_home']    = get_option('home');

// Test 2: REST API URL
$rest_url = get_rest_url(null, '/wp/v2/posts');
$results['rest_url'] = $rest_url;

// Test 3: Cek apakah REST API aktif
$results['rest_enabled'] = rest_get_url_prefix();

// Test 4: HTTPS detection
$results['server_https']       = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : 'NOT SET';
$results['forwarded_proto']    = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : 'NOT SET';
$results['request_scheme']     = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'NOT SET';

// Test 5: Cek REST API response langsung
$api_response = wp_remote_get($rest_url, [
    'timeout'   => 10,
    'sslverify' => false,
]);

if (is_wp_error($api_response)) {
    $results['rest_api_test'] = 'ERROR: ' . $api_response->get_error_message();
    $results['rest_api_body'] = 'N/A';
} else {
    $body = wp_remote_retrieve_body($api_response);
    $code = wp_remote_retrieve_response_code($api_response);
    $results['rest_api_http_code'] = $code;
    $json = json_decode($body);
    if (json_last_error() === JSON_ERROR_NONE) {
        $results['rest_api_test'] = '✅ VALID JSON — REST API berfungsi normal!';
    } else {
        $results['rest_api_test'] = '❌ BUKAN JSON — Server mengembalikan sesuatu yang salah!';
        $results['rest_api_body_preview'] = htmlspecialchars(substr($body, 0, 300));
    }
}

// Output hasil
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>PBI REST API Diagnostic</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1a1a2e; color: #eee; }
        h1 { color: #e94560; }
        .ok { color: #4ecca3; }
        .fail { color: #e94560; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        td, th { border: 1px solid #444; padding: 10px; text-align: left; }
        th { background: #16213e; color: #4ecca3; }
        tr:nth-child(even) { background: #0f3460; }
        .warning { background: #e94560; color: #fff; padding: 15px; border-radius: 5px; margin: 15px 0; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🔍 PBI REST API Diagnostic</h1>
    <p class="warning">⚠️ HAPUS file ini setelah selesai diagnosa! Akses: /pbi-check.php</p>
    
    <table>
        <tr><th>Parameter</th><th>Nilai</th></tr>
        <?php foreach ($results as $key => $value): ?>
        <tr>
            <td><?= esc_html($key) ?></td>
            <td class="<?= (strpos((string)$value, '✅') !== false) ? 'ok' : ((strpos((string)$value, '❌') !== false || strpos((string)$value, 'ERROR') !== false) ? 'fail' : '') ?>">
                <?= $value ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Solusi Berdasarkan Hasil:</h2>
    <?php if (isset($results['wp_siteurl']) && strpos($results['wp_siteurl'], 'http://') === 0): ?>
        <div class="warning">
            ❌ MASALAH DITEMUKAN: WordPress URL masih HTTP (<code><?= $results['wp_siteurl'] ?></code>)<br>
            tapi situs diakses via HTTPS. Ini penyebab "not valid JSON"!<br><br>
            Fix: Tambahkan ke wp-config.php:<br>
            <code>define('WP_HOME', 'https://pesantrenbisnisindonesia.org');</code><br>
            <code>define('WP_SITEURL', 'https://pesantrenbisnisindonesia.org');</code>
        </div>
    <?php endif; ?>
</body>
</html>
