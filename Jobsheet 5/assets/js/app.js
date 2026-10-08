document.addEventListener("DOMContentLoaded", () => {
  // 1. Mobile Menu Hamburger Toggle
  const hamburgerBtn = document.querySelector(".hamburger-btn");
  const navMenu = document.querySelector(".nav-menu");

  if (hamburgerBtn && navMenu) {
    hamburgerBtn.addEventListener("click", () => {
      navMenu.classList.toggle("nav-open");
    });
  }

  // 2. Filter Tabel Real-Time
  const searchInput = document.getElementById("search-input");
  const tableRows = document.querySelectorAll("#data-table tbody tr");

  if (searchInput) {
    searchInput.addEventListener("keyup", (e) => {
      const keyword = e.target.value.toLowerCase();
      tableRows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(keyword) ? "" : "none";
      });
    });
  }

  // 3. Konfirmasi Hapus Baris Tabel
  const deleteButtons = document.querySelectorAll(".btn-hapus");
  deleteButtons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const isConfirmed = confirm("Apakah Anda yakin ingin menghapus data ini?");
      if (isConfirmed) {
        const row = e.target.closest("tr");
        if (row) row.remove();
      }
    });
  });

  // 4. Validasi Form Client-Side
  const form = document.getElementById("main-form");
  if (form) {
    form.addEventListener("submit", (e) => {
      let isValid = true;
      const inputs = form.querySelectorAll("[required]");

      inputs.forEach((input) => {
        const errorSpan = input.nextElementSibling;
        if (!input.value.trim()) {
          isValid = false;
          input.classList.add("input-error");
          if (errorSpan && errorSpan.classList.contains("error-msg")) {
            errorSpan.textContent = "Field ini wajib diisi!";
          }
        } else {
          input.classList.remove("input-error");
          if (errorSpan && errorSpan.classList.contains("error-msg")) {
            errorSpan.textContent = "";
          }
        }
      });

      if (!isValid) {
        e.preventDefault();
      }
    });
  }
});