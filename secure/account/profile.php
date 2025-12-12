<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

require_once "../koneksi.php";

$username = $_SESSION["username"];
$message = '';
$error = '';

$sql = "SELECT c.username, c.position, p.foto_profil, p.updated_at 
        FROM credentials c 
        LEFT JOIN profil_admin p ON c.username = p.username 
        WHERE c.username = ?";
        
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $profil = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    die("Error: Tidak dapat mengambil data profil.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['hapus_foto'])) {
    $target_dir = "../uploads/profil/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $uploaded = false;
    
    if (!empty($_POST['cropped_image'])) {
        $imageData = $_POST['cropped_image'];
        
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = str_replace(' ', '+', $imageData);
            $decodedImage = base64_decode($imageData);
            
            if ($decodedImage !== false) {
                $new_filename = $username . '_' . time() . '.jpg';
                $target_file = $target_dir . $new_filename;
                
                if (file_put_contents($target_file, $decodedImage)) {
                    if (!empty($profil['foto_profil']) && file_exists($profil['foto_profil'])) {
                        unlink($profil['foto_profil']);
                    }
                    
                    $check_sql = "SELECT username FROM profil_admin WHERE username = ?";
                    $check_stmt = mysqli_prepare($link, $check_sql);
                    mysqli_stmt_bind_param($check_stmt, "s", $username);
                    mysqli_stmt_execute($check_stmt);
                    $check_result = mysqli_stmt_get_result($check_stmt);
                    $exists = mysqli_num_rows($check_result) > 0;
                    mysqli_stmt_close($check_stmt);
                    
                    if ($exists) {
                        $update_sql = "UPDATE profil_admin SET foto_profil = ?, updated_at = NOW() WHERE username = ?";
                        $update_stmt = mysqli_prepare($link, $update_sql);
                        mysqli_stmt_bind_param($update_stmt, "ss", $target_file, $username);
                    } else {
                        $update_sql = "INSERT INTO profil_admin (username, foto_profil) VALUES (?, ?)";
                        $update_stmt = mysqli_prepare($link, $update_sql);
                        mysqli_stmt_bind_param($update_stmt, "ss", $username, $target_file);
                    }
                    
                    if (mysqli_stmt_execute($update_stmt)) {
                        mysqli_stmt_close($update_stmt);
                        mysqli_close($link);
                        header("Location: profile.php?upload=success");
                        exit();
                    } else {
                        $error = "Gagal menyimpan data foto profil.";
                    }
                    mysqli_stmt_close($update_stmt);
                    $uploaded = true;
                } else {
                    $error = "Gagal menyimpan file.";
                }
            } else {
                $error = "Gagal decode gambar.";
            }
        } else {
            $error = "Format gambar tidak valid.";
        }
    } 
    else if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === 0 && !$uploaded) {
        $file = $_FILES['foto_profil'];
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $new_filename = $username . '_' . time() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            if ($file["size"] <= 2000000) {
                if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        if (!empty($profil['foto_profil']) && file_exists($profil['foto_profil'])) {
                            unlink($profil['foto_profil']);
                        }
                        
                        $check_sql = "SELECT username FROM profil_admin WHERE username = ?";
                        $check_stmt = mysqli_prepare($link, $check_sql);
                        mysqli_stmt_bind_param($check_stmt, "s", $username);
                        mysqli_stmt_execute($check_stmt);
                        $check_result = mysqli_stmt_get_result($check_stmt);
                        $exists = mysqli_num_rows($check_result) > 0;
                        mysqli_stmt_close($check_stmt);
                        
                        if ($exists) {
                            $update_sql = "UPDATE profil_admin SET foto_profil = ?, updated_at = NOW() WHERE username = ?";
                            $update_stmt = mysqli_prepare($link, $update_sql);
                            mysqli_stmt_bind_param($update_stmt, "ss", $target_file, $username);
                        } else {
                            $update_sql = "INSERT INTO profil_admin (username, foto_profil) VALUES (?, ?)";
                            $update_stmt = mysqli_prepare($link, $update_sql);
                            mysqli_stmt_bind_param($update_stmt, "ss", $username, $target_file);
                        }
                        
                        if (mysqli_stmt_execute($update_stmt)) {
                            mysqli_stmt_close($update_stmt);
                            mysqli_close($link);
                            header("Location: profile.php?upload=success");
                            exit();
                        } else {
                            $error = "Gagal menyimpan data foto profil.";
                        }
                        mysqli_stmt_close($update_stmt);
                    } else {
                        $error = "Gagal mengupload file.";
                    }
                } else {
                    $error = "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
                }
            } else {
                $error = "Ukuran file terlalu besar. Maksimal 2MB.";
            }
        } else {
            $error = "File bukan gambar yang valid.";
        }
    }
}

