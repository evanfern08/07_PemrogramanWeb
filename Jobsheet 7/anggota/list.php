<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

// Menangkap flash message dari proses_tambah
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Mengambil data anggota dari session (bukan dari JSON lagi)
$daftarAnggota = $_SESSION['anggota'] ?? [];
?>

<section>
    <h2>Daftar Anggota</h2>

    <!-- Area untuk menampilkan notifikasi sukses/gagal -->
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Nama Anggota</label>
        <input type="text" id="search-input" placeholder="Ketik nama anggota...">
    </div>

    <div class="table-responsive">
        <table id="tabel-anggota">
            <thead>
                <tr>
                    <th>No Anggota</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP mengambil alih tugas merender baris tabel di server -->
                <?php if (empty($daftarAnggota)): ?>
                    <tr>
                        <td colspan="5">Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarAnggota as $anggota): ?>
                        <tr>
                            <td><?php echo $anggota['no_anggota'] ?? '-'; ?></td>
                            <td class="col-judul"><?php echo $anggota['nama'] ?? '-'; ?></td>
                            <td><?php echo $anggota['email'] ?? '-'; ?></td>
                            <td><?php echo $anggota['status'] ?? 'Aktif'; ?></td>
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