<?php
/**
 * PBI Registration Bulk Import Script
 * Imports Google Form Responses (CSV) into pbi_registration CPT.
 * Supports dynamic column mapping (including Gender, Business Name, etc.) and idempotent enrichment.
 * 
 * Usage: Place this file in your WordPress root directory (e.g. C:\laragon\www\pesantrenbisnisindonesia\)
 * and run it via terminal: php import-registrations.php
 */

// Define CLI mode or check query parameter for browser mode
$is_cli = (php_sapi_name() === 'cli');

// Handle Cleanup request first before loading WP
if (!$is_cli && isset($_GET['clean']) && $_GET['clean'] === '1') {
    if (isset($_GET['secret']) && $_GET['secret'] === 'pbi_secret_import_2026') {
        $temp_dir = dirname(__FILE__) . '/csv-temp';
        if (is_dir($temp_dir)) {
            $files = glob($temp_dir . '/*.csv');
            foreach ($files as $file) {
                if (is_file($file)) unlink($file);
            }
            rmdir($temp_dir);
        }
        unlink(__FILE__);
        echo "=== PEMBERSIHAN SELESAI (FILE & FOLDER CSV TELAH DIHAPUS DARI SERVER) ===";
        exit;
    } else {
        die("Akses ditolak untuk pembersihan.");
    }
}

if (!$is_cli && (!isset($_GET['run']) || $_GET['run'] !== '1')) {
    die("Akses ditolak. Gunakan query string '?run=1' atau jalankan via CLI.");
}

// Load WordPress
require_once dirname(__FILE__) . '/wp-load.php';

if (!defined('ABSPATH')) {
    die("WordPress failed to load.");
}

// Ensure the user has permission to do this (if running in browser)
if (!$is_cli && !current_user_can('manage_options') && (!isset($_GET['secret']) || $_GET['secret'] !== 'pbi_secret_import_2026')) {
    die("Akses ditolak. Anda harus login sebagai Administrator.");
}

// Standarisasi Nomor HP/WhatsApp
function clean_phone($val) {
    if (empty($val)) return "";
    $val_str = trim($val);
    $digits = preg_replace('/\D/', '', $val_str);
    if (empty($digits)) return "";

    if (strpos($digits, '08') === 0) {
        $digits = '628' . substr($digits, 2);
    } elseif (strpos($digits, '8') === 0) {
        $digits = '628' . substr($digits, 1);
    } elseif (strpos($digits, '6208') === 0) {
        $digits = '628' . substr($digits, 4);
    } elseif (strpos($digits, '00') === 0) {
        $digits = substr($digits, 2);
    }

    if (strlen($digits) < 10) return "";
    return $digits;
}

// Parser CSV yang Andal (Menangani multi-line quoted fields & escaped quotes)
function parse_csv_file($filepath) {
    $content = file_get_contents($filepath);
    $result = array();
    $row = array();
    $cell = "";
    $inside_quote = false;
    $len = strlen($content);

    for ($i = 0; $i < $len; $i++) {
        $char = $content[$i];
        $next_char = isset($content[$i + 1]) ? $content[$i + 1] : '';

        if ($char === '"') {
            if ($inside_quote && $next_char === '"') {
                $cell .= '"';
                $i++;
            } else {
                $inside_quote = !$inside_quote;
            }
        } elseif ($char === ',' && !$inside_quote) {
            $row[] = $cell;
            $cell = "";
        } elseif (($char === "\r" || $char === "\n") && !$inside_quote) {
            if ($char === "\r" && $next_char === "\n") {
                $i++;
            }
            $row[] = $cell;
            $result[] = $row;
            $row = array();
            $cell = "";
        } else {
            $cell .= $char;
        }
    }

    if ($cell || count($row) > 0) {
        $row[] = $cell;
        $result[] = $row;
    }

    return array_filter($result, function($r) {
        return count($r) > 1;
    });
}

