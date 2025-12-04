🟦 SALUT UT Purwoharjo
Sistem Informasi Akademik — Sentra Layanan Universitas Terbuka Purwoharjo Banyuwangi
Tampilkan Gambar
Tampilkan Gambar
Tampilkan Gambar
Tampilkan Gambar

📋 Daftar Isi / Table of Contents

Deskripsi
Fitur Utama
Teknologi
Instalasi
Panduan Penggunaan
Struktur Database
Struktur File
Keamanan
Kontribusi
Lisensi
Kontak


📌 Deskripsi / Description
🇮🇩 Bahasa Indonesia
SALUT UT adalah aplikasi Sistem Informasi Akademik yang digunakan oleh Sentra Layanan Universitas Terbuka (SALUT) Purwoharjo — Banyuwangi sebagai platform internal untuk mengelola seluruh aspek administrasi akademik dan keuangan.
Tujuan Utama:

Digitalisasi proses administrasi akademik
Mempermudah pengelolaan data mahasiswa
Transparansi pembayaran dan keuangan
Efisiensi operasional SALUT

Keunggulan:

✅ Ringan dan cepat
✅ Mudah dikembangkan dan dipelihara
✅ Interface sederhana dan user-friendly
✅ Cocok untuk skala sentra layanan lokal
✅ Tidak memerlukan framework kompleks

🇬🇧 English
SALUT UT is an internal Academic Information System used by Universitas Terbuka Purwoharjo Service Center — Banyuwangi to manage all aspects of academic administration and finance.
Main Objectives:

Digitize academic administration processes
Simplify student data management
Payment and financial transparency
SALUT operational efficiency

Advantages:

✅ Lightweight and fast
✅ Easy to develop and maintain
✅ Simple and user-friendly interface
✅ Suitable for local service center scale
✅ No complex framework required


🚀 Fitur Utama / Key Features
🎓 Manajemen Mahasiswa / Student Management
FiturFileDeskripsiData Mahasiswa Barudatamahasiswabaru.phpInput dan kelola mahasiswa baruData Mahasiswa Aktifdata-mahasiswa.phpDatabase mahasiswa aktifDetail Mahasiswaview_mahasiswa.php, view_detail.phpLihat profil lengkap mahasiswaEdit Dataeditdatamahasiswa.php, editdatamahasiswabaru.phpUpdate informasi mahasiswaData Alumnidata-alumni.phpArsip lulusanData Wisudadata-wisuda.php, view_wisuda.phpManajemen kelulusanData Mengulangdata-mengulang.php, view_mengulang.phpTracking mahasiswa mengulangNaikkan Semesternaikkan_semester.phpProses otomatis naik semester
🏫 Manajemen Kelas & Prodi / Class & Program Management
FiturFileDeskripsiData Kelasdata-kelas.phpKelola kelas perkuliahanEdit Kelasedit-kelas.phpUpdate informasi kelasData Program Studidata-inti-kampus.phpDatabase program studiInput/Edit Prodiinput-data-inti-kampus.php, edit-prodi.phpManajemen program studiAPI Kelas-Prodiget_kelas_by_prodi.phpDynamic dropdown integrationKelola Anggota Kelasremove_from_class.phpHapus mahasiswa dari kelas
💵 Sistem Pembayaran / Payment System
Jenis PembayaranFileFiturPendaftaranbayar-pendaftaran.phpPembayaran registrasi awalKuliahbayar-kuliah.phpPembayaran SPP semesterMengulangbayar-mengulang.phpPembayaran mata kuliah ulangWisudabayar-wisuda.phpBiaya kelulusanCetak Buktiprint.php, cetak-bayar*.phpPrint receiptHistorihistori-bayarkuliah.phpRiwayat transaksiResetreset_pembayaran.phpAdmin payment adjustmentHelper Functionspayment_functions.phpCore payment logic
📊 Rekapitulasi & Pelaporan / Reports & Recap
LaporanFileOutputRekap Kuliahrekap-bayarkuliah.phpLaporan pembayaran SPPRekap Mengulangrekap-bayarmengulang.phpLaporan biaya mengulangRekap Wisudarekap-bayarwisuda.phpLaporan biaya wisudaCashflowcashflow.phpLaporan keuangan umum
💼 Administrasi Sistem / System Administration
ModulFileFungsiKelola Adminkelola_akunadmin.phpManajemen user adminTambah Akunadd_account.phpRegistrasi admin baruBuka/Tutup Registrasibuka_registrasi.phpToggle periode registrasi
🔐 Keamanan / Security
FiturFileDeskripsiLogin Adminlogin.phpAutentikasi penggunaLogoutlogout.phpEnd sessionReset Passwordreset-password.phpUbah kredensialAuto Redirectindex.htmlSecurity landing pageDatabase Connectionkoneksi.php, initializing.phpSecure DB config

