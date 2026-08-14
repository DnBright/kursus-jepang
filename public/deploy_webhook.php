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
        echo "✅ Deployment Sukses! Semua file berhasil diekstrak.";
    } else {
        http_response_code(500);
        echo "❌ Gagal mengekstrak file ZIP.";
    }
} else {
    echo "Menunggu file dari GitHub Actions...";
}
