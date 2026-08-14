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
    
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo(dirname(__DIR__));
        $zip->close();
        
        // Direct cache file deletion (most reliable on shared hosting)
        $cachePath = dirname(__DIR__) . '/bootstrap/cache/';
        $filesToClear = ['routes-v7.php', 'config.php', 'services.php', 'packages.php', 'events.php'];
        $cleared = [];
        foreach ($filesToClear as $f) {
            $filePath = $cachePath . $f;
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $cleared[] = $f;
                }
            }
        }
        
        // Fallback to artisan clear if shell_exec is allowed
        $artisanPath = dirname(__DIR__) . '/artisan';
        $output = '';
        if (function_exists('shell_exec')) {
            $output = shell_exec("php $artisanPath optimize:clear 2>&1");
        }
        
        echo "✅ Deployment Sukses!\n";
        echo "- File cache dihapus: " . implode(', ', $cleared) . "\n";
        echo "- Output Artisan: " . ($output ?: 'shell_exec dinonaktifkan') . "\n";
    } else {
        http_response_code(500);
        echo "❌ Gagal mengekstrak file ZIP.";
    }
} else {
    $parentDir = dirname(__DIR__);
    $artisanExists = file_exists($parentDir . '/artisan') ? 'YA' : 'TIDAK';
    $files = file_exists($parentDir) ? scandir($parentDir) : [];
    
    echo "Menunggu file dari GitHub Actions...\n\n";
    echo "Detail Path Server:\n";
    echo "- Web Root (DIR): " . __DIR__ . "\n";
    echo "- Project Root (Parent): " . $parentDir . "\n";
    echo "- File 'artisan' ada di Project Root?: " . $artisanExists . "\n";
    echo "- Daftar file di Project Root:\n";
    print_r($files);
}
