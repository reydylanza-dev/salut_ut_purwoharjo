<?php
session_name("laravel_session");
session_start();
$_SESSION['laravel_session'] = '60496c07dhthd851100f52f34ccf3c692279+SFqbxMoR1OsEMJsYnZ11ANbTYFp8HmihXoDEaD6O';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salut Purwoharjo - Universitas Terbuka</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script charset="utf-8" src="https://cdn-client.medium.com/lite/static/js/tracing.075b133f.chunk.js"></script>
    <meta name="generator" content="SALUT Purwoharjo v2.0">

    <style>
        :root {
            --primary: #1e3c72;
            --primary-dark: #152b53;
            --secondary: #2a5298;
            --accent: #667eea;
            --accent-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --text-dark: #333333;
            --text-light: #666666;
            --white: #ffffff;
            --shadow-sm: 0 4px 6px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 30px rgba(0,0,0,0.1);
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.7;
            color: var(--text-dark);
            background-color: #fcfcfc;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .header {
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.4s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            padding: 0.8rem 0;
        }

        .header.scrolled .nav-menu a {
            color: var(--primary);
        }
        
        .header.scrolled .menu-toggle {
            color: var(--primary);
        }

        .header.scrolled .logo-white { display: none; }
        .header.scrolled .logo-color { display: block; }

        .logo-white { display: block; }
        .logo-color { display: none; }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 50px;
            width: auto;
            transition: transform 0.3s;
        }
        
        .logo:hover img {
            transform: scale(1.05);
        }

        .nav-menu {
            display: flex;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            transition: color 0.3s;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }

        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
            overflow: hidden;
        }

        .hero-slideshow {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -2;
        }

        .hero-slide {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out, transform 6s ease;
            background-size: cover;
            background-position: center;
            transform: scale(1);
        }

        .hero-slide.active {
            opacity: 1;
            transform: scale(1.1);
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(30, 60, 114, 0.9) 0%, rgba(42, 82, 152, 0.8) 100%);
            z-index: -1;
        }

        .hero-content {
            max-width: 900px;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-block;
            background: var(--accent-gradient);
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            border: 2px solid transparent;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .stats {
            background: white;
            margin-top: -80px;
            position: relative;
            z-index: 10;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            padding: 3rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.2rem;
        }

        .stat-item p {
            color: var(--text-light);
            font-weight: 500;
        }
        
        .stat-icon {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .section {
            padding: 100px 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 4rem;
            color: var(--primary);
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--accent-gradient);
            border-radius: 2px;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            position: relative;
        }

        .about-image img {
            width: 100%;
            display: block;
            transition: transform 0.5s;
        }
        
        .about-image:hover img {
            transform: scale(1.03);
        }

        .about-text h3 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .about-text p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }
        
        .highlight-box {
            background: #f0f4ff;
            border-left: 4px solid var(--accent);
            padding: 1.5rem;
            border-radius: 0 10px 10px 0;
            margin-top: 1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s;
            border: 1px solid #eee;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 0;
            background: var(--accent-gradient);
            transition: height 0.3s;
        }
        
        .feature-card:hover::before {
            height: 100%;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #f0f4ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }
        
        .feature-card:hover .feature-icon {
            background: var(--primary);
            color: white;
        }

        .feature-card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.35rem;
        }

        .programs-section {
            background-color: #f8f9fc;
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .program-card {
            background: white;
            padding: 2.5rem;
            border-radius: var(--radius);
            transition: all 0.3s;
            box-shadow: var(--shadow-sm);
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .program-card h3 {
            color: var(--primary);
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .program-card h3 i {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .program-list {
            list-style: none;
        }

        .program-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .program-list li:before {
            content: '•';
            color: var(--accent);
            font-weight: bold;
        }

        .program-list li:last-child {
            border-bottom: none;
        }

        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 4rem;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }
        
        .contact-info {
            background: var(--primary);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .contact-info h3 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .info-item i {
            margin-top: 5px;
            color: #a0b3e8;
        }

        .contact-form-wrapper {
            padding: 3rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            background: #f8f9fc;
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            background: white;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .footer {
            background: var(--primary);
            color: white;
            padding: 4rem 2rem 1rem;
            position: relative;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            margin-bottom: 1.5rem;
            color: #ffffff;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 3px;
            background: var(--accent);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.8rem;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .admin-link {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .admin-link:hover {
            background: var(--accent);
            color: white;
        }

        @media (max-width: 992px) {
            .contact-container {
                grid-template-columns: 1fr;
            }
            .hero h1 { font-size: 2.8rem; }
        }

        @media (max-width: 768px) {
            .menu-toggle { display: block; }
            
            .nav-menu {
                position: fixed;
                top: 0; right: -100%;
                width: 70%;
                height: 100vh;
                background: white;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
                transition: right 0.4s ease;
                padding-top: 60px;
            }
            
            .nav-menu.active { right: 0; }
            .nav-menu a { color: var(--primary) !important; font-size: 1.2rem; }
            
            .hero h1 { font-size: 2.2rem; }
            .hero p { font-size: 1rem; }
            
            .about-content { grid-template-columns: 1fr; }
            .stats { margin-top: 0; margin: 2rem 1rem; padding: 2rem 1rem; }
            
            .footer-bottom { flex-direction: column; text-align: center; }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <img src="img/logo-trans.png" alt="Logo SALUT" class="logo-white">
                <img src="img/logo.png" alt="Logo SALUT" class="logo-color">
            </div>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#keunggulan">Keunggulan</a></li>
                    <li><a href="#program">Program</a></li>
                    <li><a href="#kontak">Hubungi Kami</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="beranda" class="hero">
        <div class="hero-slideshow">
            <div class="hero-slide active" style="background-image: url('img/hero-1.png');"></div>
            <div class="hero-slide" style="background-image: url('img/hero-2.png');"></div>
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <h1>SALUT Purwoharjo<br>Universitas Terbuka</h1>
            <p>Raih Gelar Sarjana dari Universitas Negeri Tanpa Mengganggu Karir Anda. Kuliah Fleksibel, Biaya Terjangkau, Kualitas Terjamin.</p>
            <a href="#kontak" class="cta-button">Daftar Sekarang <i class="fas fa-arrow-right" style="margin-left: 8px;"></i></a>
        </div>
    </section>

    <section class="stats" data-aos="fade-up" data-aos-offset="-50">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <h3>1000+</h3>
                <p>Mahasiswa Aktif</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                <h3>50+</h3>
                <p>Program Studi</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>20+</h3>
                <p>Tahun Pengalaman</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-award"></i></div>
                <h3>95%</h3>
                <p>Kepuasan Alumni</p>
            </div>
        </div>
    </section>

    <section id="tentang" class="section">
        <div class="about-content">
            <div class="about-image" data-aos="fade-right">
                <img src="img/about-img.png" alt="Kegiatan Mahasiswa UT">
            </div>
            <div class="about-text" data-aos="fade-left">
                <h4 style="color: var(--accent); text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; margin-bottom: 0.5rem;">Tentang Kami</h4>
                <h3>Pendidikan Tinggi Berkualitas<br>untuk Semua Lapisan Masyarakat</h3>
                <p>SALUT (Sentra Layanan Universitas Terbuka) Purwoharjo adalah perpanjangan tangan UT untuk melayani mahasiswa di wilayah Banyuwangi Selatan. Kami hadir untuk memastikan proses belajar jarak jauh Anda berjalan lancar.</p>
                <p>Dengan sistem pembelajaran mandiri yang didukung teknologi terkini, Anda bisa kuliah di mana saja dan kapan saja tanpa harus meninggalkan pekerjaan.</p>
                
                <div class="highlight-box">
                    <strong>Visi Kami:</strong><br>
                    Menjadi mitra terdepan dalam mencerdaskan kehidupan bangsa melalui pendidikan tinggi terbuka dan jarak jauh yang berkualitas dunia.
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="section" style="background-color: #fcfcfc;">
        <h2 class="section-title" data-aos="fade-up">Mengapa Memilih Kami?</h2>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                <h3>Waktu Fleksibel</h3>
                <p>Sangat cocok untuk karyawan. Atur waktu belajar Anda sendiri tanpa terikat jadwal kelas harian yang kaku.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-wallet"></i></div>
                <h3>Biaya Terjangkau</h3>
                <p>Biaya pendidikan sangat ekonomis dibandingkan perguruan tinggi lain, namun dengan kualitas Negeri.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon"><i class="fas fa-laptop-code"></i></div>
                <h3>E-Learning Modern</h3>
                <p>Akses materi, tugas, dan diskusi melalui platform digital yang canggih dan mudah diakses dari smartphone.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                <h3>Ijazah Negeri</h3>
                <p>UT adalah PTN ke-45 di Indonesia. Ijazah diakui secara nasional untuk CPNS, BUMN, maupun swasta.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Layanan Bantuan</h3>
                <p>Tim kami siap membantu kendala administrasi, registrasi mata kuliah, hingga pengambilan bahan ajar.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3>Tutorial Tatap Muka</h3>
                <p>Tersedia layanan TTM (Tutorial Tatap Muka) bagi mahasiswa yang membutuhkan bimbingan langsung.</p>
            </div>
        </div>
    </section>

    <section id="program" class="section programs-section">
        <h2 class="section-title" data-aos="fade-up">Fakultas & Program Studi</h2>
        <div class="program-grid">
            <div class="program-card" data-aos="zoom-in" data-aos-delay="100">
                <h3><i class="fas fa-chart-line"></i> Fakultas Ekonomi</h3>
                <ul class="program-list">
                    <li>Manajemen</li>
                    <li>Akuntansi</li>
                    <li>Ekonomi Pembangunan</li>
                    <li>Pariwisata</li>
                </ul>
            </div>
            <div class="program-card" data-aos="zoom-in" data-aos-delay="200">
                <h3><i class="fas fa-balance-scale"></i> Fakultas Hukum (FHISIP)</h3>
                <ul class="program-list">
                    <li>Ilmu Hukum</li>
                    <li>Ilmu Komunikasi</li>
                    <li>Administrasi Negara</li>
                    <li>Sosiologi</li>
                </ul>
            </div>
            <div class="program-card" data-aos="zoom-in" data-aos-delay="300">
                <h3><i class="fas fa-graduation-cap"></i> Fakultas FKIP</h3>
                <ul class="program-list">
                    <li>PGSD & PGPAUD</li>
                    <li>Pendidikan Bahasa Inggris</li>
                    <li>Pendidikan Matematika</li>
                    <li>Teknologi Pendidikan</li>
                </ul>
            </div>
            <div class="program-card" data-aos="zoom-in" data-aos-delay="400">
                <h3><i class="fas fa-microscope"></i> Fakultas Sains & Tek</h3>
                <ul class="program-list">
                    <li>Sistem Informasi</li>
                    <li>Statistika</li>
                    <li>Teknologi Pangan</li>
                    <li>Agribisnis</li>
                </ul>
            </div>
            <div class="program-card" data-aos="zoom-in" data-aos-delay="500">
                <h3><i class="fas fa-user-tie"></i> Program Pascasarjana</h3>
                <ul class="program-list">
                    <li>Magister Manajemen</li>
                    <li>Magister Pendidikan Dasar</li>
                    <li>Magister Administrasi Publik</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="kontak" class="section">
        <h2 class="section-title" data-aos="fade-up">Hubungi Kami</h2>
        <div class="contact-container" data-aos="fade-up">
            <div class="contact-info">
                <h3>Informasi Kontak</h3>
                <p style="margin-bottom: 2rem; opacity: 0.9;">Punya pertanyaan seputar pendaftaran atau perkuliahan? Tim kami siap membantu Anda.</p>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt fa-lg"></i>
                    <div>
                        <strong>Alamat:</strong><br>
                        Bulurejo, Kec. Purwoharjo<br>Kab. Banyuwangi, Jawa Timur 68483
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone-alt fa-lg"></i>
                    <div>
                        <strong>Telepon / WhatsApp:</strong><br>
                        0823-3533-8889<br>
                        0813-5751-2867
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope fa-lg"></i>
                    <div>
                        <strong>Email:</strong><br>
                        salut.purwoharjo@ut.ac.id
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock fa-lg"></i>
                    <div>
                        <strong>Jam Layanan:</strong><br>
                        Senin - Jumat: 08.00 - 16.00 WIB<br>
                        Sabtu: 08.00 - 12.00 WIB
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <h3 style="color: var(--primary); margin-bottom: 1.5rem;">Kirim Pesan</h3>
                <form onsubmit="handleSubmit(event)" id="contactForm">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Nomor WhatsApp</label>
                        <input type="tel" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label for="pesan">Pesan / Pertanyaan</label>
                        <textarea id="pesan" name="pesan" rows="4" required>Halo, saya berminat mendaftar di UT Purwoharjo. Mohon infonya.</textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <div class="logo" style="margin-bottom: 1.5rem;">
                    <img src="img/logo-trans.png" alt="Logo SALUT" style="height: 45px;">
                </div>
                <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                    SALUT Purwoharjo berkomitmen melayani mahasiswa Universitas Terbuka dengan sepenuh hati demi tercapainya kelulusan tepat waktu dan berprestasi.
                </p>
                <div style="margin-top: 1.5rem;">
                    <a href="#" style="color: white; margin-right: 15px;"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" style="color: white; margin-right: 15px;"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" style="color: white;"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
            
            <div class="footer-section footer-links">
                <h3>Tautan Cepat</h3>
                <a href="https://www.ut.ac.id/" target="_blank">Website Pusat UT</a>
                <a href="https://myut.ut.ac.id/" target="_blank">MyUT (Portal Mahasiswa)</a>
                <a href="https://jember.ut.ac.id/" target="_blank">UT Jember</a>
                <a href="https://sia.ut.ac.id/" target="_blank">SIA UT</a>
            </div>

            <div class="footer-section footer-links">
                <h3>Informasi</h3>
                <a href="#program">Program Studi</a>
                <a href="#kontak">Biaya Pendidikan</a>
                <a href="#kontak">Cara Pendaftaran</a>
                <a href="#">FAQ</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> SALUT Purwoharjo - Universitas Terbuka. All Rights Reserved.</p>
            <a href="/secure/dashboard" class="admin-link"><i class="fas fa-lock"></i> Admin Login</a>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 100,
            duration: 800,
        });

        const header = document.querySelector('.header');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        const menuToggle = document.getElementById('mobile-menu');
        const navMenu = document.querySelector('.nav-menu');
        
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            if (navMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
                icon.style.color = 'var(--primary)';
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                if(!header.classList.contains('scrolled')) {
                    icon.style.color = 'white';
                }
            }
        });

        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                const icon = menuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                if(!header.classList.contains('scrolled')) {
                    icon.style.color = 'white';
                }
            });
        });

        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        setInterval(nextSlide, 5000);

        function handleSubmit(e) {
            e.preventDefault();

            const nama = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const telepon = document.getElementById('telepon').value;
            const pesan = document.getElementById('pesan').value;
            const nomorWA = '6282000000000';

            const text = `*Halo Admin SALUT Purwoharjo*%0A%0A` +
                `Nama: ${encodeURIComponent(nama)}%0A` +
                `Email: ${encodeURIComponent(email)}%0A` +
                `No. HP: ${encodeURIComponent(telepon)}%0A%0A` +
                `*Pesan:*%0A${encodeURIComponent(pesan)}`;

            window.open(`https://wa.me/${nomorWA}?text=${text}`, '_blank');

            setTimeout(() => {
                document.getElementById('contactForm').reset();
            }, 1000);
        }
    </script>
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RVJS8WQG51"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-RVJS8WQG51');
    </script>
</body>
</html>
