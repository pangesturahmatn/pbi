<?php
/**
 * PBI Permission Fixer
 * Memperbaiki permission semua folder (0755) dan file (0644) secara otomatis dan rekursif.
 * 
 * Cara Penggunaan:
 * 1. Upload file ini ke root website Anda (di folder public_html atau pesantrenbisnisindonesia.org)
 * 2. Akses melalui browser: https://pesantrenbisnisindonesia.org/pbi-permission-fix.php
 * 3. HAPUS FILE INI SETELAH SELESAI demi keamanan!
 */

header('Content-Type: text/plain; charset=utf-8');

$root_dir = dirname(__FILE__);
echo "Memulai perbaikan permission di: $root_dir\n\n";

function fix_permissions($dir) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    $fixed_dirs = 0;
    $fixed_files = 0;
    $errors = 0;

    // Perbaiki root folder sendiri dulu
    if (@chmod($dir, 0755)) {
        $fixed_dirs++;
    } else {
        echo "Gagal mengubah permission root folder: $dir\n";
        $errors++;
    }

    foreach ($iterator as $item) {
        $path = $item->getPathname();
        
        // Lewati file script ini sendiri agar tidak error saat running
        if (basename($path) === basename(__FILE__)) {
            continue;
        }

        if ($item->isDir()) {
            // Folder -> Set ke 0755
            if (@chmod($path, 0755)) {
                $fixed_dirs++;
            } else {
                echo "Gagal mengubah folder: $path\n";
                $errors++;
            }
        } else {
            // File -> Set ke 0644
            if (@chmod($path, 0644)) {
                $fixed_files++;
            } else {
                echo "Gagal mengubah file: $path\n";
                $errors++;
            }
        }
    }

    echo "Selesai!\n";
    echo "--------------------------\n";
    echo "Folder yang diperbaiki (0755): $fixed_dirs\n";
    echo "File yang diperbaiki (0644)  : $fixed_files\n";
    echo "Error (gagal diubah)         : $errors\n";
}

fix_permissions($root_dir);
