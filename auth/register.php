<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
        $errors = [];
    
        if (empty($username)) {
        $errors[] = 'Kullanıcı adı boş bırakılamaz!';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Kullanıcı adı en az 3 karakter olmalı!';
    }
    
        if (empty($email)) {
        $errors[] = 'Email adresi boş bırakılamaz!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Geçerli bir email adresi girin!';
    }
    
        if (empty($password)) {
        $errors[] = 'Şifre boş bırakılamaz!';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Şifre en az 6 karakter olmalı!';
    }
    
        if ($password !== $confirm_password) {
        $errors[] = 'Şifreler eşleşmiyor!';
    }
    
        if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: ../register_form.php');
        exit();
    }
    
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        $_SESSION['error'] = 'Veritabanı hatası: ' . $conn->error;
        header('Location: ../register_form.php');
        exit();
    }
    
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Bu kullanıcı adı veya email zaten kullanımda!';
        $stmt->close();
        header('Location: ../register_form.php');
        exit();
    }
    $stmt->close();
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        $_SESSION['error'] = 'Veritabanı hatası: ' . $conn->error;
        header('Location: ../register_form.php');
        exit();
    }
    
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Kayıt başarılı! Şimdi giriş yapabilirsiniz.';
        $stmt->close();
        header('Location: ../login_form.php');
        exit();
    } else {
        $_SESSION['error'] = 'Kayıt sırasında hata oluştu: ' . $stmt->error;
        $stmt->close();
        header('Location: ../register_form.php');
        exit();
    }
    }
    
 else {
        header('Location: ../register_form.php');
    exit();
}
?>