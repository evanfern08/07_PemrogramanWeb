<?php
session_start();

// Mengambil data dari form
$nama = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];

// Validasi Server-Side
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($no_anggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}
if ($email === '') {
    $errors[] = "Email wajib diisi.";
}

// Jika ada error, kembalikan ke form
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Jika valid, siapkan array keranjang anggota jika belum ada
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

// Masukkan data baru ke dalam session
$_SESSION['anggota'][] = [
    'no_anggota' => $no_anggota,
    'nama' => $nama,
    'alamat' => $alamat,
    'no_hp' => $no_hp,
    'jenis_kelamin' => $jenis_kelamin,
    'email' => $email,
    'status' => 'Aktif' // Set default status aktif saat mendaftar
];

// Latihan 2
// Validasi format email yang benar menggunakan fungsi bawaan PHP
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}
// Validasi nomor HP (hanya angka jika diisi)
if ($no_hp !== '' && !preg_match('/^[0-9]+$/', $no_hp)) {
    $errors[] = "Nomor HP hanya boleh berisi angka.";
}
// Validasi jenis kelamin (mencegah pengguna memanipulasi value HTML di browser)
if ($jenis_kelamin !== 'laki-laki' && $jenis_kelamin !== 'perempuan') {
    $errors[] = "Pilihan jenis kelamin tidak valid.";
}
// Beri notifikasi sukses dan arahkan ke daftar anggota
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil didaftarkan.'];
header('Location: list.php');
exit;