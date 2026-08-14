<?php
// Script Webhook Deployment untuk cPanel (Bypass FTP & SSH)

// GANTI TOKEN INI DENGAN KATA SANDI RAHASIA ANDA!
$secret = 'Jepang2026_Aman';

if (!isset($_GET['token']) || $_GET['token'] !== $secret) {
    http_response_code(403);
    die("Akses Ditolak: Token Salah.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['build'])) {
    $zipFile = $_FILES['build']['tmp_name'];
    $log = "Deployment Log - " . date('Y-m-d H:i:s') . "\n";
    
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        if ($zip->extractTo(dirname(__DIR__)) === TRUE) {
            $zip->close();
            $log .= "✅ ZIP successfully extracted to project root.\n";
            
            // Direct cache file deletion
            $cachePath = dirname(__DIR__) . '/bootstrap/cache/';
            $filesToClear = ['routes-v7.php', 'config.php', 'services.php', 'packages.php', 'events.php'];
            $cleared = [];
            foreach ($filesToClear as $f) {
                $filePath = $cachePath . $f;
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        $cleared[] = $f;
                    } else {
                        $cleared[] = "$f (FAILED TO UNLINK)";
                    }
                }
            }
            $log .= "- Cleared cache files: " . implode(', ', $cleared) . "\n";
            
            // Fallback to artisan clear
            $artisanPath = dirname(__DIR__) . '/artisan';
            if (function_exists('shell_exec')) {
                $output = shell_exec("php $artisanPath optimize:clear 2>&1");
                $log .= "- Artisan optimize:clear output:\n" . $output . "\n";
            } else {
                $log .= "- shell_exec is disabled, skipped artisan command.\n";
            }
            
            file_put_contents(__DIR__ . '/deploy_log.txt', $log);
            echo "✅ Deployment Sukses!\n";
        } else {
            $zip->close();
            http_response_code(500);
            $log .= "❌ Failed to extract ZIP file to project root (Permission denied?).\n";
            file_put_contents(__DIR__ . '/deploy_log.txt', $log);
            echo "❌ Gagal mengekstrak file ZIP ke Project Root (Masalah Hak Akses?).";
        }
    } else {
        http_response_code(500);
        $log .= "❌ Failed to open ZIP file.\n";
        file_put_contents(__DIR__ . '/deploy_log.txt', $log);
        echo "❌ Gagal membuka file ZIP.";
    }
} else {
    $parentDir = dirname(__DIR__);
    $artisanExists = file_exists($parentDir . '/artisan') ? 'YA' : 'TIDAK';
    $files = file_exists($parentDir) ? scandir($parentDir) : [];
    
    $cachePath = $parentDir . '/bootstrap/cache';
    $cacheFiles = file_exists($cachePath) ? scandir($cachePath) : [];
    
    echo "Menunggu file dari GitHub Actions...\n\n";
    echo "Detail Path Server:\n";
    echo "- Web Root (DIR): " . __DIR__ . "\n";
    echo "- Project Root (Parent): " . $parentDir . "\n";
    echo "- File 'artisan' ada di Project Root?: " . $artisanExists . "\n";
    echo "- Daftar file di Project Root:\n";
    print_r($files);
    echo "\n- Daftar file di bootstrap/cache:\n";
    print_r($cacheFiles);
}
