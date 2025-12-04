🟦 salut_ut_purwoharjo
🇮🇩 Sistem Informasi Akademik — Sentra Layanan Universitas Terbuka Purwoharjo Banyuwangi
🇬🇧 Academic Information System — Universitas Terbuka Purwoharjo Banyuwangi Service Center
📌 Deskripsi Singkat (ID)

Salut UT adalah aplikasi Sistem Informasi Akademik yang digunakan oleh
Sentra Layanan Universitas Terbuka (SALUT) Purwoharjo — Banyuwangi sebagai platform internal untuk mengelola:

Data mahasiswa baru & aktif

Data alumni, data kelas, dan data program studi

Pembayaran kuliah, mengulang, pendaftaran, dan wisuda

Rekap pembayaran & histori transaksi

Admin & autentikasi

Registrasi akademik

Proses naik semester otomatis

Dibangun menggunakan PHP Native dan MySQL, sistem ini dirancang ringan, cepat, dan mudah dikembangkan oleh admin lokal.

📌 Short Description (EN)

Salut UT is an internal Academic Information System used by
Universitas Terbuka Purwoharjo Service Center — Banyuwangi to manage:

New and active student data

Alumni, class, and program information

Tuition, registration, retake, and graduation payments

Payment records, reports, and history

Admin users & authentication

Academic registration

Automatic semester upgrade processes

Built with Native PHP and MySQL, the system is fast, lightweight, and easy to maintain.

🚀 Fitur Utama / Key Features
🇮🇩 Bahasa Indonesia
🎓 Mahasiswa & Akademik

Data mahasiswa baru (datamahasiswabaru.php)

Data mahasiswa aktif (data-mahasiswa.php)

Detail mahasiswa (view_mahasiswa.php, view_detail.php)

Edit data mahasiswa (editdatamahasiswa.php, editdatamahasiswabaru.php)

Data alumni (data-alumni.php)

Data wisuda (data-wisuda.php, view_wisuda.php)

Data mengulang (data-mengulang.php, view_mengulang.php)

Naikkan semester otomatis (naikkan_semester.php)

🏫 Kelas & Prodi

Data kelas (data-kelas.php)

Edit kelas (edit-kelas.php)

Data program studi (data-inti-kampus.php)

Input/edit prodi (input-data-inti-kampus.php, edit-prodi.php)

API kelas–prodi (get_kelas_by_prodi.php)

Mengeluarkan mahasiswa dari kelas (remove_from_class.php)

💵 Pembayaran

Pembayaran pendaftaran

Pembayaran kuliah

Pembayaran mengulang

Pembayaran wisuda

Cetak bukti pembayaran (print.php, cetak-bayar*.php`)

Histori pembayaran kuliah (histori-bayarkuliah.php)

Reset pembayaran (reset_pembayaran.php)

Payment helper (payment_functions.php)

📊 Rekapitulasi & Laporan

Rekap pembayaran kuliah (rekap-bayarkuliah.php)

Rekap mengulang (rekap-bayarmengulang.php)

Rekap wisuda (rekap-bayarwisuda.php)

Rekap umum dan laporan keuangan sederhana

💼 Keuangan & Administrasi Sistem

Cashflow keuangan (cashflow.php)

Kelola akun admin (kelola_akunadmin.php, add_account.php)

Buka/tutup registrasi (buka_registrasi.php)

🔐 Autentikasi & Keamanan

Login admin (login.php)

Logout admin (logout.php)

Reset password admin (reset-password.php)

Auto redirect (index.html)

Keamanan database via koneksi.php & initializing.php

⚙️ Instalasi / Installation
🇮🇩 Bahasa Indonesia

Clone repository:

git clone https://github.com/username/salut_ut_purwoharjo.git


Import file database (.sql) ke MySQL.

Atur kredensial database di:

koneksi.php  
initializing.php


Jalankan pada environment:

PHP 7.4+ atau 8.x

MySQL / MariaDB

XAMPP / Laragon / Hosting CPanel

Akses aplikasi melalui:

http://localhost/salut_ut_purwoharjo

📘 Panduan Penggunaan Modul (ID)
1. Login Admin

Buka login.php

Masukkan username & password

Sistem akan membawa admin ke dashboard

2. Tambah Akun Admin

Masuk menu “Kelola Akun Admin”

Gunakan add_account.php untuk membuat akun baru

3. Reset Password

Akses reset-password.php

Masukkan username dan password baru

Sistem memperbarui data admin secara instan

4. Mengelola Mahasiswa

Input mahasiswa baru → datamahasiswabaru.php

Edit data → editdatamahasiswa.php

Lihat detail → view_mahasiswa.php / view_detail.php

5. Proses Pembayaran

Pilih jenis pembayaran

Masukkan NIM/data mahasiswa

Cetak bukti pembayaran

Riwayat muncul otomatis di histori

6. Rekap Pembayaran

Rekap kuliah → rekap-bayarkuliah.php

Rekap mengulang → rekap-bayarmengulang.php

Rekap wisuda → rekap-bayarwisuda.php

7. Naikkan Semester

Admin membuka naikkan_semester.php

Sistem akan menaikkan semester seluruh mahasiswa sesuai aturan

8. Buka/Tutup Registrasi

Gunakan buka_registrasi.php

📄 Lisensi / License

Aplikasi ini digunakan khusus untuk internal SALUT Universitas Terbuka Purwoharjo.
Penggunaan di luar institusi dilarang tanpa izin resmi.

🎉 Terima Kasih

Jika aplikasi ini bermanfaat, silakan ⭐ repository-nya untuk mendukung pengembangan.