// Pemetaan Daftar File ke Nama Event PBI (Termasuk batch lama & batch baru)
$files_mapping = array(
    // 13 File Batch Lama
    array("file" => "BBT18 jabodetabek (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 18 - Jabodetabek"),
    array("file" => "Salinan BBT19 Yogyakarta (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 19 - Yogyakarta"),
    array("file" => "BT 17 Brebe (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 17 - Brebes"),
    array("file" => "BBT20 Luwu Raya Intim (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 20 - Luwu Raya"),
    array("file" => "BBT21 MURIA (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 21 - Muria"),
    array("file" => "FORM BBT#22 CIREBON (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 22 - Cirebon"),
    array("file" => "FORM BBT#23 LAMONGAN (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 23 - Lamongan"),
    array("file" => "FORM BBT#24 BANYUMAS RAYA (Responses) - Form Responses 1.csv", "event" => "Basic Training (BT) 24 - Banyumas Raya"),
    array("file" => "Salinan dari FORM BBT#26 Makassar (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 26 - Makassar"),
    array("file" => "Form BT 13 (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 13"),
    array("file" => "_BT 14 Makassar (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 14 - Makassar"),
    array("file" => "BT 15 Banjarnegara (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 15 - Banjarnegara"),
    array("file" => "BT 16 PONOROGO (Tanggapan) - Form Responses 1.csv", "event" => "Basic Training (BT) 16 - Ponorogo")
);

// 15 File Batch Baru (bbt-32.csv s/d bbt-46.csv)
for ($i = 32; $i <= 46; $i++) {
    $files_mapping[] = array(
        "file" => "bbt-{$i}.csv",
        "event" => "Basic Training (BT) {$i}"
    );
}

$downloads_dir = dirname(__FILE__) . '/csv-temp';
if (!is_dir($downloads_dir)) {
    $downloads_dir = "C:\\Users\\pange\\Downloads";
}

echo "=== MEMULAI PROSES IMPOR & UPDATE DATA PENDAFTAR GOOGLE FORM ===\n";
if (!$is_cli) {
    echo "<pre>";
}

