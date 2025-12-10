<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: dashboard/index.php");
    exit;
}
 
require_once "koneksi.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Password masih kosong";     
    } elseif(strlen(trim($_POST["new_password"])) < 8){
        $new_password_err = "Password minimal 8 karakter";
    } else{
        $new_password = trim($_POST["new_password"]);
        
        $is_weak = false;
        $weak_reason = "";
        
        if (preg_match('/(?:012|123|234|345|456|567|678|789|890|098|987|876|765|654|543|432|321|210)/', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password mengandung angka berurutan (123, 234, dst)";
        }
        
        if (preg_match('/(?:qwerty|asdfgh|zxcvbn|qwertz|azerty)/i', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password mengandung pola keyboard yang umum";
        }
        
        if (preg_match('/(\d)\1{2,}/', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password mengandung angka berulang (111, 222, dst)";
        }
        
        if (preg_match('/(?:0[1-9]|[12]\d|3[01])(?:0[1-9]|1[012])(?:19|20)?\d{2}/', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password tampak seperti tanggal lahir";
        }
        
        if (preg_match('/(?:19[5-9]\d|20[0-2]\d)/', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password mengandung format tahun yang umum";
        }
        
        if (preg_match('/^\d+$/', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password hanya terdiri dari angka";
        }
        
        if (preg_match('/^[a-zA-Z]+$/', $new_password)) {
            $is_weak = true;
            $weak_reason = "Password hanya terdiri dari huruf tanpa angka";
        }
        
        $has_letter = preg_match('/[a-zA-Z]/', $new_password);
        $has_number = preg_match('/\d/', $new_password);
        if (!$has_letter || !$has_number) {
            $is_weak = true;
            $weak_reason = "Password harus mengandung kombinasi huruf dan angka";
        }
        
        if ($is_weak) {
            $new_password_err = $weak_reason;
        }
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Masukkan password sekali lagi";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password tidak cocok";
        }
    }

    if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = "UPDATE credentials SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            if(mysqli_stmt_execute($stmt)){
                session_destroy();
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
    <title>Reset Password | Salut Purwoharjo</title>
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
            position: relative;
        }

        .back-link-top {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
            z-index: 10;
        }

        .back-link-top:hover {
            color: #764ba2;
        }

        .back-link-top i {
            font-size: 14px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 0;
            margin-top: 15px;
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

        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-wrapper .form-control {
            padding-right: 45px;
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

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            font-size: 18px;
            padding: 8px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #667eea;
        }

        .toggle-password:focus {
            outline: none;
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
            background-color: #eff6ff;
            border: 1px solid #bee3f8;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #1e40af;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-info i {
            margin-right: 8px;
            font-size: 16px;
        }

        .alert-info strong {
            display: block;
            margin-bottom: 5px;
        }

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
        }

        .strength-bar {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: #ef4444;
            width: 33%;
        }

        .strength-medium {
            background: #f59e0b;
            width: 66%;
        }

        .strength-strong {
            background: #22c55e;
            width: 100%;
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
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            color: #93c5fd;
        }

        body.dark-mode .alert-info strong {
            color: #dbeafe;
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

        body.dark-mode .back-link-top {
            color: #a78bfa;
        }

        body.dark-mode .back-link-top:hover {
            color: #c4b5fd;
        }

        body.dark-mode .toggle-password {
            color: #94a3b8;
        }

        body.dark-mode .toggle-password:hover {
            color: #a78bfa;
        }

        body.dark-mode .strength-bar {
            background: #334155;
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

            .password-input-wrapper .form-control {
                padding-right: 55px;
            }

            .alert-info {
                font-size: 16px;
                padding: 16px 20px;
                border-radius: 12px;
            }

            .alert-info i {
                font-size: 18px;
            }

            .btn-primary {
                height: 60px;
                font-size: 19px;
                border-radius: 12px;
            }

            .back-link-top {
                font-size: 16px;
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

            .password-input-wrapper .form-control {
                padding-right: 50px;
            }

            .alert-info {
                font-size: 15px;
                padding: 15px 18px;
                border-radius: 12px;
            }

            .alert-info i {
                font-size: 17px;
            }

            .btn-primary {
                height: 56px;
                font-size: 18px;
                border-radius: 12px;
            }

            .back-link-top {
                font-size: 15px;
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

            .alert-info {
                font-size: 14px;
            }

            .btn-primary {
                height: 54px;
                font-size: 17px;
            }

            .back-link-top {
                font-size: 14px;
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
            <a href="login.php" class="back-link-top">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            
            <div class="logo-container">
                <img src="img/logo-vt.png" alt="Logo VT" id="logoVT">
            </div>
            
            <h1>Reset Password</h1>
            <h2>Pastikan kombinasi password benar</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="resetPasswordForm">
                <div class="alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Syarat Password Kuat:</strong>
                    • Minimal 8 karakter<br>
                    • Kombinasi huruf dan angka<br>
                    • Hindari pola seperti: 123, tanggal lahir, angka berulang<br>
                    • Contoh kuat: Sehat2024, Jakarta99, Purwoharjo@23
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" placeholder="Masukkan password baru" id="newPassword" required minlength="8">
                        <button type="button" class="toggle-password" onclick="togglePassword('newPassword', 'toggleIcon1')">
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strengthBar"></div>
                        </div>
                        <span id="strengthText"></span>
                    </div>
                    <?php if(!empty($new_password_err)): ?>
                        <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Konfirmasi password baru" id="confirmPassword" required minlength="8">
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword', 'toggleIcon2')">
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                    <?php if(!empty($confirm_password_err)): ?>
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-primary">Reset Password</button>
                </div>
                <div class="center2">Catkay OAuth 2.0 | Ver 1.2</div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordInput && toggleIcon) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const darkModeToggle = document.getElementById('darkModeToggle');
            const logoImage = document.getElementById('logoImage');
            const logoVT = document.getElementById('logoVT');
            const newPasswordInput = document.getElementById('newPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const form = document.getElementById('resetPasswordForm');
            
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

            if (newPasswordInput) {
                newPasswordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;

                    if (password.length >= 8) strength++;
                    if (password.length >= 12) strength++;

                    const hasLetter = /[a-zA-Z]/.test(password);
                    const hasNumber = /\d/.test(password);
                    const hasUpperCase = /[A-Z]/.test(password);
                    const hasLowerCase = /[a-z]/.test(password);
                    const hasSpecial = /[^a-zA-Z0-9]/.test(password);

                    if (hasLetter && hasNumber) strength++;
                    if (hasUpperCase && hasLowerCase) strength++;
                    if (hasSpecial) strength++;

                    const weakPatterns = [
                        /(?:012|123|234|345|456|567|678|789|890|098|987|876|765|654|543|432|321|210)/,
                        /(\d)\1{2,}/,
                        /(?:qwerty|asdfgh|zxcvbn)/i,
                        /(?:0[1-9]|[12]\d|3[01])(?:0[1-9]|1[012])(?:19|20)?\d{2}/,
                        /(?:19[5-9]\d|20[0-2]\d)/,
                        /^\d+$/,
                        /^[a-zA-Z]+$/
                    ];

                    let hasWeakPattern = false;
                    weakPatterns.forEach(pattern => {
                        if (pattern.test(password)) {
                            hasWeakPattern = true;
                            strength = Math.max(0, strength - 2);
                        }
                    });

                    strengthBar.className = 'strength-bar-fill';
                    if (strength <= 2 || hasWeakPattern) {
                        strengthBar.classList.add('strength-weak');
                        strengthText.textContent = 'Lemah - Hindari pola sederhana';
                        strengthText.style.color = '#ef4444';
                    } else if (strength <= 4) {
                        strengthBar.classList.add('strength-medium');
                        strengthText.textContent = 'Sedang - Tambahkan variasi karakter';
                        strengthText.style.color = '#f59e0b';
                    } else {
                        strengthBar.classList.add('strength-strong');
                        strengthText.textContent = 'Kuat - Password aman!';
                        strengthText.style.color = '#22c55e';
                    }
                });
            }

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (newPasswordInput.value !== confirmPasswordInput.value) {
                        e.preventDefault();
                        confirmPasswordInput.classList.add('is-invalid');
                        alert('Password dan konfirmasi tidak cocok!');
                    }
                });
            }
        });
    </script>
</body>
</html>
