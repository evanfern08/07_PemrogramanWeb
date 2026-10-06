<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Contoh: Budi Santoso" required>
        </p>
        <p>
            <label for="no_anggota">No. Anggota</label>
            <input type="text" id="no_anggota" name="no_anggota" placeholder="Contoh: A005" required>
        </p>
        <p>
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" placeholder="Contoh: Malang">
        </p>
        <p>
            <label for="no_hp">No. HP</label>
            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789">
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Contoh: budi@email.com">
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>