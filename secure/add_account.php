<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.html");
    exit;
}

if(!isset($_SESSION["position"]) || $_SESSION["position"] !== "superadmin"){
    header("location: index.html");
    exit;
}

require_once "koneksi.php";

$username = "";
$username_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Username masih kosong";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username hanya berupa huruf, angka, dan atau underscore";
    } else{
        $sql = "SELECT id FROM credentials WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username telah digunakan. Gunakan username lain";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Ada sesuatu yang salah, coba lagi nanti";
            }
            mysqli_stmt_close($stmt);
        }
    }

    if(empty($username_err)){
        $sql = "INSERT INTO credentials (username, password, position) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_position);
            
            $param_username = $username;
            $param_password = password_hash("123456789", PASSWORD_DEFAULT);
            $param_position = "admin";

            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
                exit();
            } else{
                echo "Ada sesuatu yang salah, coba lagi nanti";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Beri Akses | Salut Purwoharjo</title>
    <link rel="icon" href="img/ico.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-left a {
            display: flex;
            align-items: center;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links li > a {
            text-decoration: none;
            color: #2d3748;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links li > a:hover {
            color: #667eea;
        }

        .nav-links li > a i {
            font-size: 16px;
        }


        .navbar img {
            height: 40px;
            transition: opacity 0.3s ease;
        }

        #logoImage {
            height: 40px;
        }

        .dark-mode-toggle {
            position: relative;
            width: 70px;
            height: 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dark-mode-toggle::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 26px;
            height: 26px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .dark-mode-toggle .fa-moon,
        .dark-mode-toggle .fa-sun {
            position: absolute;
            font-size: 14px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            z-index: 1;
        }

        .dark-mode-toggle .fa-moon {
            left: 10px;
            color: #667eea;
            opacity: 1;
            pointer-events: none;
        }

        .dark-mode-toggle .fa-sun {
            right: 10px;
            color: #fbbf24;
            opacity: 0;
            pointer-events: none;
        }

        .main-container {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            padding: 35px;
            width: 100%;
            max-width: 450px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 0;
        }

        .logo-container img {
            width: 120px;
            margin-bottom: 0;
        }

        h1 {
            font-size: 28px;
            color: #1a202c;
            margin-bottom: 8px;
            font-weight: 700;
            text-align: center;
        }

        h2 {
            font-size: 14px;
            color: #718096;
            margin-bottom: 30px;
            text-align: center;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            height: 45px;
            padding: 10px 15px;
            font-size: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.3s;
            font-family: "Poppins", sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control.is-invalid {
            border-color: #e53e3e;
        }

        .invalid-feedback {
            display: block;
            color: #e53e3e;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert-info {
            background-color: #ebf8ff;
            border: 1px solid #bee3f8;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #2c5282;
            font-size: 13px;
        }

        .alert-info i {
            margin-right: 8px;
            font-size: 16px;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #166534;
            font-size: 13px;
        }

        .alert-success i {
            margin-right: 8px;
            font-size: 16px;
        }

        .btn-primary {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .center2 {
            display: block;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #718096;
        }

        body.dark-mode {
            background: #1a202c;
        }

        body.dark-mode .navbar {
            background: #2d3748;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        body.dark-mode .dark-mode-toggle {
            background: #4a5568;
        }

        body.dark-mode .dark-mode-toggle::before {
            left: calc(100% - 29px);
        }

        body.dark-mode .dark-mode-toggle .fa-moon {
            opacity: 0;
        }

        body.dark-mode .dark-mode-toggle .fa-sun {
            opacity: 1;
            color: #fbbf24;
        }

        body.dark-mode .form-card {
            background: #2d3748;
            box-shadow: 0 5px 25px rgba(0,0,0,0.5);
        }

        body.dark-mode h1 {
            color: #f7fafc;
        }

        body.dark-mode h2 {
            color: #cbd5e0;
        }

        body.dark-mode .form-group label {
            color: #e2e8f0;
        }

        body.dark-mode .form-control {
            background: #1a202c;
            border-color: #4a5568;
            color: #f7fafc;
        }

        body.dark-mode .form-control:focus {
            border-color: #667eea;
            background: #1a202c;
        }

        body.dark-mode .alert-info {
            background-color: #2c5282;
            border-color: #2c5282;
            color: #bee3f8;
        }

        body.dark-mode .alert-info strong {
            color: #ebf8ff;
        }

        body.dark-mode .alert-success {
            background-color: #166534;
            border-color: #166534;
            color: #86efac;
        }

        body.dark-mode .alert-success strong {
            color: #f0fdf4;
        }

        body.dark-mode .invalid-feedback {
            color: #fc8181;
        }

        body.dark-mode .form-control.is-invalid {
            border-color: #fc8181;
        }

        body.dark-mode .center2 {
            color: #a0aec0;
        }

        body.dark-mode .nav-links li > a {
            color: #e2e8f0;
        }

        body.dark-mode .nav-links li > a:hover {
            color: #a78bfa;
        }

        @media screen and (min-width: 768px) and (max-width: 1024px) {
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .navbar {
                margin-bottom: 0;
            }

            .main-container {
                padding: 40px 30px;
            }

            .form-card {
                max-width: 650px;
                padding: 50px 45px;
                border-radius: 20px;
                box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            }

            .logo-container img {
                width: 160px;
                margin-bottom: 0;
            }

            h1 {
                font-size: 36px;
                margin-bottom: 12px;
            }

            h2 {
                font-size: 18px;
                margin-bottom: 40px;
            }

            .form-group {
                margin-bottom: 28px;
            }

            .form-group label {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .form-control {
                height: 58px;
                font-size: 18px;
                padding: 15px 18px;
                border-radius: 12px;
            }

            .alert-info, .alert-success {
                font-size: 16px;
                padding: 16px 20px;
                border-radius: 12px;
            }

            .alert-info i, .alert-success i {
                font-size: 18px;
            }

            .btn-primary {
                height: 60px;
                font-size: 19px;
                border-radius: 12px;
            }
        }

        @media screen and (max-width: 767px) {
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .navbar {
                padding: 12px 15px;
                margin-bottom: 0;
            }

            .navbar img {
                height: 32px;
            }

            .dark-mode-toggle {
                width: 65px;
                height: 30px;
            }

            .dark-mode-toggle::before {
                width: 24px;
                height: 24px;
            }

            .dark-mode-toggle .fa-moon,
            .dark-mode-toggle .fa-sun {
                font-size: 12px;
            }

            .dark-mode-toggle .fa-moon {
                left: 8px;
            }

            .dark-mode-toggle .fa-sun {
                right: 8px;
            }

            body.dark-mode .dark-mode-toggle::before {
                left: calc(100% - 27px);
            }

            .main-container {
                padding: 25px 15px;
                min-height: calc(100vh - 56px);
            }

            .form-card {
                max-width: 100%;
                padding: 40px 25px;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            }

            .logo-container img {
                width: 140px;
                margin-bottom: 0;
            }

            h1 {
                font-size: 32px;
                margin-bottom: 10px;
            }

            h2 {
                font-size: 16px;
                margin-bottom: 35px;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-group label {
                font-size: 17px;
                margin-bottom: 9px;
            }

            .form-control {
                height: 54px;
                font-size: 17px;
                padding: 14px 16px;
                border-radius: 12px;
            }

            .alert-info, .alert-success {
                font-size: 15px;
                padding: 15px 18px;
                border-radius: 12px;
            }

            .alert-info i, .alert-success i {
                font-size: 17px;
            }

            .btn-primary {
                height: 56px;
                font-size: 18px;
                border-radius: 12px;
            }
        }

        @media screen and (max-width: 480px) {
            .form-card {
                padding: 35px 22px;
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 15px;
            }

            .form-group label {
                font-size: 16px;
            }

            .form-control {
                height: 52px;
                font-size: 16px;
            }

            .alert-info, .alert-success {
                font-size: 14px;
            }

            .btn-primary {
                height: 54px;
                font-size: 17px;
            }

            .center2 {
                font-size: 11px;
                margin-top: 12px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.html">
                <img src="img/logo.png" alt="Logo" id="logoImage">
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav-links">
                <li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
            </ul>
            <button class="dark-mode-toggle" id="darkModeToggle" type="button">
                <i class="fas fa-moon" id="moonIcon"></i>
                <i class="fas fa-sun" id="sunIcon"></i>
            </button>
        </div>
    </nav>

    <div class="main-container">
        <div class="form-card">
            <div class="logo-container">
                <img src="img/logo-vt.png" alt="Logo VT" id="logoVT">
            </div>
            
            <h1>Berikan Akses</h1>
            <h2>Buat akun admin baru</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi:</strong> Password default untuk semua user baru adalah: <strong>123456789</strong>
                </div>

                <div class="alert-success">
                    <i class="fas fa-user-shield"></i>
                    <strong>Posisi:</strong> Semua akun baru akan dibuat sebagai <strong>Admin</strong>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Masukkan username">
                    <?php if(!empty($username_err)): ?>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-primary">Berikan Akses</button>
                </div>
                <div class="center2">Catkay Auth 5.0 | Ver 12</div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const darkModeToggle = document.getElementById('darkModeToggle');
            const logoImage = document.getElementById('logoImage');
            const logoVT = document.getElementById('logoVT');
            
            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
                logoImage.src = 'img/logo-trans.png';
                logoVT.src = 'img/logo-vt-trans.png';
            }
            
            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                
                if (body.classList.contains('dark-mode')) {
                    logoImage.src = 'img/logo-trans.png';
                    logoVT.src = 'img/logo-vt-trans.png';
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    logoImage.src = 'img/logo.png';
                    logoVT.src = 'img/logo-vt.png';
                    localStorage.setItem('darkMode', 'disabled');
                }
            });
        });
    </script>
</body>
</html>
