<?php
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $task_id = intval($_POST['task_id'] ?? 0);
    $user_id = $_SESSION['user_id'];
    
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['success'] = 'Görev başarıyla silindi!';
    } else {
        $_SESSION['error'] = 'Görev silinemedi veya bulunamadı!';
    }
    
    $stmt->close();
    header('Location: ../index.php');
    exit();
    
} else {
        header('Location: ../index.php');
    exit();
}
?>