🛠️ Teknologi / Technology Stack
Backend

PHP 7.4+ / 8.x (Native PHP)
MySQL / MariaDB

Frontend

HTML5
CSS3
JavaScript (Vanilla JS)

Server Requirements

XAMPP / Laragon / CPanel Hosting
Apache 2.4+
phpMyAdmin (optional, for DB management)

Development Tools

Visual Studio Code / Sublime Text
Git for version control
Postman (API testing - optional)


⚙️ Instalasi / Installation
🇮🇩 Panduan Instalasi (Bahasa Indonesia)
Prasyarat

PHP 7.4 atau lebih tinggi
MySQL/MariaDB
XAMPP/Laragon atau web hosting

Langkah Instalasi

Clone Repository

bash   git clone https://github.com/username/salut_ut_purwoharjo.git
   cd salut_ut_purwoharjo

Setup Database

sql   -- Buat database baru
   CREATE DATABASE salut_ut_db;
   
   -- Import file SQL
   mysql -u root -p salut_ut_db < database/salut_ut_db.sql

Konfigurasi Database
Edit file koneksi.php:

php   <?php
   $host = "localhost";
   $user = "root";
   $pass = ""; // password MySQL Anda
   $db = "salut_ut_db";
   
   $koneksi = mysqli_connect($host, $user, $pass, $db);
   ?>
Edit file initializing.php (jika ada):
php   <?php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'salut_ut_db');
   ?>
```

4. **Deploy ke Server**
   
   **Untuk XAMPP:**
```
   Pindahkan folder ke: C:\xampp\htdocs\salut_ut_purwoharjo
   Akses via: http://localhost/salut_ut_purwoharjo
```
   
   **Untuk Laragon:**
```
   Pindahkan folder ke: C:\laragon\www\salut_ut_purwoharjo
   Akses via: http://salut_ut_purwoharjo.test
```

5. **Login Pertama Kali**
```
   URL: http://localhost/salut_ut_purwoharjo/login.php
   Username: admin (default)
   Password: admin123 (default)
⚠️ PENTING: Segera ubah password default setelah login pertama!
🇬🇧 Installation Guide (English)
Prerequisites

PHP 7.4 or higher
MySQL/MariaDB
XAMPP/Laragon or web hosting

Installation Steps

Clone Repository

bash   git clone https://github.com/username/salut_ut_purwoharjo.git
   cd salut_ut_purwoharjo

Setup Database

sql   -- Create new database
   CREATE DATABASE salut_ut_db;
   
   -- Import SQL file
   mysql -u root -p salut_ut_db < database/salut_ut_db.sql

Database Configuration
Edit koneksi.php:

php   <?php
   $host = "localhost";
   $user = "root";
   $pass = ""; // your MySQL password
   $db = "salut_ut_db";
   
   $koneksi = mysqli_connect($host, $user, $pass, $db);
   ?>
```

4. **Deploy to Server**
   
   **For XAMPP:**
```
   Move folder to: C:\xampp\htdocs\salut_ut_purwoharjo
   Access via: http://localhost/salut_ut_purwoharjo
```

5. **First Login**
```
   URL: http://localhost/salut_ut_purwoharjo/login.php
   Username: admin (default)
   Password: admin123 (default)
⚠️ IMPORTANT: Change default password immediately after first login!

