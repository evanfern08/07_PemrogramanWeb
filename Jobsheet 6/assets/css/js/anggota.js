async function muatDaftarAnggota() {
    const tbody = document.querySelector("#tabel-anggota tbody");
    const loading = document.getElementById("loading-indicator-anggota");
    const counter = document.getElementById("counter-anggota");


    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        const res = await fetch("../data/anggota.json");
        if (!res.ok) throw new Error("Gagal mengambil data");

        const result = await res.json();
        const dataKey = "anggota";
        const daftarAnggota = result[dataKey] || [];

        // Update Penghitung Jumlah Anggota (Tugas Mandiri No. 3)
        if (counter) {
            counter.textContent = `Menampilkan ${daftarAnggota.length} dari ${daftarAnggota.length} anggota`;
        }

        daftarAnggota.forEach((anggota) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
        <td>${anggota.no_anggota || anggota.id}</td>
        <td>${anggota.nama}</td>
        <td>${anggota.email}</td>
        <td>${anggota.status}</td>
        <td>
          <button type="button">Edit</button>
          <button type="button" class="btn-hapus">Hapus</button>
        </td>
      `;
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5">Gagal memuat data: ${err.message}</td></tr>`;
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);