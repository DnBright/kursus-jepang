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
        
        // Clear Laravel cache to apply updates
        $artisanPath = dirname(__DIR__) . '/artisan';
        $output = shell_exec("php $artisanPath optimize:clear 2>&1");
        
        echo "✅ Deployment Sukses! Semua file berhasil diekstrak.\n\nCache status:\n" . $output;
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
