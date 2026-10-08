Jobsheet 3
6.4 Latihan  
1. Gambar wireframe halaman baru memakai konvensi ASCII yang sama (bab 2 §2.2), misalnya halaman "Registrasi Anggota Baru" untuk aktor Tamu yang ingin jadi anggota perpustakaan. Jobsheet 3 & 4 — SIMPUS-Mini    |    hal. 33 
    Jawab
        +-------------------------------------------------------------+
        | SIMPUS-Mini                       [ Beranda ] [ Login ]     |
        +-------------------------------------------------------------+
        |                                                             |
        |  Registrasi Anggota Baru                                    |
        |  -----------------------                                    |
        |  Silakan isi data diri Anda untuk bergabung.                |
        |                                                             |
        |  Nama Lengkap  : [____________________________________]     |
        |  Alamat        : [____________________________________]     |
        |  No. HP        : [____________________________________]     |
        |  Email         : [____________________________________]     |
        |                                                             |
        |                     [ Daftar Sekarang ]                     |
        |                                                             |
        |  Sudah terdaftar? Hubungi petugas perpustakaan.             |
        +-------------------------------------------------------------+

2. Buat user flow baru untuk skenario yang belum digambarkan di wireframe.md, misalnya: "Petugas mencari anggota yang tunggakannya sudah lewat jatuh tempo."
Jawab :
Berikut adalah rancangan user flow untuk Petugas saat mencari anggota yang terlambat mengembalikan buku:  
     1. Petugas melakukan Login ke dalam sistem.
     2. Petugas masuk ke halaman Dashboard Petugas.  
     3. Petugas mengklik menu "Peminjaman" atau "Data Transaksi".  
     4.Petugas menggunakan fitur filter/pencarian dan memilih status "Lewat Jatuh Tempo" (atau mencari tanggal yang melewati hari ini).
     5. Sistem menampilkan tabel daftar anggota dan buku yang berstatus terlambat.
     6. Petugas mengeklik tombol "Detail" pada baris data anggota terkait untuk mendapatkan nomor HP/kontak yang bisa dihubungi. 


3. Identifikasi edge case tambahan yang mungkin belum tercatat, contoh: apa yang terjadi kalau Petugas mencoba meminjamkan buku yang sama ke anggota yang sama dua kali berturutturut? 
    Jawab :
    . Berikut adalah identifikasi edge case tambahan pada SIMPUS-Mini:  Peminjaman Ganda (Buku yang sama ke anggota yang sama): Jika petugas tidak sengaja memproses buku yang sama dua kali berturut-turut untuk satu anggota, sistem wajib memvalidasi status peminjaman aktifnya. Jika sistem mendeteksi buku tersebut masih berstatus "Dipinjam" oleh anggota terkait, transaksi kedua akan ditolak otomatis dan memunculkan pop-up peringatan.  Batas Maksimal Kuota Peminjaman: Sistem harus memiliki logika penolakan apabila seorang anggota mencoba meminjam buku baru sementara ia sudah mencapai batas maksimal kuota peminjaman perpustakaan (misalnya maksimal 3 buku aktif), meskipun stok fisik buku yang akan dipinjam masih tersedia di database.Pengembalian Data Fiktif/Tidak Sinkron: Skenario di mana petugas mencoba memproses pengembalian buku, namun secara sistem buku tersebut tidak sedang tercatat dipinjam oleh siapa pun. Sistem harus langsung memblokir alur (user flow) tersebut dan menampilkan pesan galat "Data Transaksi Tidak Ditemukan".

4. Coba implementasikan wireframe Login sebagai HTML statis (tanpa logika login sungguhan, mirip form Tambah Buku yang belum diproses di jobsheet-01) sebagai latihan menerjemahkan wireframe ke kode nyata, gunakan pola <label> + <input> yang sudah kamu kuasai dari dokumentasi jobsheet-01, ditambah satu <input type="password"> baru untuk field Password. 

    Jawab :
    Rancangan wireframe halaman Login Petugas berhasil diimplementasikan menjadi halaman HTML statis (login.html). Formulir ini dibangun dengan menerapkan ulang pola struktur <label> dan <input> yang telah dirancang sejak awal proyek untuk memastikan konsistensi tata letak tanpa perlu menulis ulang aturan CSS dari nol. Penyesuaian utama dilakukan dengan menambahkan atribut type="password" pada isian sandi. Atribut bawaan HTML ini secara otomatis menyamarkan karakter yang diketik oleh pengguna menjadi simbol titik atau asterisk, yang merupakan standar dasar bagi keamanan antarmuka dan pengalaman pengguna (UX) pada halaman otentikasi.