📘 Panduan Penggunaan / User Guide
1. Login Admin

Buka browser dan akses login.php
Masukkan username dan password
Klik tombol "Login"
Sistem akan redirect ke dashboard admin

2. Mengelola Akun Admin
Menambah Akun Baru:

Masuk menu "Kelola Akun Admin" (kelola_akunadmin.php)
Klik "Tambah Akun" (add_account.php)
Isi formulir:

Username
Password
Nama Lengkap
Level akses


Simpan

Reset Password:

Akses reset-password.php
Pilih username yang akan direset
Masukkan password baru
Konfirmasi

3. Manajemen Mahasiswa
Input Mahasiswa Baru:

Buka menu "Data Mahasiswa Baru" (datamahasiswabaru.php)
Klik "Tambah Mahasiswa"
Isi data:

NIM
Nama
Program Studi
Kelas
Data kontak


Simpan

Edit Data Mahasiswa:

Cari mahasiswa di data-mahasiswa.php
Klik tombol "Edit" (editdatamahasiswa.php)
Update data yang diperlukan
Simpan perubahan

Lihat Detail Mahasiswa:

Klik nama mahasiswa atau tombol "Detail"
File: view_mahasiswa.php atau view_detail.php

4. Proses Pembayaran
Langkah Umum:

Pilih jenis pembayaran:

Pendaftaran (bayar-pendaftaran.php)
Kuliah (bayar-kuliah.php)
Mengulang (bayar-mengulang.php)
Wisuda (bayar-wisuda.php)


Input/scan NIM mahasiswa
Verifikasi data yang muncul
Input nominal pembayaran
Konfirmasi transaksi
Cetak bukti pembayaran (print.php)

Histori Pembayaran:

Akses histori-bayarkuliah.php
Filter berdasarkan:

Periode
NIM
Jenis pembayaran



5. Rekapitulasi
Rekap Pembayaran Kuliah:

Buka rekap-bayarkuliah.php
Pilih periode (semester/tahun)
Klik "Tampilkan"
Export ke Excel/PDF (jika tersedia)

Rekap Mengulang:

File: rekap-bayarmengulang.php
Menampilkan data mahasiswa yang mengulang dan pembayarannya

Rekap Wisuda:

File: rekap-bayarwisuda.php
Daftar calon wisudawan dan status pembayaran

6. Naikkan Semester Otomatis
⚠️ Fitur Sensitif - Harap Hati-hati!

Backup database terlebih dahulu
Akses naikkan_semester.php
Pilih parameter:

Semester saat ini
Semester tujuan
Filter kelas/prodi (optional)


Klik "Proses Naikkan Semester"
Sistem akan otomatis:

Update semester mahasiswa
Adjust status akademik
Generate log perubahan



7. Buka/Tutup Registrasi
Mengatur Periode Registrasi:

Akses buka_registrasi.php
Toggle status:

Buka: Mahasiswa dapat melakukan registrasi
Tutup: Registrasi dinonaktifkan


Set tanggal mulai dan akhir (optional)
Simpan pengaturan

8. Manajemen Kelas & Prodi
Tambah/Edit Kelas:

Buka data-kelas.php
Tambah kelas baru atau edit yang ada (edit-kelas.php)
Atur:

Nama kelas
Program studi
Kapasitas
Jadwal



Manajemen Program Studi:

Akses data-inti-kampus.php
Input/edit prodi via:

input-data-inti-kampus.php
edit-prodi.php



Mengeluarkan Mahasiswa dari Kelas:

File: remove_from_class.php
Pilih mahasiswa dan kelas
Konfirmasi pengeluaran


🗄️ Struktur Database / Database Structure
Tabel Utama / Main Tables
1. mahasiswa - Data Mahasiswa
sqlCREATE TABLE mahasiswa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    prodi_id INT,
    kelas_id INT,
    semester INT DEFAULT 1,
    status ENUM('aktif', 'cuti', 'lulus', 'keluar'),
    alamat TEXT,
    telp VARCHAR(15),
    email VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
