<?php
require __DIR__ . '/includes/koneksi.php';

$json = json_decode(file_get_contents(__DIR__ . '/data/buku.json'), true);
$data = $json['buku'] ?? $json; // mendukung JSON berbungkus key "buku" maupun array langsung

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

$jumlah = 0;
foreach ($data as $b) {
    $stmt->execute([
        'judul'     => $b['judul'],
        'pengarang' => $b['pengarang'],
        'tahun'     => (int) $b['tahun'],
        'isbn'      => $b['isbn'] ?? null,
        'stok'      => (int) ($b['stok'] ?? 0),
        'kategori'  => $b['kategori'] ?? null,
    ]);
    $jumlah++;
}
echo "Berhasil memindahkan $jumlah buku.";