# Manajemen Pegawai
**Aplikasi Web CRUD Pencatatan Data Pegawai (Monochrome Edition)**

---

## 📌 Ringkasan
Aplikasi manajemen pegawai sederhana dengan konsep desain **Hitam & Putih (Monochrome Minimalist)** yang bersih, responsif, dan mudah dipahami. Dibangun menggunakan **PHP Native** berorientasi pemrograman terstruktur, **PDO (PHP Data Objects)** dengan *Prepared Statements*, **Bootstrap 5**, dan live search tanpa reload menggunakan library **Axios**.

---

## 🗂️ Struktur Folder

```text
aplikasi pegawai/
├── assets/
│   ├── css/
│   │   └── style.css            # Custom CSS Monokrom Hitam & Putih
│   └── js/
│       └── script.js            # Validasi form client-side, konfirmasi hapus, live search Axios
├── config/
│   └── koneksi.php              # Konfigurasi koneksi PDO MySQL (127.0.0.1:3306)
├── includes/
│   ├── auth_check.php           # Pengecekan session login
│   ├── navbar.php               # Navigasi utama
│   └── footer.php               # Footer & CDN script
├── proses/
│   ├── login_proses.php         # Verifikasi login sesi admin (admin / admin123)
│   ├── logout.php               # Hapus session & redirect ke index.php
│   ├── simpan.php               # Validasi server-side + INSERT data pegawai
│   ├── update.php               # Validasi server-side + UPDATE data pegawai
│   ├── hapus.php                # DELETE data pegawai berdasarkan ID
│   └── cari.php                 # Endpoint JSON untuk live search Axios
├── index.php                    # Halaman Login
├── dashboard.php                # Halaman Dashboard
├── pegawai.php                  # Halaman Tabel Pegawai & Live Search
├── tambah.php                   # Halaman Formulir Tambah Pegawai
├── edit.php                     # Halaman Formulir Edit Pegawai
├── detail.php                   # Halaman Detail Pegawai
├── database.sql                 # Skrip pembuatan tabel pegawai
└── README.md                    # Dokumentasi
```

---

## ⚙️ Skema Tabel Database
- **Database**: `db_pegawai`
- **Tabel**: `pegawai` (`id`, `nip`, `nama`, `email`, `jabatan`, `no_telepon`)

---

## 🔑 Akun Login
- **Username**: `admin`
- **Password**: `admin123`
