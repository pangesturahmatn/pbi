<?php
/**
 * PBI Theme Deploy Extraction Helper
 * Extracts the uploaded zip file and cleans up.
 */
header('Content-Type: text/plain');

$zipFile = __DIR__ . '/pbi-company-profile.zip';
$targetDir = __DIR__ . '/pbi-company-profile';

if (!file_exists($zipFile)) {
    die("Error: ZIP file not found in " . $zipFile);
}

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$zip = new ZipArchive();
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Success: Extracted theme files.\n";
} else {
    die("Error: Failed to open ZIP archive.");
}

unlink($zipFile);
echo "Success: Cleaned up ZIP archive.\n";

unlink(__FILE__);
echo "Success: Self-destructed extraction helper.\n";
