<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

// Menangkap flash message jika ada error saat input
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <!-- Form kini memiliki method post dan action -->
    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required>
        </p>
        <p>
            <label for="no_anggota">No. Anggota:</label><br>
            <input type="text" id="no_anggota" name="no_anggota" required>
        </p>
        <p>
            <label for="alamat">Alamat:</label><br>
            <input type="text" id="alamat" name="alamat">
        </p>
        <p>
            <label for="no_hp">No. Hp:</label><br>
            <input type="text" id="no_hp" name="no_hp">
        </p>
        <p>
            <label for="jenis_kelamin">Jenis Kelamin:</label><br>
            <select id="jenis_kelamin" name="jenis_kelamin">
                <option value="laki-laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
            </select>
        </p>
        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>