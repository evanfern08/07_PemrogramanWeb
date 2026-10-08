<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';

// Menangkap flash message dari proses_tambah
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);


// Mengambil data buku dari session
$daftarBuku = $_SESSION['buku'] ?? [];
?>

<section>
    <h2>Daftar Buku</h2>

    <!-- Area untuk menampilkan notifikasi sukses/gagal -->
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box" style="margin-bottom: 15px;">
        <label for="search-input">Cari Judul Buku</label><br>
        <input type="text" id="search-input" placeholder="Cari judul buku..." style="padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    
    <!-- Penghitung Jumlah Buku (Dihitung langsung pakai PHP count) -->
    <p id="counter-buku" style="font-weight: bold; margin-bottom: 10px;">
        Menampilkan <?php echo count($daftarBuku); ?> dari <?php echo count($daftarBuku); ?> buku
    </p>

    <div class="table-responsive">
        <table id="tabel-buku">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP merender baris tabel di server -->
                <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="7">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $buku): ?>
                        <tr>
                            <td><?php echo $buku['isbn'] ?? '-'; ?></td>
                            <td class="col-judul"><?php echo $buku['judul'] ?? '-'; ?></td>
                            <td><?php echo $buku['pengarang'] ?? '-'; ?></td>
                            <td><?php echo $buku['tahun'] ?? '-'; ?></td>
                            <td><?php echo $buku['kategori'] ?? '-'; ?></td>
                            <td><?php echo $buku['stok'] ?? '-'; ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>