2. program_studi - Program Studi
sqlCREATE TABLE program_studi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_prodi VARCHAR(10) UNIQUE,
    nama_prodi VARCHAR(100) NOT NULL,
    jenjang ENUM('D3', 'S1', 'S2'),
    status ENUM('aktif', 'nonaktif')
);
3. kelas - Data Kelas
sqlCREATE TABLE kelas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_kelas VARCHAR(50) NOT NULL,
    prodi_id INT,
    kapasitas INT,
    tahun_angkatan YEAR
);
4. pembayaran - Transaksi Pembayaran
sqlCREATE TABLE pembayaran (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(20),
    jenis_pembayaran ENUM('pendaftaran', 'kuliah', 'mengulang', 'wisuda'),
    nominal DECIMAL(10,2),
    tanggal_bayar DATETIME DEFAULT CURRENT_TIMESTAMP,
    semester INT,
    tahun_akademik VARCHAR(10),
    admin_id INT,
    keterangan TEXT
);
5. admin - User Admin
sqlCREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    level ENUM('superadmin', 'admin', 'operator'),
    status ENUM('aktif', 'nonaktif')
);
6. wisuda - Data Wisuda
sqlCREATE TABLE wisuda (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(20),
    tanggal_wisuda DATE,
    periode_wisuda VARCHAR(20),
    status_bayar ENUM('lunas', 'belum'),
    status_wisuda ENUM('proses', 'selesai')
);
7. mengulang - Data Mengulang Mata Kuliah
sqlCREATE TABLE mengulang (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(20),
    kode_mk VARCHAR(10),
    nama_mk VARCHAR(100),
    semester INT,
    biaya DECIMAL(10,2),
    status_bayar ENUM('lunas', 'belum')
);
```

### Relasi Tabel / Table Relations
```
mahasiswa
  ├── prodi_id → program_studi.id
  └── kelas_id → kelas.id

kelas
  └── prodi_id → program_studi.id

pembayaran
  ├── nim → mahasiswa.nim
  └── admin_id → admin.id

wisuda
  └── nim → mahasiswa.nim

mengulang
  └── nim → mahasiswa.nim
```

---

## 📁 Struktur File / File Structure
```
salut_ut_purwoharjo/
│
├── 📄 index.html                    # Landing page / auto redirect
├── 📄 login.php                     # Login page
├── 📄 logout.php                    # Logout handler
├── 📄 koneksi.php                   # Database connection
├── 📄 initializing.php              # System initialization
│
├── 📂 admin/                        # Admin module
│   ├── kelola_akunadmin.php
│   ├── add_account.php
│   ├── reset-password.php
│   └── buka_registrasi.php
│
├── 📂 mahasiswa/                    # Student management
│   ├── datamahasiswabaru.php
│   ├── data-mahasiswa.php
│   ├── view_mahasiswa.php
│   ├── view_detail.php
│   ├── editdatamahasiswa.php
│   ├── editdatamahasiswabaru.php
│   ├── data-alumni.php
│   └── naikkan_semester.php
│
├── 📂 kelas/                        # Class & program management
│   ├── data-kelas.php
│   ├── edit-kelas.php
│   ├── data-inti-kampus.php
│   ├── input-data-inti-kampus.php
│   ├── edit-prodi.php
│   ├── get_kelas_by_prodi.php
│   └── remove_from_class.php
│
├── 📂 pembayaran/                   # Payment system
│   ├── bayar-pendaftaran.php
│   ├── bayar-kuliah.php
│   ├── bayar-mengulang.php
│   ├── bayar-wisuda.php
│   ├── print.php
│   ├── cetak-bayar*.php
│   ├── histori-bayarkuliah.php
│   ├── reset_pembayaran.php
│   └── payment_functions.php
│
├── 📂 wisuda/                       # Graduation management
│   ├── data-wisuda.php
│   └── view_wisuda.php
│
├── 📂 mengulang/                    # Retake management
│   ├── data-mengulang.php
│   └── view_mengulang.php
│
├── 📂 laporan/                      # Reports & recap
│   ├── rekap-bayarkuliah.php
│   ├── rekap-bayarmengulang.php
│   ├── rekap-bayarwisuda.php
│   └── cashflow.php
│
├── 📂 assets/                       # Static assets
│   ├── css/
│   ├── js/
│   └── img/
│
└── 📂 database/                     # Database files
    └── salut_ut_db.sql

