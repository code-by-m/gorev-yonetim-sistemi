<?php
session_start();
require_once '../config/db.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
        if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    
    if ($_SESSION['login_attempts'] >= 5) {
        $_SESSION['error'] = 'Çok fazla başarısız giriş denemesi! Lütfen 15 dakika sonra tekrar deneyin.';
        header('Location: ../login_form.php');
        exit();
    }
    
        if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Kullanıcı adı ve şifre gerekli!';
        header('Location: ../login_form.php');
        exit();
    }
    
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
    
    if (!$stmt) {
        $_SESSION['error'] = 'Giriş sırasında bir hata oluştu. Lütfen tekrar deneyin.';
        header('Location: ../login_form.php');
        exit();
    }
    
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Kullanıcı adı/Email veya şifre hatalı!';
        $stmt->close();
        header('Location: ../login_form.php');
        exit();
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
        if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['success'] = 'Hoş geldin, ' . htmlspecialchars($user['username']) . '! 👋';
        
                $_SESSION['login_attempts'] = 0;
        
                header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Kullanıcı adı/Email veya şifre hatalı!';
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
        header('Location: ../login_form.php');
        exit();
    }
    
} else {
        header('Location: ../login_form.php');
    exit();
}
?>