<?php
require_once '../config/db.php';

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit();
}

// Form gönderildi mi kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $task_id = intval($_POST['task_id'] ?? 0);
    $user_id = $_SESSION['user_id'];
    $action = $_POST['action'] ?? '';
    
    // Görevin kullanıcıya ait olup olmadığını kontrol et
    $stmt = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Bu görevi güncelleme yetkiniz yok!';
        $stmt->close();
        header('Location: ../index.php');
        exit();
    }
    $stmt->close();
    
    if ($action === 'toggle') {
        // Görev durumunu tersine çevir (tamamlandı/tamamlanmadı)
        $stmt = $conn->prepare("UPDATE tasks SET is_completed = NOT is_completed WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Görev durumu güncellendi!';
        } else {
            $_SESSION['error'] = 'Güncelleme sırasında bir hata oluştu!';
        }
        $stmt->close();
        
    } elseif ($action === 'edit') {
        // Görev başlık ve açıklamasını güncelle
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($title)) {
            $_SESSION['error'] = 'Görev başlığı boş olamaz!';
            header('Location: ../index.php');
            exit();
        }
        
        $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $title, $description, $task_id, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Görev başarıyla güncellendi!';
        } else {
            $_SESSION['error'] = 'Güncelleme sırasında bir hata oluştu!';
        }
        $stmt->close();
    }
    
    header('Location: ../index.php');
    exit();
    
} else {
    // Doğrudan erişim engelle
    header('Location: ../index.php');
    exit();
}
?>