foreach ($files_mapping as $item) {
    $csv_path = $downloads_dir . DIRECTORY_SEPARATOR . $item['file'];
    if (!file_exists($csv_path)) {
        echo "[SKIP] File tidak ditemukan: {$item['file']}\n";
        continue;
    }

    echo "\n[PROSES] Membaca file: {$item['file']}...\n";
    $rows = parse_csv_file($csv_path);

    if (count($rows) < 2) {
        echo "[WARNING] File {$item['file']} kosong atau tidak memiliki data.\n";
        continue;
    }

    // Ambil header
    $headers = array_map(function($h) {
        return trim(strtolower($h));
    }, array_shift($rows));

    echo "[INFO] Ditemukan " . count($rows) . " baris data.\n";

    // Helper cari index
    $get_idx = function($keywords) use ($headers) {
        foreach ($headers as $idx => $h) {
            foreach ($keywords as $k) {
                if (strpos($h, $k) !== false) {
                    return $idx;
                }
            }
        }
        return -1;
    };

    // Cari index kolom
    $idx_name     = $get_idx(array("nama lengkap", "nama"));
    $idx_wa       = $get_idx(array("whatsapp", "no whatsapp", "no. hp", "phone", "kontak", "nomer hp"));
    $idx_korda    = $get_idx(array("kota / kabupaten", "kabupaten", "kota"));
    $idx_provinsi = $get_idx(array("propinsi", "provinsi"));
    $idx_alamat   = $get_idx(array("alamat jalan", "alamat lengkap", "alamat rumah"));
    $idx_biz_name = $get_idx(array("nama bisnis", "nama usaha", "nama perusahaan"));
    $idx_biz_field= $get_idx(array("bidang bisnis", "bidang usaha"));
    $idx_gender   = $get_idx(array("jenis kelamin", "kelamin", "gender", "l/p", "sex"));

    $success_count = 0;
    $update_count  = 0;
    $skip_count    = 0;

    foreach ($rows as $r) {
        $raw_wa = isset($r[$idx_wa]) ? $r[$idx_wa] : '';
        $wa_clean = clean_phone($raw_wa);

        if (empty($wa_clean)) {
            $skip_count++;
            continue; // Skip jika tidak ada WA valid
        }

        // 1. Ambil & Standarkan Jenis Kelamin (Gender)
        $gender_raw = $idx_gender !== -1 && isset($r[$idx_gender]) ? trim($r[$idx_gender]) : '';
        $gender_clean = '-';
        $g_lower = strtolower($gender_raw);
        if (strpos($g_lower, 'pria') !== false || strpos($g_lower, 'laki') !== false || $g_lower === 'l') {
            $gender_clean = 'Laki-laki';
        } elseif (strpos($g_lower, 'wanita') !== false || strpos($g_lower, 'perempuan') !== false || $g_lower === 'p') {
            $gender_clean = 'Perempuan';
        }

        // Cek duplikasi di WordPress: Cari post pbi_registration dengan WhatsApp & Event yang sama
        $query = new WP_Query(array(
            'post_type'  => 'pbi_registration',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => '_pbi_reg_wa',
                    'value'   => $wa_clean,
                    'compare' => '='
                ),
                array(
                    'key'     => '_pbi_reg_event',
                    'value'   => $item['event'],
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1,
            'fields'         => 'ids'
        ));

        $post_id = 0;
        $is_update = false;

        if ($query->have_posts()) {
            $post_ids = $query->posts;
            $post_id = $post_ids[0];
            $is_update = true;
        } else {
            // Ekstrak detail data
            $nama = isset($r[$idx_name]) ? trim($r[$idx_name]) : 'Tanpa Nama';
            // Buat Post CPT pbi_registration baru
            $post_id = wp_insert_post(array(
                'post_title'   => $nama,
                'post_type'    => 'pbi_registration',
                'post_status'  => 'private',
            ));
            $is_update = false;
        }

        if ($post_id && !is_wp_error($post_id)) {
            // Ekstrak data meta lainnya
            $korda         = $idx_korda !== -1 && isset($r[$idx_korda]) ? trim($r[$idx_korda]) : '-';
            $provinsi      = $idx_provinsi !== -1 && isset($r[$idx_provinsi]) ? trim($r[$idx_provinsi]) : '-';
            $alamat        = $idx_alamat !== -1 && isset($r[$idx_alamat]) ? trim($r[$idx_alamat]) : '-';
            $nama_usaha    = $idx_biz_name !== -1 && isset($r[$idx_biz_name]) ? trim($r[$idx_biz_name]) : '-';
            $bidang_usaha  = $idx_biz_field !== -1 && isset($r[$idx_biz_field]) ? trim($r[$idx_biz_field]) : '-';

            // Bersihkan data Korda
            $korda_clean = str_replace(array('Kabupaten', 'Kab.'), '', $korda);
            $korda_clean = trim($korda_clean);

            // Isi/Update metadata
            update_post_meta($post_id, '_pbi_reg_wa', $wa_clean);
            update_post_meta($post_id, '_pbi_reg_korda', $korda_clean);
            update_post_meta($post_id, '_pbi_reg_provinsi', $provinsi);
            update_post_meta($post_id, '_pbi_reg_alamat', $alamat);
            update_post_meta($post_id, '_pbi_reg_nama_usaha', $nama_usaha);
            update_post_meta($post_id, '_pbi_reg_bidang_usaha', $bidang_usaha);
            update_post_meta($post_id, '_pbi_reg_event', $item['event']);
            update_post_meta($post_id, '_pbi_reg_gender', $gender_clean);

            if (!$is_update) {
                update_post_meta($post_id, '_pbi_reg_status', 'PENDING');
                $success_count++;
            } else {
                $update_count++;
            }
        } else {
            $skip_count++;
        }
    }

    echo "[INFO] Selesai: {$success_count} baru disimpan, {$update_count} data lama dilengkapi, {$skip_count} dilewati (tidak ada WA).\n";
}

echo "\n=== PROSES IMPOR & UPDATE SELESAI ===\n";
if (!$is_cli) {
    echo "</pre>";
}
