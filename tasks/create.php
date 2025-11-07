<?php
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['user_id'];
    
        if (empty($title)) {
        $_SESSION['error'] = 'Görev başlığı gerekli!';
        header('Location: ../index.php');
        exit();
    }
    
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $description);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Görev başarıyla eklendi!';
        $stmt->close();
        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Görev eklenirken bir hata oluştu!';
        $stmt->close();
        header('Location: ../index.php');
        exit();
    }
    
} else {
        header('Location: ../index.php');
    exit();
}
?>