# 🟦 salut_ut_purwoharjo

> 🇮🇩 Sistem Informasi Akademik — Sentra Layanan Universitas Terbuka Purwoharjo Banyuwangi  
> 🇬🇧 Academic Information System — Universitas Terbuka Purwoharjo Banyuwangi Service Center

---

![PHP](https://img.shields.io/badge/PHP-Native-777BB4?logo=php&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Internal%20Use%20Only-orange)
![License](https://img.shields.io/badge/License-Private-red)

---

## 📚 Daftar Isi / Table of Contents

- [Deskripsi (ID)](#-deskripsi-id)
- [Description (EN)](#-description-en)
- [Fitur Utama / Key Features](#-fitur-utama--key-features)
- [Teknologi / Tech Stack](#-teknologi--tech-stack)
- [Kebutuhan Sistem / Requirements](#-kebutuhan-sistem--requirements)
- [Instalasi / Installation](#-instalasi--installation)
- [Konfigurasi Database / Database Configuration](#-konfigurasi-database--database-configuration)
- [Panduan Penggunaan (ID)](#-panduan-penggunaan-id)
- [Catatan Keamanan / Security Notes](#-catatan-keamanan--security-notes)
- [Lisensi / License](#-lisensi--license)

---

## 📌 Deskripsi (ID)

**Salut UT** adalah aplikasi **Sistem Informasi Akademik** yang digunakan oleh  
**Sentra Layanan Universitas Terbuka (SALUT) Purwoharjo — Banyuwangi** sebagai sistem internal untuk:

- Mengelola data mahasiswa baru & aktif  
- Mengelola data alumni, wisuda, dan mahasiswa mengulang  
- Mengelola kelas & program studi  
- Mengelola pembayaran (pendaftaran, kuliah, mengulang, wisuda)  
- Melihat histori & rekap pembayaran  
- Mengelola akun admin & hak akses  
- Mengatur registrasi akademik & kenaikan semester

Aplikasi dibangun menggunakan **PHP Native** dan **MySQL**, dengan struktur modular yang sederhana sehingga mudah dipindahkan, dikembangkan, dan dirawat.

---

## 📌 Description (EN)

**Salut UT** is an internal **Academic Information System (AIS)** used by  
**Universitas Terbuka Purwoharjo Service Center — Banyuwangi** to:

- Manage new and active student data  
- Manage alumni, graduation, and retake students  
- Manage classes and study programs  
- Handle payments (registration, tuition, retake, graduation)  
- View payment history and summary reports  
- Manage admin accounts and access  
- Control academic registration and semester upgrades

The application is built with **Native PHP** and **MySQL**, designed to be simple, lightweight, and easy to maintain.

---

## 🚀 Fitur Utama / Key Features

### 🇮🇩 Bahasa Indonesia

#### 🎓 Mahasiswa & Akademik
- **Data Mahasiswa Baru**
  - `datamahasiswabaru.php`
- **Data Mahasiswa Aktif**
  - `data-mahasiswa.php`
  - Detail & view: `view_mahasiswa.php`, `view_detail.php`
  - Edit data: `editdatamahasiswa.php`, `editdatamahasiswabaru.php`
- **Data Alumni**
  - `data-alumni.php`
- **Data Wisuda**
  - `data-wisuda.php`, `view_wisuda.php`
- **Data Mengulang (Remedial)**
  - `data-mengulang.php`, `view_mengulang.php`
- **Naik Semester Otomatis**
  - `naikkan_semester.php`

#### 🏫 Kelas & Program Studi
- Data kelas dan pengelolaan kelas
  - `data-kelas.php`, `edit-kelas.php`
- Data inti kampus & program studi
  - `data-inti-kampus.php`
  - Input/edit prodi & data inti kampus:
    - `input-data-inti-kampus.php`, `process-data-inti.php`, `edit-prodi.php`
- Relasi prodi–kelas (dynamic)
  - `get_kelas_by_prodi.php`
- Mengeluarkan mahasiswa dari kelas
  - `remove_from_class.php`

#### 💵 Pembayaran & Cetak Bukti
- Pembayaran:
  - Pendaftaran
  - Kuliah
  - Mengulang
  - Wisuda
- Cetak bukti pembayaran:
  - `print.php`
  - `cetak-bayarkuliah.php`
  - `cetak-bayarmengulang.php`
  - `cetak-bayarpendaftaran.php`
  - `cetak-bayarwisuda.php`
- Histori pembayaran kuliah:
  - `histori-bayarkuliah.php`
- Reset status pembayaran:
  - `reset_pembayaran.php`
- Fungsi helper pembayaran:
  - `payment_functions.php`

#### 📊 Rekapitulasi & Laporan
- Rekap pembayaran kuliah:
  - `rekap-bayarkuliah.php`
- Rekap mengulang:
  - `rekap-bayarmengulang.php`
- Rekap wisuda:
  - `rekap-bayarwisuda.php`
- Cashflow keuangan:
  - `cashflow.php`

#### 💼 Administrasi & Registrasi
- Kelola akun admin:
  - `kelola_akunadmin.php`
  - `add_account.php`
- Buka/tutup registrasi:
  - `buka_registrasi.php`

#### 🔐 Autentikasi & Keamanan
- Halaman login:
  - `login.php`
- Logout:
  - `logout.php`
- Reset password admin:
  - `reset-password.php`
- Halaman awal yang mengarahkan ke dashboard:
  - `index.html` (redirect)
- Koneksi & inisialisasi:
  - `koneksi.php`
  - `initializing.php`
- Fungsi database umum:
  - `database_functions.php`

---

### 🇬🇧 English (Summary)

- New students and active student management  
- Alumni, graduation, and retake modules  
- Class and program management (with dynamic program–class binding)  
- Tuition, registration, retake, and graduation payment handling  
- Payment receipts and printing  
- Payment history and summary reports  
- Cashflow tracking  
- Admin account management and authentication (login, logout, reset password, add account)  
- Academic registration and automatic semester upgrade  

> For detailed behavior of each module, refer to the Indonesian usage guide below.

---

## 🧰 Teknologi / Tech Stack

- **Backend**: PHP Native  
- **Database**: MySQL / MariaDB  
- **Web Server**: Apache (XAMPP/Laragon/CPanel)  
- **Session-based authentication**  
- **Classic multi-page PHP application (no framework)**

---

## 🖥️ Kebutuhan Sistem / Requirements

- PHP **7.4+** atau **8.x**  
- MySQL / MariaDB  
- Web server (Apache)  
- XAMPP / Laragon / atau shared hosting dengan dukungan PHP & MySQL  
- Browser modern (Chrome, Firefox, Edge, dll.)

---

## ⚙️ Instalasi / Installation

### 🇮🇩 Bahasa Indonesia

1. **Clone repository:**
   ```bash
   git clone https://github.com/username/salut_ut_purwoharjo.git
