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

// Belah nomor HP yang digabung tanpa pemisah
function split_merged_phone($val) {
    $digits = preg_replace('/\D/', '', $val);
    if (strlen($digits) >= 20) {
        for ($pos = 10; $pos <= 14; $pos++) {
            if ($pos < strlen($digits) - 8) {
                $sub = substr($digits, $pos);
                if (strpos($sub, '08') === 0 || strpos($sub, '628') === 0) {
                    $part1 = substr($digits, 0, $pos);
                    $part2 = $sub;
                    return array($part1, $part2);
                }
            }
        }
    }
    return array($val, '');
}

// Proses pemisahan nomor WhatsApp 1 dan 2
function process_whatsapp_numbers($val) {
    if (empty($val)) return array('', '');
    $val_clean = trim($val);

    if (preg_match('/[\/,\;&]|dan|atau/i', $val_clean)) {
        $cleaned_val = preg_replace('/[\/,\;&]|dan|atau/i', ',', $val_clean);
        $parts = explode(',', $cleaned_val);
        $p1 = clean_phone($parts[0]);
        $p2 = isset($parts[1]) ? clean_phone($parts[1]) : '';
        return array($p1, $p2);
    }

    $digits_only = preg_replace('/\D/', '', $val_clean);
    if (strpos($val_clean, ' ') !== false && strlen($digits_only) >= 20) {
        $parts = preg_split('/\s+/', $val_clean);
        $p1 = clean_phone($parts[0]);
        $p2 = isset($parts[1]) ? clean_phone($parts[1]) : '';
        return array($p1, $p2);
    }

    if (strlen($digits_only) >= 20) {
        $split = split_merged_phone($digits_only);
        $p1 = clean_phone($split[0]);
        $p2 = clean_phone($split[1]);
        return array($p1, $p2);
    }

    return array(clean_phone($val_clean), '');
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

// 15 File Batch Baru (bbt-32.csv s/d bbt-46.csv) dengan nama program asli di database
$bbt_cities = array(
    32 => 'Purwokerto',
    33 => 'Purwokerto',
    34 => 'Malang',
    35 => 'Grobogan',
    36 => 'Purwokerto',
    37 => 'Batu',
    38 => 'Purbalingga',
    39 => 'Surabaya',
    40 => 'Pekalongan',
    41 => 'Palopo',
    42 => 'Tegal',
    43 => 'Luwu Raya',
    44 => 'Pati',
    45 => 'Malang',
    46 => 'Kebumen'
);
for ($i = 32; $i <= 46; $i++) {
    $city = isset($bbt_cities[$i]) ? ' ' . $bbt_cities[$i] : '';
    $files_mapping[] = array(
        "file" => "bbt-{$i}.csv",
        "event" => "BBT {$i}{$city}"
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

    // Cek apakah baris pertama valid sebagai header kolom (mengandung kata kunci umum)
    $first_row_str = implode(' ', array_map('strtolower', $rows[0]));
    $is_header_valid = false;
    $header_keywords = array("nama", "member", "whatsapp", "wa", "hp", "phone", "kontak", "korda", "kota", "kabupaten", "provinsi");
    foreach ($header_keywords as $keyword) {
        if (strpos($first_row_str, $keyword) !== false) {
            $is_header_valid = true;
            break;
        }
    }

    // Jika baris pertama dideteksi sebagai judul banner (bukan header), geser ke baris berikutnya
    if (!$is_header_valid && count($rows) > 1) {
        echo "[INFO] Baris pertama dilewati karena dideteksi sebagai judul banner.\n";
        array_shift($rows); // Buang baris judul
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
                // Jika keyword adalah 'wa' atau 'hp', gunakan regex kata utuh (\b) agar tidak mencocokkan 'kewarganegaraan' atau 'tahapan'
                if ($k === 'wa' || $k === 'hp') {
                    if (preg_match('/\b' . preg_quote($k) . '\b/', $h)) {
                        return $idx;
                    }
                } else {
                    if (strpos($h, $k) !== false) {
                        return $idx;
                    }
                }
            }
        }
        return -1;
    };

    // Cari index kolom
    $idx_name     = $get_idx(array("nama lengkap", "nama member", "nama"));
    $idx_wa       = $get_idx(array("whatsapp", "no whatsapp", "no. hp", "phone", "kontak", "nomer hp", "no wa", "no. wa", "wa", "hp"));
    $idx_korda    = $get_idx(array("kota / kabupaten", "kabupaten", "kota", "korda"));
    $idx_provinsi = $get_idx(array("propinsi", "provinsi"));
    $idx_alamat   = $get_idx(array("alamat jalan", "alamat lengkap", "alamat rumah"));
    $idx_biz_name = $get_idx(array("nama bisnis", "nama usaha", "nama perusahaan"));
    $idx_biz_field= $get_idx(array("bidang bisnis", "bidang usaha"));
    $idx_gender   = $get_idx(array("jenis kelamin", "kelamin", "gender", "l/p", "sex"));

    // Fallback Auto-Detect Kolom WhatsApp jika tidak terdeteksi via nama header
    if ($idx_wa === -1 && count($rows) > 0) {
        $first_row = $rows[0];
        foreach ($first_row as $idx => $val) {
            $val_clean = preg_replace('/\D/', '', $val);
            // Jika kolom berisi angka saja dengan panjang nomor telepon (10-15 digit)
            if (strlen($val_clean) >= 10 && strlen($val_clean) <= 15) {
                // Hindari kolom NIK / ID Card (biasanya berawalan 000 atau digit lain tanpa kode telp)
                // Deteksi nomor telepon valid (berawalan 08, 628, 8, +628, +8, atau mengandung wa.me)
                $val_trim = trim($val);
                if (preg_match('/^(08|628|\+628|8|\+8|wa\.me)/', $val_trim) || strpos($val_trim, 'wa.me') !== false) {
                    $idx_wa = $idx;
                    echo "[INFO] Auto-detect kolom WhatsApp berada di indeks ke-{$idx}\n";
                    break;
                }
            }
        }
    }

    $success_count = 0;
    $update_count  = 0;
    $skip_count    = 0;

    foreach ($rows as $r) {
        $raw_wa = isset($r[$idx_wa]) ? $r[$idx_wa] : '';
        $nama = isset($r[$idx_name]) ? trim($r[$idx_name]) : '';
        if (empty($nama)) {
            $nama = 'Tanpa Nama';
        }
        
        // Memproses & Memisahkan WhatsApp Utama dan Alternatif
        list($wa1, $wa2) = process_whatsapp_numbers($raw_wa);

        // Jika tidak ada nomor WA, dan namanya juga kosong/tanpa nama, barulah kita skip.
        // Ini memungkinkan data pendaftar tanpa nomor telepon tetap ter-impor secara aman.
        if (empty($wa1) && $nama === 'Tanpa Nama') {
            $skip_count++;
            continue;
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

        $post_id = 0;
        $is_update = false;

        // Cek duplikasi di WordPress dengan aman (mendukung status 'any' karena post_type pbi_registration ber-status 'private')
        if (!empty($wa1)) {
            // Jika ada WhatsApp, cari berdasarkan WhatsApp & Event
            $query = new WP_Query(array(
                'post_type'   => 'pbi_registration',
                'post_status' => 'any',
                'meta_query'  => array(
                    'relation' => 'AND',
                    array(
                        'key'     => '_pbi_reg_wa',
                        'value'   => $wa1,
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
        } else {
            // Jika WhatsApp kosong, cari berdasarkan Nama (post_title) & Event
            $query = new WP_Query(array(
                'post_type'   => 'pbi_registration',
                'post_status' => 'any',
                'title'       => $nama,
                'meta_query'  => array(
                    array(
                        'key'     => '_pbi_reg_event',
                        'value'   => $item['event'],
                        'compare' => '='
                    )
                ),
                'posts_per_page' => 1,
                'fields'         => 'ids'
            ));
        }

        if ($query->have_posts()) {
            $post_ids = $query->posts;
            $post_id = $post_ids[0];
            $is_update = true;
        } else {
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
            update_post_meta($post_id, '_pbi_reg_wa', $wa1);
            update_post_meta($post_id, '_pbi_reg_wa_alt', $wa2); // Simpan nomor alternatif
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

    echo "[INFO] Selesai: {$success_count} baru disimpan, {$update_count} data lama dilengkapi, {$skip_count} dilewati (tidak ada nama & WA).\n";
}

echo "\n=== PROSES IMPOR & UPDATE SELESAI ===\n";
if (!$is_cli) {
    echo "</pre>";
}
