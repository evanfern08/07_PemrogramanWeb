<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

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
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}
if ($no_hp !== '' && !preg_match('/^[0-9]+$/', $no_hp)) {
    $errors[] = "Nomor HP hanya boleh berisi angka.";
}
if ($jenis_kelamin !== 'laki-laki' && $jenis_kelamin !== 'perempuan') {
    $errors[] = "Pilihan jenis kelamin tidak valid.";
}

// Jika ada error, kembalikan ke form
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Simpan ke database (status otomatis 'Aktif' dari DEFAULT di tabel)
$stmt = $pdo->prepare(
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp, jenis_kelamin, email)
     VALUES (:nama, :no_anggota, :alamat, :no_hp, :jenis_kelamin, :email)
     RETURNING id"
);
try {
    $stmt->execute([
        'nama'          => $nama,
        'no_anggota'    => $no_anggota,
        'alamat'        => $alamat,
        'no_hp'         => $no_hp,
        'jenis_kelamin' => $jenis_kelamin,
        'email'         => $email,
    ]);
} catch (PDOException $e) {
    if ($e->getCode() === '23505') { // kode PostgreSQL untuk pelanggaran UNIQUE
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'];
        header('Location: tambah.php');
        exit;
    }
    throw $e; // error lain tetap dilempar, supaya tidak tersembunyi
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil didaftarkan.'];
header('Location: list.php');
exit;