<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard/index.php");
    exit;
}
 
require_once "koneksi.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Masukkan username Anda";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Masukkan password Anda";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM credentials WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            

                            header("location: dashboard/index.php");
                        } else{
                            $login_err = "Username atau password Anda salah";
                        }
                    }
                } else{
                    $login_err = "Username atau password Anda salah";
                }
            } else{
                echo "Oh sepertinya ada masalah, coba lagi nanti";
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
    <title>Login Page | Salut Purwoharjo</title>
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
            justify-content: space-between;
            padding: 30px 60px;
            background-image: url('img/background-lgn.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            transition: background-image 1s ease-in-out;
        }

        .main-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            padding: 35px;
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .welcome-section {
            position: relative;
            z-index: 1;
            color: white;
            max-width: 550px;
            margin-left: 60px;
            text-align: left;
        }

        .welcome-section h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
            line-height: 1.2;
            color: white;
            text-align: left;
        }

        .welcome-section p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 15px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
            font-weight: 400;
        }

        .welcome-section .highlight {
            background: rgba(102, 126, 234, 0.8);
            padding: 20px 30px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            margin-top: 25px;
            border-left: 4px solid #fff;
        }

        .welcome-section .highlight p {
            margin-bottom: 0;
            font-size: 16px;
            font-weight: 500;
        }

        .rotating-text {
            position: relative;
            min-height: 120px;
        }

        .rotating-text p {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .rotating-text p.active {
            opacity: 1;
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

        .alert-danger {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #c53030;
            font-size: 13px;
        }

        .alert-danger i {
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

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        #togglePassword {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #718096;
            font-size: 18px;
            padding: 5px;
            transition: color 0.3s;
        }

        #togglePassword:hover {
            color: #667eea;
        }

        body.dark-mode {
            background: #1a202c;
        }

        body.dark-mode .main-container::before {
            background: rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .welcome-section h1 {
            color: #f7fafc;
        }

        body.dark-mode .welcome-section p {
            color: #e2e8f0;
        }

        body.dark-mode .welcome-section .highlight {
            background: rgba(45, 55, 72, 0.9);
            border-left-color: #667eea;
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

        body.dark-mode .alert-danger {
            background-color: #742a2a;
            border-color: #742a2a;
            color: #feb2b2;
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

        body.dark-mode #togglePassword {
            color: #cbd5e0;
        }

        body.dark-mode #togglePassword:hover {
            color: #667eea;
        }

        @media screen and (min-width: 1025px) {
            .welcome-section {
                display: block;
            }
        }

        @media screen and (min-width: 768px) and (max-width: 1024px) {
            .main-container {
                padding: 40px 30px;
                flex-direction: column;
                gap: 40px;
            }

            .welcome-section {
                margin-left: 0;
                text-align: center;
                max-width: 100%;
                order: -1;
            }

            .welcome-section h1 {
                font-size: 42px;
                text-align: center;
            }

            .welcome-section p {
                font-size: 16px;
            }

            .welcome-section .highlight p {
                font-size: 15px;
            }

            .rotating-text {
                min-height: 100px;
            }

            .form-card {
                max-width: 550px;
                padding: 50px 45px;
                border-radius: 20px;
                box-shadow: 0 15px 50px rgba(0,0,0,0.4);
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

            .alert-danger {
                font-size: 16px;
                padding: 16px 20px;
                border-radius: 12px;
            }

            .alert-danger i {
                font-size: 18px;
            }

            .btn-primary {
                height: 60px;
                font-size: 19px;
                border-radius: 12px;
            }

            #togglePassword {
                font-size: 20px;
            }
        }

        @media screen and (max-width: 767px) {
            .welcome-section {
                display: none;
            }

            .form-card {
                max-width: 550px;
                padding: 50px 45px;
                border-radius: 20px;
                box-shadow: 0 15px 50px rgba(0,0,0,0.4);
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

            .alert-danger {
                font-size: 16px;
                padding: 16px 20px;
                border-radius: 12px;
            }

            .alert-danger i {
                font-size: 18px;
            }

            .btn-primary {
                height: 60px;
                font-size: 19px;
                border-radius: 12px;
            }

            #togglePassword {
                font-size: 20px;
            }
        }

        @media screen and (max-width: 767px) {
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
                justify-content: center;
            }

            .form-card {
                max-width: 100%;
                padding: 40px 25px;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.4);
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

            .alert-danger {
                font-size: 15px;
                padding: 15px 18px;
                border-radius: 12px;
            }

            .alert-danger i {
                font-size: 17px;
            }

            .btn-primary {
                height: 56px;
                font-size: 18px;
                border-radius: 12px;
            }

            #togglePassword {
                font-size: 19px;
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

            .alert-danger {
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

            #togglePassword {
                font-size: 18px;
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
            
            <h1>Login Page</h1>
            <h2>Masuk dengan akun Anda</h2>
            
            <?php 
                if(!empty($login_err)){
                    echo '<div class="alert-danger"><i class="fas fa-exclamation-circle"></i> ' . $login_err . '</div>';
                }        
            ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <?php if(!empty($username_err)): ?>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="passwordInput" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <button type="button" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    <?php if(!empty($password_err)): ?>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-primary">Masuk</button>
                </div>
                <div class="center2">Catkay Auth 5.0 | Ver 12</div>
            </form>
        </div>

        <div class="welcome-section">
            <h1>Selamat Datang di<br>Salut Purwoharjo</h1>
            <div class="rotating-text">
                <p class="active">Sentra Layanan Universitas Terbuka adalah perpanjangan tangan operasional Universitas Terbuka di daerah yang berfungsi sebagai pusat layanan akademik dan administrasi bagi mahasiswa maupun calon mahasiswa</p>
                <p>Dengan SALUT, berbagai kebutuhan administrasi dan informasi dapat diakses dengan cepat, efisien, dan transparan.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const darkModeToggle = document.getElementById('darkModeToggle');
            const logoImage = document.getElementById('logoImage');
            const logoVT = document.getElementById('logoVT');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            const mainContainer = document.querySelector('.main-container');
            
            const backgrounds = [
                'img/background-lgn.jpeg',
                'img/background-lgn2.jpeg',
                'img/background-lgn3.jpeg',
                'img/background-lgn4.jpeg'
            ];
            let currentBgIndex = 0;
            
            function changeBackground() {
                currentBgIndex = (currentBgIndex + 1) % backgrounds.length;
                mainContainer.style.backgroundImage = `url('${backgrounds[currentBgIndex]}')`;
            }
            
            setInterval(changeBackground, 5000);
            
            const rotatingTexts = document.querySelectorAll('.rotating-text p');
            let currentTextIndex = 0;
            
            function rotateText() {
                rotatingTexts[currentTextIndex].classList.remove('active');
                currentTextIndex = (currentTextIndex + 1) % rotatingTexts.length;
                rotatingTexts[currentTextIndex].classList.add('active');
            }
            
            setInterval(rotateText, 5000);
            
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

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
