<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$connection) {
    die("Koneksi dengan database gagal: " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS salut_ut";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Database <b>'salut_ut'</b> berhasil dibuat... <br>";
}

$result = mysqli_select_db($connection, "salut_ut");
if (!$result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Database <b>'salut_ut'</b> berhasil dipilih... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS credentials (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        position VARCHAR(50) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'credentials'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS profil_admin (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        foto_profil VARCHAR(255) DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (username) REFERENCES credentials(username) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'profil_admin'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS data_kuliah (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        kode_prodi VARCHAR(10) NOT NULL UNIQUE,
        nama_prodi VARCHAR(100) NOT NULL,
        fakultas VARCHAR(100) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'data_kuliah'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS data_kelas (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nama_kelas VARCHAR(100) NOT NULL,
        kode_prodi VARCHAR(10) NOT NULL,
        kapasitas INT DEFAULT 40,
        jumlah_mahasiswa INT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (kode_prodi) REFERENCES data_kuliah(kode_prodi) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'data_kelas'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS data_mahasiswa (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nim VARCHAR(20) DEFAULT NULL,
        nama VARCHAR(100) NOT NULL,
        nik VARCHAR(255) NOT NULL UNIQUE,
        tempat_lahir VARCHAR(50) NOT NULL,
        tanggal_lahir DATE NOT NULL,
        nohp VARCHAR(15) NOT NULL,
        email VARCHAR(100) NOT NULL,
        alamat TEXT DEFAULT NULL,
        rt VARCHAR(3) DEFAULT NULL,
        rw VARCHAR(3) DEFAULT NULL,
        kelurahan VARCHAR(100) DEFAULT NULL,
        kecamatan VARCHAR(100) DEFAULT NULL,
        kabupaten VARCHAR(100) DEFAULT NULL,
        provinsi VARCHAR(100) DEFAULT NULL,
        kode_pos VARCHAR(10) DEFAULT NULL,
        semester INT DEFAULT NULL,
        kode_prodi VARCHAR(10) DEFAULT NULL,
        kelas_id INT DEFAULT NULL,
        status_mahasiswa ENUM('pendaftar', 'aktif', 'cuti', 'lulus', 'keluar') NOT NULL DEFAULT 'pendaftar',
        status_bayar_kuliah ENUM('belum', 'cicilan', 'lunas') NOT NULL DEFAULT 'belum',
        status_registrasi ENUM('tertutup', 'terbuka', 'terdaftar') NOT NULL DEFAULT 'terbuka',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (kode_prodi) REFERENCES data_kuliah(kode_prodi) ON DELETE RESTRICT ON UPDATE CASCADE,
        FOREIGN KEY (kelas_id) REFERENCES data_kelas(id) ON DELETE SET NULL ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'data_mahasiswa'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS data_biayakuliah (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        kode_prodi VARCHAR(10) NOT NULL,
        semester INT NOT NULL,
        biaya_fix DECIMAL(10,2) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_prodi_semester (kode_prodi, semester),
        FOREIGN KEY (kode_prodi) REFERENCES data_kuliah(kode_prodi) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'data_biayakuliah'</b> berhasil dibuat... <br>";
}


$query = "CREATE TABLE IF NOT EXISTS pembayaran_perkuliahan (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nik VARCHAR(255) NOT NULL,
        semester INT NOT NULL,
        tahun_ajaran VARCHAR(10) NOT NULL,
        total_biaya DECIMAL(12,2) NOT NULL DEFAULT 0,
        jumlah_cicilan INT NOT NULL DEFAULT 0,
        cicilan_terbayar INT NOT NULL DEFAULT 0,
        nominal_per_cicilan DECIMAL(12,2) NOT NULL DEFAULT 0,
        total_terbayar DECIMAL(12,2) NOT NULL DEFAULT 0,
        sisa_pembayaran DECIMAL(12,2) NOT NULL DEFAULT 0,
        metode_pembayaran ENUM('cash', 'cicilan') NOT NULL DEFAULT 'cash',
        status_lunas TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_nik_semester_tahun (nik, semester, tahun_ajaran),
        FOREIGN KEY (nik) REFERENCES data_mahasiswa(nik) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'pembayaran_perkuliahan'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS detail_cicilan_perkuliahan (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        pembayaran_id INT NOT NULL,
        cicilan_ke INT NOT NULL,
        nominal DECIMAL(12,2) NOT NULL,
        tanggal_bayar DATETIME DEFAULT NULL,
        status ENUM('belum', 'lunas') NOT NULL DEFAULT 'belum',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (pembayaran_id) REFERENCES pembayaran_perkuliahan(id) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'detail_cicilan_perkuliahan'</b> berhasil dibuat... <br>";
}


$query = "CREATE TABLE IF NOT EXISTS pembayaran_mengulang (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nik VARCHAR(255) NOT NULL,
        nim VARCHAR(20) DEFAULT NULL,
        nama VARCHAR(100) DEFAULT NULL,
        mata_kuliah VARCHAR(255) NOT NULL,
        tahun_ajaran VARCHAR(10) NOT NULL,
        total_biaya DECIMAL(12,2) NOT NULL DEFAULT 0,
        jumlah_cicilan INT NOT NULL DEFAULT 0,
        cicilan_terbayar INT NOT NULL DEFAULT 0,
        nominal_per_cicilan DECIMAL(12,2) NOT NULL DEFAULT 0,
        total_terbayar DECIMAL(12,2) NOT NULL DEFAULT 0,
        sisa_pembayaran DECIMAL(12,2) NOT NULL DEFAULT 0,
        metode_pembayaran ENUM('cash','cicilan') NOT NULL DEFAULT 'cash',
        status_lunas TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_nik_matkul_tahun (nik, mata_kuliah, tahun_ajaran),
        FOREIGN KEY (nik) REFERENCES data_mahasiswa(nik) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'pembayaran_mengulang'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS detail_cicilan_mengulang (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        pembayaran_id INT NOT NULL,
        cicilan_ke INT NOT NULL,
        nominal DECIMAL(12,2) NOT NULL,
        tanggal_bayar DATETIME DEFAULT NULL,
        status ENUM('belum', 'lunas') NOT NULL DEFAULT 'belum',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (pembayaran_id) REFERENCES pembayaran_mengulang(id) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'detail_cicilan_mengulang'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS pembayaran_wisuda (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nik VARCHAR(255) NOT NULL,
        nim VARCHAR(20) DEFAULT NULL,
        nama VARCHAR(100) DEFAULT NULL,
        periode_wisuda VARCHAR(20) NOT NULL,
        tahun_wisuda VARCHAR(10) NOT NULL,
        lokasi_wisuda VARCHAR(255) NOT NULL,
        total_biaya DECIMAL(12,2) NOT NULL DEFAULT 0,
        jumlah_cicilan INT NOT NULL DEFAULT 0,
        cicilan_terbayar INT NOT NULL DEFAULT 0,
        nominal_per_cicilan DECIMAL(12,2) NOT NULL DEFAULT 0,
        total_terbayar DECIMAL(12,2) NOT NULL DEFAULT 0,
        sisa_pembayaran DECIMAL(12,2) NOT NULL DEFAULT 0,
        metode_pembayaran ENUM('cash', 'cicilan') NOT NULL DEFAULT 'cash',
        status_lunas TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_nik_periode_tahun (nik, periode_wisuda, tahun_wisuda),
        FOREIGN KEY (nik) REFERENCES data_mahasiswa(nik) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'pembayaran_wisuda'</b> berhasil dibuat... <br>";
}

$query = "CREATE TABLE IF NOT EXISTS detail_cicilan_wisuda (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        pembayaran_id INT NOT NULL,
        cicilan_ke INT NOT NULL,
        nominal DECIMAL(12,2) NOT NULL,
        tanggal_bayar DATETIME DEFAULT NULL,
        status ENUM('belum', 'lunas') NOT NULL DEFAULT 'belum',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (pembayaran_id) REFERENCES pembayaran_wisuda(id) ON DELETE CASCADE ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'detail_cicilan_wisuda'</b> berhasil dibuat... <br>";
}


$query = "CREATE TABLE IF NOT EXISTS data_alumni (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nim VARCHAR(20) NOT NULL,
        nama VARCHAR(100) NOT NULL,
        nik VARCHAR(255) NOT NULL,
        kode_prodi VARCHAR(10) NOT NULL,
        tahun_lulus VARCHAR(10) NOT NULL,
        ipk DECIMAL(3,2) NOT NULL,
        tanggal_wisuda DATE DEFAULT NULL,
        lokasi_wisuda VARCHAR(255) DEFAULT NULL,
        no_sk VARCHAR(50) DEFAULT NULL,
        pekerjaan VARCHAR(100) DEFAULT NULL,
        instansi VARCHAR(100) DEFAULT NULL,
        alamat_instansi TEXT DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (nik) REFERENCES data_mahasiswa(nik) ON DELETE RESTRICT ON UPDATE CASCADE,
        FOREIGN KEY (kode_prodi) REFERENCES data_kuliah(kode_prodi) ON DELETE RESTRICT ON UPDATE CASCADE
    )";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
    die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
    echo "Tabel <b>'data_alumni'</b> berhasil dibuat... <br>";
}

mysqli_close($connection);
?>