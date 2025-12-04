# 🟦 salut_ut_purwoharjo

> 🇮🇩 Sistem Informasi Akademik — Sentra Layanan Universitas Terbuka Purwoharjo Banyuwangi  
> 🇬🇧 Academic Information System — Universitas Terbuka Purwoharjo Banyuwangi Service Center

---

![PHP](https://img.shields.io/badge/PHP-Native-777BB4?logo=php&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Internal%20Use%20Only-orange)
![License](https://img.shields.io/badge/License-Private-red)

---

## 📌 Deskripsi (ID)

**Salut UT** adalah aplikasi Sistem Informasi Akademik yang digunakan oleh SALUT Purwoharjo — Banyuwangi untuk mengelola mahasiswa, pembayaran, kelas, program studi, admin, registrasi, dan laporan akademik.

---

## 📌 Description (EN)

**Salut UT** is an Academic Information System used internally by Universitas Terbuka Purwoharjo Service Center to manage students, payments, classes, study programs, administration, registration, and academic reporting.

---

## 🚀 Fitur Utama / Key Features

### 🎓 Mahasiswa & Akademik
- Data mahasiswa baru & aktif  
- Detail & edit mahasiswa  
- Data alumni, wisuda, mengulang  
- Naik semester otomatis  

### 🏫 Kelas & Program Studi
- Data kelas, edit kelas  
- Data inti kampus & prodi  
- Relasi dinamis prodi–kelas  
- Hapus mahasiswa dari kelas  

### 💵 Pembayaran
- Pembayaran pendaftaran, kuliah, mengulang, wisuda  
- Cetak bukti pembayaran  
- Histori & reset pembayaran  
- Rekap pembayaran  
- Cashflow keuangan  

### 💼 Administrasi & Registrasi
- Kelola akun admin  
- Tambah akun admin  
- Buka/tutup registrasi  

### 🔐 Autentikasi
- Login  
- Logout  
- Reset password admin  
- Redirect halaman awal  
- Koneksi database  

---

## 💻 Teknologi / Tech Stack

- PHP Native  
- MySQL Database  
- Apache Web Server  
- Session Authentication  

---

## 🖥️ Kebutuhan Sistem / Requirements

- PHP 7.4+ / PHP 8.x  
- MySQL / MariaDB  
- Apache Server  
- XAMPP / Laragon / Hosting  

---

## ⚙️ Instalasi / Installation

1. Clone repository:
```bash
git clone https://github.com/username/salut_ut_purwoharjo.git
```

2. Import database `.sql`

3. Konfigurasi database:
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "salut_ut";
```

4. Akses aplikasi:
```
http://localhost/salut_ut_purwoharjo
```

---

## 📘 Panduan Penggunaan

### Login & Admin
- Login → `login.php`
- Tambah admin → `add_account.php`
- Kelola admin → `kelola_akunadmin.php`
- Reset password → `reset-password.php`

### Mahasiswa
- Input mahasiswa baru
- Edit & lihat detail mahasiswa  
- Kelola alumni, wisuda, mengulang  

### Pembayaran
- Proses pembayaran  
- Cetak bukti  
- Histori & reset pembayaran  

### Rekap & Laporan
- Rekap kuliah, mengulang, wisuda  
- Cashflow keuangan  

### Registrasi & Semester
- Buka/tutup registrasi  
- Naik semester otomatis  

---

## 📄 Lisensi / License

Aplikasi ini digunakan untuk **kepentingan internal**:

**Sentra Layanan Universitas Terbuka (SALUT) Purwoharjo — Banyuwangi**

Penggunaan di luar institusi dilarang tanpa izin resmi.