if (isset($_POST['hapus_foto'])) {
    if (!empty($profil['foto_profil']) && file_exists($profil['foto_profil'])) {
        unlink($profil['foto_profil']);
    }
    
    $delete_sql = "UPDATE profil_admin SET foto_profil = NULL, updated_at = NOW() WHERE username = ?";
    $delete_stmt = mysqli_prepare($link, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "s", $username);
    if (mysqli_stmt_execute($delete_stmt)) {
        mysqli_stmt_close($delete_stmt);
        mysqli_close($link);
        header("Location: profile.php?delete=success");
        exit();
    }
    mysqli_stmt_close($delete_stmt);
}

if (isset($_GET['upload']) && $_GET['upload'] === 'success') {
    $message = "Foto profil berhasil diupdate!";
    echo "<script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>";
}
if (isset($_GET['delete']) && $_GET['delete'] === 'success') {
    $message = "Foto profil berhasil dihapus!";
    echo "<script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>";
}

$user_position = strtolower($profil['position']);
mysqli_close($link);
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Salut Purwoharjo</title>
    <link rel="icon" href="../img/ico.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f5f5f5;
            transition: background 0.3s ease;
        }

        .navbar {
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-left a {
            display: flex;
            align-items: center;
        }

        .navbar-left img {
            height: 45px;
            transition: opacity 0.3s ease;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
            list-style: none;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links li a {
            text-decoration: none;
            color: #2d3748;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .nav-links li a:hover {
            color: #667eea;
        }

        .nav-links li a i {
            font-size: 16px;
        }

        .user-profile-nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar-small {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .user-avatar-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar-placeholder {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            background: white;
            min-width: 220px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            padding: 8px 0;
        }

        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
        }

        .dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a,
        .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #2d3748;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
        }

        .dropdown-menu a:hover,
        .dropdown-menu .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .dropdown-menu a i,
        .dropdown-menu .dropdown-item i {
            margin-right: 12px;
            width: 18px;
            text-align: center;
        }

        .dropdown-menu .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 8px 0;
        }

        .dropdown-item.dark-mode-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
        }

        .dropdown-item.dark-mode-item:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .dropdown-item.dark-mode-item span {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .desktop-dark-toggle {
            position: relative;
            width: 45px;
            height: 24px;
            background: #cbd5e0;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .desktop-dark-toggle::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .burger-menu {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .burger-menu:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .burger-menu span {
            width: 25px;
            height: 3px;
            background: #2d3748;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .mobile-menu {
            position: fixed;
            top: 75px;
            right: -100%;
            width: 280px;
            height: calc(100vh - 75px);
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            transition: right 0.3s ease;
            overflow-y: auto;
            z-index: 999;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-content {
            padding: 20px;
        }

        .mobile-menu-header {
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 20px;
        }

        .mobile-menu-header h3 {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .mobile-menu-header .user-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }

        .badge-dark { background: #2d3748; color: white; }
        .badge-info { background: #5BC0DE; color: white; }
        .badge-success { background: #5CB85C; color: white; }

        .mobile-menu-section {
            margin-bottom: 25px;
        }

        .mobile-menu-section h4 {
            font-size: 13px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            text-decoration: none;
            color: #2d3748;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .mobile-menu-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .mobile-menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .dark-mode-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            border-radius: 8px;
            background: rgba(102, 126, 234, 0.05);
            margin-bottom: 5px;
        }

        .dark-mode-item span {
            display: flex;
            align-items: center;
            color: #2d3748;
            font-size: 15px;
        }

        .dark-mode-item span i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .dark-mode-toggle {
            position: relative;
            width: 50px;
            height: 26px;
            background: #cbd5e0;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dark-mode-toggle::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 998;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px 140px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .profile-header h2 {
            font-size: 28px;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }

        .profile-header p {
            font-size: 15px;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        .profile-body {
            padding: 40px 30px;
            padding-top: 20px;
            position: relative;
        }

        .foto-profil-container {
            width: 180px;
            height: 180px;
            margin: -110px auto 30px;
            border-radius: 50%;
            overflow: hidden;
            border: 6px solid white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        .foto-profil-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .foto-profil-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 64px;
            font-weight: 700;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-group {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .info-group:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .info-group label {
            display: block;
            font-size: 13px;
            color: #718096;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-group .value {
            font-size: 16px;
            color: #2d3748;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-group .value i {
            color: #667eea;
            font-size: 18px;
        }

        .position-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }

        .upload-section {
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px dashed #cbd5e0;
        }

        .upload-section h3 {
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .upload-section h3 i {
            color: #667eea;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            margin-left: 10px;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInBottom 0.4s ease;
            position: fixed;
            bottom: 20px;
            left: 20px;
            max-width: 400px;
            z-index: 9999;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .alert.hiding {
            opacity: 0;
            transform: translateX(-100%);
        }

        @keyframes slideInBottom {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-hint {
            font-size: 13px;
            color: #666;
            margin-top: 10px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .form-hint i {
            margin-top: 2px;
            color: #667eea;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
            position: relative;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-header h3 {
            font-size: 22px;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h3 i {
            color: #667eea;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            color: #718096;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .file-input-wrapper {
            position: relative;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .file-input-wrapper input[type="file"] {
            display: none;
        }

        .file-input-label {
            padding: 12px 25px;
            background: #667eea;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .file-input-label:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .file-name {
            color: #718096;
            font-size: 14px;
        }

        .preview-container {
            display: none;
            margin-top: 20px;
        }

        .preview-container.show {
            display: block;
        }

        .preview-label {
            display: block;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .preview-wrapper {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .crop-container {
            width: 300px;
            height: 300px;
            margin: 0 auto;
            border: 3px solid #667eea;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            background: #f8f9fa;
        }

        .preview-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: center center;
            transition: transform 0.1s ease;
            pointer-events: auto;
        }

        .crop-controls {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .zoom-control {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .zoom-control label {
            font-size: 14px;
            color: #2d3748;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .zoom-control input[type="range"] {
            flex: 1;
            height: 6px;
            border-radius: 5px;
            background: #e2e8f0;
            outline: none;
            -webkit-appearance: none;
        }

        .zoom-control input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .zoom-control input[type="range"]::-webkit-slider-thumb:hover {
            background: #5568d3;
            transform: scale(1.2);
        }

        .crop-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .crop-btn.reset {
            background: #e2e8f0;
            color: #2d3748;
        }

        .crop-btn.reset:hover {
            background: #cbd5e0;
        }

        .modal-actions {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .delete-modal .modal-content {
            max-width: 450px;
        }

        .delete-warning {
            text-align: center;
            padding: 20px 0;
        }

        .delete-warning i {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .delete-warning p {
            font-size: 16px;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .delete-warning .warning-text {
            color: #718096;
            font-size: 14px;
        }

        body.dark-mode {
            background: #1a202c;
        }

        body.dark-mode .navbar {
            background: #2d3748;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        body.dark-mode .navbar-left img {
            content: url('../img/logo-trans.png');
        }

        body.dark-mode .nav-links li a {
            color: #e2e8f0;
        }

        body.dark-mode .user-avatar-small {
            border-color: #a78bfa;
        }

        body.dark-mode .dropdown-menu {
            background: #2d3748;
        }

        body.dark-mode .dropdown-menu::before {
            background: #2d3748;
        }

        body.dark-mode .dropdown-menu a,
        body.dark-mode .dropdown-menu .dropdown-item {
            color: #e2e8f0;
        }

        body.dark-mode .dropdown-menu .divider {
            background: #4a5568;
        }

        body.dark-mode .desktop-dark-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body.dark-mode .desktop-dark-toggle::before {
            left: calc(100% - 21px);
        }

        body.dark-mode .dropdown-item.dark-mode-item:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        body.dark-mode .dropdown-item.dark-mode-item span {
            color: #e2e8f0;
        }

        body.dark-mode .burger-menu span {
            background: #e2e8f0;
        }

        body.dark-mode .mobile-menu {
            background: #2d3748;
        }

        body.dark-mode .mobile-menu-header {
            border-bottom-color: #4a5568;
        }

        body.dark-mode .mobile-menu-header h3 {
            color: #f7fafc;
        }

        body.dark-mode .mobile-menu-section h4 {
            color: #a0aec0;
        }

        body.dark-mode .mobile-menu-item {
            color: #e2e8f0;
        }

        body.dark-mode .dark-mode-item {
            background: rgba(102, 126, 234, 0.1);
        }

        body.dark-mode .dark-mode-item span {
            color: #e2e8f0;
        }

        body.dark-mode .dark-mode-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body.dark-mode .dark-mode-toggle::before {
            left: calc(100% - 23px);
        }

        body.dark-mode .profile-card {
            background: #2d3748;
        }

        body.dark-mode .info-group {
            background: #1a202c;
        }

        body.dark-mode .info-group label {
            color: #a0aec0;
        }

        body.dark-mode .info-group .value {
            color: #f7fafc;
        }

        body.dark-mode .upload-section {
            background: #1a202c;
            border-color: #4a5568;
        }

        body.dark-mode .upload-section h3 {
            color: #f7fafc;
        }

        body.dark-mode .form-hint {
            color: #cbd5e0;
        }

        body.dark-mode .modal-content {
            background: #2d3748;
        }

        body.dark-mode .modal-header {
            border-bottom-color: #4a5568;
        }

        body.dark-mode .modal-header h3 {
            color: #f7fafc;
        }

        body.dark-mode .modal-close {
            color: #cbd5e0;
        }

        body.dark-mode .preview-label {
            color: #a78bfa;
        }

        body.dark-mode .preview-wrapper {
            background: #1a202c;
        }

        body.dark-mode .crop-container {
            background: #2d3748;
        }

        body.dark-mode .zoom-control label {
            color: #cbd5e0;
        }

        body.dark-mode .delete-warning p {
            color: #e2e8f0;
        }

        body.dark-mode .delete-warning .warning-text {
            color: #a0aec0;
        }

        body.dark-mode .alert-success {
            background: #14532d;
            color: #86efac;
            border-color: #166534;
        }

        body.dark-mode .alert-error {
            background: #7f1d1d;
            color: #fecaca;
            border-color: #991b1b;
        }

        body.dark-mode .file-name {
            color: #cbd5e0;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .burger-menu {
                display: flex;
            }

            .alert {
                left: 10px;
                right: 10px;
                max-width: calc(100% - 20px);
            }

            .profile-header {
                padding: 30px 20px 120px;
            }

            .profile-header h2 {
                font-size: 24px;
            }

            .profile-body {
                padding: 30px 20px;
                padding-top: 20px;
            }

            .foto-profil-container {
                width: 150px;
                height: 150px;
                margin-top: -95px;
            }

            .foto-profil-placeholder {
                font-size: 54px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .upload-section {
                padding: 20px;
            }

            .modal-content {
                padding: 20px;
                width: 95%;
            }

            .modal-header h3 {
                font-size: 18px;
            }

            .crop-container {
                width: 250px;
                height: 250px;
            }

            .modal-actions {
                flex-direction: column;
            }

            .modal-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (min-width: 769px) {
            .burger-menu {
                display: none !important;
            }

            .mobile-menu {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="../">
                <img src="../img/logo.png" alt="Logo">
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav-links">
                <li><a href="../"><i class="fas fa-home"></i> Home</a></li>
                <li class="dropdown" id="dropdown">
                    <a class="dropdown-toggle">
                        <div class="user-profile-nav">
                            <div class="user-avatar-small">
                                <?php if (!empty($profil['foto_profil']) && file_exists($profil['foto_profil'])): ?>
                                    <img src="<?php echo htmlspecialchars($profil['foto_profil']); ?>" alt="<?php echo htmlspecialchars($username); ?>">
                                <?php else: ?>
                                    <span class="user-avatar-placeholder">
                                        <?php echo strtoupper(substr($username, 0, 1)); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu">
                        <a href="profile.php">
                            <i class="fas fa-user"></i> Profil
                        </a>
                        <a href="../reset-password.php">
                            <i class="fas fa-key"></i> Reset Password
                        </a>
                        <div class="divider"></div>
                        <div class="dropdown-item dark-mode-item">
                            <span>
                                <i class="fas fa-moon"></i>
                                <span>Dark Mode</span>
                            </span>
                            <button class="desktop-dark-toggle" id="desktopDarkToggle" type="button"></button>
                        </div>
                        <div class="divider"></div>
                        <a href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </a>
                    </div>
                </li>
            </ul>
            <div class="burger-menu" id="burgerMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <div class="overlay" id="overlay"></div>

    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <h3><?php echo htmlspecialchars($username); ?></h3>
                <span class="user-badge badge-<?php 
                    if($user_position == 'superadmin') echo 'dark';
                    elseif($user_position == 'administrasi') echo 'info';
                    elseif($user_position == 'keuangan') echo 'success';
                ?>"><?php echo strtoupper($user_position); ?></span>
            </div>

            <div class="mobile-menu-section">
                <h4>Navigation</h4>
                <a href="../" class="mobile-menu-item">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>

            <div class="mobile-menu-section">
                <h4>Settings</h4>
                <a href="profile.php" class="mobile-menu-item">
                    <i class="fas fa-user"></i> Profil
                </a>
                <a href="../reset-password.php" class="mobile-menu-item">
                    <i class="fas fa-key"></i> Reset Password
                </a>
                <div class="dark-mode-item">
                    <span><i class="fas fa-moon"></i> Dark Mode</span>
                    <button class="dark-mode-toggle" id="darkModeToggle" type="button"></button>
                </div>
                <a href="../logout.php" class="mobile-menu-item">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <h2>Profil Pengguna</h2>
                <p>Kelola informasi dan foto profil Anda</p>
            </div>

            <div class="profile-body">
                <?php if ($message): ?>
                    <div class="alert alert-success" id="successAlert">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo $message; ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-error" id="errorAlert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <div class="foto-profil-container">
                    <?php if (!empty($profil['foto_profil']) && file_exists($profil['foto_profil'])): ?>
                        <img src="<?php echo htmlspecialchars($profil['foto_profil']); ?>" alt="Foto Profil">
                    <?php else: ?>
                        <div class="foto-profil-placeholder">
                            <?php echo strtoupper(substr($profil['username'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="info-grid">
                    <div class="info-group">
                        <label>Username</label>
                        <div class="value">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($profil['username']); ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Posisi</label>
                        <div class="value">
                            <i class="fas fa-id-badge"></i>
                            <span class="position-text"><?php echo strtoupper($user_position); ?></span>
                        </div>
                    </div>
                </div>

                <div class="upload-section">
                    <h3><i class="fas fa-camera"></i> Update Foto Profil</h3>
                    
                    <p class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Klik tombol di bawah untuk mengupload atau menghapus foto profil Anda</span>
                    </p>

                    <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="button" class="btn btn-primary" id="openUploadModal">
                            <i class="fas fa-upload"></i>
                            Upload Foto
                        </button>
                        
                        <?php if (!empty($profil['foto_profil'])): ?>
                        <button type="button" class="btn btn-danger" id="openDeleteModal">
                            <i class="fas fa-trash"></i>
                            Hapus Foto
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="uploadModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-upload"></i> Upload Foto Profil</h3>
                <button class="modal-close" id="closeUploadModal">&times;</button>
            </div>

            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="cropped_image" id="croppedImage">
                
                <div class="file-input-wrapper">
                    <input type="file" name="foto_profil" id="foto_profil" accept="image/*">
                    <label for="foto_profil" class="file-input-label">
                        <i class="fas fa-image"></i>
                        Pilih Foto
                    </label>
                    <span class="file-name" id="fileName">Belum ada file dipilih</span>
                </div>
                
                <p class="form-hint">
                    <i class="fas fa-info-circle"></i>
                    <span>Format: JPG, JPEG, PNG, GIF. Maksimal: 2MB</span>
                </p>
                
                <div class="preview-container" id="previewContainer">
                    <span class="preview-label">Pratinjau & Crop Foto:</span>
                    <div class="preview-wrapper">
                        <div class="crop-container" id="cropContainer">
                            <img id="previewImage" class="preview-image" alt="Preview">
                        </div>
                        <div class="crop-controls">
                            <div class="zoom-control">
                                <label for="zoomRange"><i class="fas fa-search-plus"></i> Zoom:</label>
                                <input type="range" id="zoomRange" min="1" max="3" step="0.1" value="1">
                            </div>
                            <button type="button" class="crop-btn reset" id="resetCrop">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" id="cancelUpload">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Upload Foto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay delete-modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h3>
                <button class="modal-close" id="closeDeleteModal">&times;</button>
            </div>

            <div class="delete-warning">
                <i class="fas fa-trash-alt"></i>
                <p>Apakah Anda yakin ingin menghapus foto profil?</p>
                <p class="warning-text">Tindakan ini tidak dapat dibatalkan.</p>
            </div>

            <form method="POST" id="deleteForm">
                <input type="hidden" name="hapus_foto" value="1">
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" id="cancelDelete">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const dropdown = document.getElementById('dropdown');
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            const burgerMenu = document.getElementById('burgerMenu');
            const mobileMenu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('overlay');
            const darkModeToggle = document.getElementById('darkModeToggle');
            const desktopDarkToggle = document.getElementById('desktopDarkToggle');

            const uploadModal = document.getElementById('uploadModal');
            const deleteModal = document.getElementById('deleteModal');
            const openUploadBtn = document.getElementById('openUploadModal');
            const openDeleteBtn = document.getElementById('openDeleteModal');
            const closeUploadBtn = document.getElementById('closeUploadModal');
            const closeDeleteBtn = document.getElementById('closeDeleteModal');
            const cancelUploadBtn = document.getElementById('cancelUpload');
            const cancelDeleteBtn = document.getElementById('cancelDelete');

            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('hiding');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            function toggleDarkMode() {
                body.classList.toggle('dark-mode');
                
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                }
            }

            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
            }

            function openModal(modal) {
                modal.classList.add('active');
                body.style.overflow = 'hidden';
            }

            function closeModal(modal) {
                modal.classList.remove('active');
                body.style.overflow = '';
            }

            if (openUploadBtn) openUploadBtn.addEventListener('click', () => openModal(uploadModal));
            if (openDeleteBtn) openDeleteBtn.addEventListener('click', () => openModal(deleteModal));
            if (closeUploadBtn) closeUploadBtn.addEventListener('click', () => closeModal(uploadModal));
            if (cancelUploadBtn) cancelUploadBtn.addEventListener('click', () => closeModal(uploadModal));
            if (closeDeleteBtn) closeDeleteBtn.addEventListener('click', () => closeModal(deleteModal));
            if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => closeModal(deleteModal));

            uploadModal.addEventListener('click', e => {
                if (e.target === uploadModal) closeModal(uploadModal);
            });

            deleteModal.addEventListener('click', e => {
                if (e.target === deleteModal) closeModal(deleteModal);
            });

            const fileInput = document.getElementById('foto_profil');
            const fileName = document.getElementById('fileName');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const cropContainer = document.getElementById('cropContainer');
            
            let currentImage = null;
            let scale = 1;
            let posX = 0;
            let posY = 0;
            let isDragging = false;
            let startX, startY;

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    fileName.textContent = file.name;
                    
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        currentImage = event.target.result;
                        previewImage.src = currentImage;
                        
                        previewImage.onload = function() {
                            previewContainer.classList.add('show');
                            
                            const containerSize = 300;
                            const imgWidth = previewImage.naturalWidth;
                            const imgHeight = previewImage.naturalHeight;
                            
                            const scaleToFit = Math.max(
                                containerSize / imgWidth,
                                containerSize / imgHeight
                            );
                            
                            previewImage.style.width = imgWidth + 'px';
                            previewImage.style.height = imgHeight + 'px';
                            
                            scale = scaleToFit;
                            posX = 0;
                            posY = 0;
                            
                            document.getElementById('zoomRange').value = 1;
                            updateImageTransform();
                        };
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileName.textContent = 'Belum ada file dipilih';
                    previewContainer.classList.remove('show');
                    currentImage = null;
                }
            });
            
            document.getElementById('zoomRange').addEventListener('input', function(e) {
                const containerSize = 300;
                const baseScale = Math.max(
                    containerSize / previewImage.naturalWidth,
                    containerSize / previewImage.naturalHeight
                );
                scale = baseScale * parseFloat(e.target.value);
                updateImageTransform();
            });
            
            document.getElementById('resetCrop').addEventListener('click', function() {
                const containerSize = 300;
                const baseScale = Math.max(
                    containerSize / previewImage.naturalWidth,
                    containerSize / previewImage.naturalHeight
                );
                scale = baseScale;
                posX = 0;
                posY = 0;
                document.getElementById('zoomRange').value = 1;
                updateImageTransform();
            });
            
            previewImage.addEventListener('mousedown', startDrag);
            previewImage.addEventListener('touchstart', startDrag);
            
            function startDrag(e) {
                isDragging = true;
                if (e.type === 'mousedown') {
                    startX = e.clientX - posX;
                    startY = e.clientY - posY;
                } else {
                    startX = e.touches[0].clientX - posX;
                    startY = e.touches[0].clientY - posY;
                }
                previewImage.style.cursor = 'grabbing';
            }
            
            document.addEventListener('mousemove', drag);
            document.addEventListener('touchmove', drag);
            
            function drag(e) {
                if (!isDragging) return;
                e.preventDefault();
                
                if (e.type === 'mousemove') {
                    posX = e.clientX - startX;
                    posY = e.clientY - startY;
                } else {
                    posX = e.touches[0].clientX - startX;
                    posY = e.touches[0].clientY - startY;
                }
                
                updateImageTransform();
            }
            
            document.addEventListener('mouseup', stopDrag);
            document.addEventListener('touchend', stopDrag);
            
            function stopDrag() {
                isDragging = false;
                previewImage.style.cursor = 'grab';
            }
            
            function updateImageTransform() {
                previewImage.style.transform = `translate(-50%, -50%) translate(${posX}px, ${posY}px) scale(${scale})`;
            }
            
            previewImage.style.cursor = 'grab';
            
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                if (currentImage && previewContainer.classList.contains('show')) {
                    e.preventDefault();
                    
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const img = new Image();
                    
                    img.onload = function() {
                        const size = 500;
                        canvas.width = size;
                        canvas.height = size;
                        
                        const containerRect = cropContainer.getBoundingClientRect();
                        const imgRect = previewImage.getBoundingClientRect();
                        
                        const scaleX = img.naturalWidth / (imgRect.width / scale);
                        const scaleY = img.naturalHeight / (imgRect.height / scale);
                        
                        const offsetX = (containerRect.left - imgRect.left) * (scaleX / scale);
                        const offsetY = (containerRect.top - imgRect.top) * (scaleY / scale);
                        
                        const cropWidth = containerRect.width * scaleX / scale;
                        const cropHeight = containerRect.height * scaleY / scale;
                        
                        ctx.drawImage(
                            img,
                            Math.max(0, offsetX),
                            Math.max(0, offsetY),
                            Math.min(cropWidth, img.naturalWidth),
                            Math.min(cropHeight, img.naturalHeight),
                            0,
                            0,
                            size,
                            size
                        );
                        
                        document.getElementById('croppedImage').value = canvas.toDataURL('image/jpeg', 0.9);
                        document.getElementById('uploadForm').submit();
                    };
                    
                    img.src = currentImage;
                }
            });
            
            if(dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                });
                
                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            }
            
            if(burgerMenu) {
                burgerMenu.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    overlay.classList.toggle('active');
                    body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
                });
            }
            
            if(overlay) {
                overlay.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    overlay.classList.remove('active');
                    body.style.overflow = '';
                });
            }
            
            if(darkModeToggle) darkModeToggle.addEventListener('click', toggleDarkMode);
            if(desktopDarkToggle) {
                desktopDarkToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDarkMode();
                });
            }
        });
    </script>
</body>
</html>