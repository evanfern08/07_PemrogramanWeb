// ==========================================
// 1. INISIALISASI MODUL UTAMA
// ==========================================

// Hamburger Menu (Slide 10)
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.getElementById("nav-menu") || document.querySelector("header nav");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
    nav.classList.toggle("menu-aktif"); 
  });
}

// Event Delegation untuk Tombol Hapus Dinamis (Slide 21)
function initHapusConfirm() {
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    const nama = row ? row.querySelector("td")?.textContent : "data ini";
    const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');

    if (yakin && row) {
      row.remove();
    }
  });
}

// Validasi Form + Validasi ISBN (Slide 13, 14, 23)
function initValidasiForm() {
  const form = document.getElementById("form-tambah");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    // Hapus pesan error lama
    form.querySelectorAll(".error").forEach((el) => el.remove());

    const judul = form.querySelector("[name='judul'], [name='nama']");
    if (judul && judul.value.trim() === "") {
      tampilkanError(judul, "Field ini wajib diisi.");
      valid = false;
    }

    // Panggil Validasi ISBN jika input ISBN ada
    const isbn = form.querySelector("[name='isbn']");
    if (isbn && !validasiISBN(isbn)) {
      valid = false;
    }

    if (!valid) e.preventDefault();
  });
}

function tampilkanError(input, pesan) {
  const span = document.createElement("span");
  span.className = "error";
  span.style.color = "red";
  span.style.fontSize = "12px";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

// ==========================================
// 2. TUGAS MANDIRI (1, 2, 3, 4, 5)
// ==========================================

// Tugas 1: Validasi Field ISBN (Hanya Angka & Tanda Hubung)
function validasiISBN(input) {
  const isbnRegex = /^[0-9-]+$/;
  if (input && input.value.trim() !== "" && !isbnRegex.test(input.value)) {
    tampilkanError(input, "ISBN hanya boleh berisi angka dan tanda hubung (-).");
    return false;
  }
  return true;
}

// Tugas 4 & 5: Fungsi Generik Sejati Berparameter Array dengan simulasi loading 3000ms
async function muatTabelData(urlJson, dataKey, tableId, keys, counterId, delay = 3000) {
  const table = document.getElementById(tableId);
  if (!table) return;

  const tbody = table.querySelector("tbody");
  const loading = document.getElementById("loading-indicator") || document.getElementById("loading-indicator-anggota");
  const counterEl = document.getElementById(counterId);

  try {
    // 1. Tampilkan loading & bersihkan tabel
    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    // Simulasi delay jaringan
    await new Promise((resolve) => setTimeout(resolve, 3000));

    // 2. Fetch Data
    const res = await fetch(urlJson);
    if (!res.ok) throw new Error(`HTTP Error: ${res.status}`);

    const result = await res.json();
    
    // Mengekstrak array data (mendukung format JSON ber-key atau langsung array)
    const listData = Array.isArray(result) ? result : (result[dataKey] || []);

    // 3. Render Baris Tabel Secara Dinamis
    listData.forEach((item) => {
      const tr = document.createElement("tr");
      let tdContent = "";
      
      // Render kolom berdasarkan urutan parameter 'keys'
      keys.forEach((key) => {
        const classJudul = (key === "judul" || key === "nama") ? 'class="col-judul"' : '';
        tdContent += `<td ${classJudul}>${item[key] || '-'}</td>`;
      });

      // Tambahkan tombol Edit & Hapus di akhir baris
      tdContent += `
        <td>
          <button type="button">Edit</button>
          <button type="button" class="btn-hapus">Hapus</button>
        </td>
      `;
      
      tr.innerHTML = tdContent;
      tbody.appendChild(tr);
    });

    // Tugas 3: Tampilkan penghitung "Menampilkan X dari Y"
    if (counterEl) {
      counterEl.textContent = `Menampilkan ${listData.length} dari ${listData.length} ${dataKey}`;
    }

    // Tugas 2: Pasang Filter Pencarian Khusus Kolom Judul/Nama
    initFilterJudulKhusus(tableId, counterEl, dataKey);
    
  } catch (err) {
    console.error("Fetch Error:", err);
    tbody.innerHTML = `<tr><td colspan="${keys.length + 1}" style="color:red; text-align:center;">Gagal memuat data: ${err.message}. Pastikan server lokal (Live Server) aktif.</td></tr>`;
  } finally {
    if (loading) loading.style.display = "none";
  }
}

// Tugas 2: Filter Pencarian Khusus Kolom Judul/Nama (.col-judul)
function initFilterJudulKhusus(tableId, counterEl, labelData) {
  const input = document.getElementById("search-input");
  const table = document.getElementById(tableId);
  if (!input || !table) return;

  input.onkeyup = function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");
    let visibleCount = 0;

    rows.forEach((row) => {
      const judulCell = row.querySelector(".col-judul")?.textContent.toLowerCase() || "";
      if (judulCell.includes(keyword)) {
        row.style.display = "";
        visibleCount++;
      } else {
        row.style.display = "none";
      }
    });

    if (counterEl) {
      counterEl.textContent = `Menampilkan ${visibleCount} dari ${rows.length} ${labelData}`;
    }
  };
}

// ==========================================
// 3. JALANKAN SAAT DOM READY
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initValidasiForm();

  // Deteksi kedalaman folder agar path fetch tidak salah sasaran
  const isSubfolder = window.location.pathname.includes("/buku/") || window.location.pathname.includes("/anggota/");
  
  const pathBuku = isSubfolder ? "../data/buku.json" : "data/buku.json";
  const pathAnggota = isSubfolder ? "../data/anggota.json" : "data/anggota.json";

  // Panggil fungsi generik untuk Tabel Buku
  if (document.getElementById("tabel-buku")) {
    muatTabelData(
      pathBuku, 
      "buku", 
      "tabel-buku", 
      ["isbn", "judul", "pengarang", "tahun", "stok", "kategori"], 
      "counter-buku", 
      3000
    );
  }

  // Panggil fungsi generik untuk Tabel Anggota
  if (document.getElementById("tabel-anggota")) {
    muatTabelData(
      pathAnggota, 
      "anggota", 
      "tabel-anggota", 
      ["no_anggota", "nama", "email", "status"], 
      "counter-anggota", 
      3000
    );
  }
});