🔒 Keamanan / Security
Best Practices Implemented
1. Password Hashing
php// Contoh di reset-password.php
$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
2. SQL Injection Prevention
php// Menggunakan prepared statements
$stmt = $koneksi->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
3. Session Management
php// Cek session di setiap halaman admin
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
4. Input Validation
php// Sanitasi input
$nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
$nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
Rekomendasi Keamanan Tambahan
⚠️ Untuk Produksi:

Ubah Kredensial Default

Username dan password admin
Password database MySQL


Set Permissions File

bash   chmod 644 koneksi.php
   chmod 644 initializing.php

Aktifkan HTTPS

Gunakan SSL certificate
Redirect semua HTTP ke HTTPS


Backup Regular

Database: harian
File sistem: mingguan


Update Dependencies

PHP patch terbaru
MySQL security updates




🤝 Kontribusi / Contribution
🇮🇩 Cara Berkontribusi
Kami menerima kontribusi untuk pengembangan SALUT UT! Berikut panduannya:

Fork Repository

bash   # Fork via GitHub interface
   # Clone your fork
   git clone https://github.com/your-username/salut_ut_purwoharjo.git

Buat Branch Fitur Baru

bash   git checkout -b feature/nama-fitur-anda

Commit Changes

bash   git add .
   git commit -m "feat: deskripsi fitur baru"

Push & Pull Request

bash   git push origin feature/nama-fitur-anda
   # Buat Pull Request via GitHub
```

### Commit Message Convention
```
feat: menambah fitur baru
fix: perbaikan bug
docs: update dokumentasi
style: perubahan formatting
refactor: refactoring code
test: menambah testing
chore: maintenance
Area yang Membutuhkan Kontribusi

 Export laporan ke Excel/PDF
 Dashboard analytics
 Email notification system
 Mobile responsive design
 API REST untuk integrasi
 Multi-language support
 Automated testing


📄 Lisensi / License
🔐 Internal Use Only
Aplikasi ini dikembangkan khusus untuk keperluan internal Sentra Layanan Universitas Terbuka (SALUT) Purwoharjo — Banyuwangi.
Ketentuan Penggunaan:

❌ Dilarang digunakan di luar institusi tanpa izin tertulis
❌ Dilarang diperjualbelikan
❌ Dilarang didistribusikan ulang
✅ Modifikasi diperbolehkan untuk kepentingan internal
✅ Kontribusi pengembangan dipersilakan

Copyright © 2024 SALUT Universitas Terbuka Purwoharjo

📞 Kontak / Contact
SALUT UT Purwoharjo
📍 Alamat:
Sentra Layanan Universitas Terbuka
Purwoharjo, Banyuwangi
Jawa Timur, Indonesia
📧 Email:
salut.purwoharjo@ut.ac.id
📱 Telepon:
+62 xxx-xxxx-xxxx
🌐 Website:
www.ut.ac.id

🎓 Credits
Dikembangkan dengan ❤️ oleh Tim IT SALUT UT Purwoharjo
Special Thanks:

Universitas Terbuka
Seluruh admin dan staf SALUT Purwoharjo
Komunitas open source Indonesia


📊 Status Proyek / Project Status
Tampilkan Gambar
Tampilkan Gambar
Tampilkan Gambar
Tampilkan Gambar
Last Updated: Desember 2024

🎉 Terima Kasih / Thank You
Jika aplikasi ini bermanfaat untuk institusi Anda, silakan:
⭐ Berikan Star di repository
🐛 Laporkan Bug yang ditemukan
💡 Berikan Saran pengembangan
🤝 Kontribusi kode atau dokumentasi

<div align="center">
Made with 💙 in Banyuwangi, Indonesia
⬆ Kembali ke Atas
</div>
