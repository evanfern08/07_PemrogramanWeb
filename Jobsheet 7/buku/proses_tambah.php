<?php
session_start();

// Mengambil data dari form dan menghapus spasi berlebih
$isbn = trim($_POST['isbn'] ?? '');
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');

$errors = [];

// Validasi Server-Side
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
// Validasi ISBN: Jika diisi, pastikan hanya mengandung angka dan tanda hubung (Latihan 1)
if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus angka di antara 1900-2026.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok harus angka dan tidak boleh negatif.";
}

// Jika ada error, kembalikan ke form tambah beserta pesan flash
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Jika valid, siapkan array keranjang buku jika belum ada
if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [];
}

// Masukkan data baru ke dalam session
$_SESSION['buku'][] = [
    'isbn' => $isbn,
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'stok' => (int) $stok,
    'kategori' => $kategori,
];

// Beri notifikasi sukses dan arahkan ke daftar buku
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;