<?php
$page_title = 'Codebym - Görev Yönetim Sistemi';
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    require_once 'includes/header.php';
    ?>

<div class="container">

    <div class="row align-items-center min-vh-100 py-5">
        <div class="col-lg-6 text-white">
            <div class="mb-4">
                <h1 class="display-3 fw-bold mb-4">
                    Görevlerini <span class="text-warning">Yönet</span>,
                    Hedeflerine <span class="text-success">Ulaş</span>!
                </h1>
                <p class="lead mb-4">
                    <span class="text-info">Codebym</span> Görev Yönetim Sistemi(GYS) ile günlük görevlerini kolayca
                    takip
                    et, organize ol ve verimliliğini
                    artır.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="register_form.php" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-rocket-takeoff"></i> Ücretsiz Başla
                    </a>
                    <a href="login_form.php" class="btn btn-outline-light btn-lg px-5">
                        <i class="bi bi-box-arrow-in-right"></i> Giriş Yap
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card glass-effect p-5">
                <div class="text-center">
                    <i class="bi bi-check2-circle text-success" style="font-size: 8rem;"></i>
                    <h3 class="mt-4 text-white">Başlamaya Hazır mısın?</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once 'includes/footer.php';
    exit();
}

$user_id = $_SESSION['user_id'];
$filter = $_GET['filter'] ?? 'all';

$sql = "SELECT * FROM tasks WHERE user_id = ?";
if ($filter === 'completed') {
    $sql .= " AND is_completed = 1";
} elseif ($filter === 'pending') {
    $sql .= " AND is_completed = 0";
}
$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stats_stmt = $conn->prepare("
    SELECT 
        COUNT(*) as total,
        SUM(is_completed) as completed,
        COUNT(*) - SUM(is_completed) as pending
    FROM tasks 
    WHERE user_id = ?
");
$stats_stmt->bind_param("i", $user_id);
$stats_stmt->execute();
$stats_result = $stats_stmt->get_result();
$stats = $stats_result->fetch_assoc();
$stats_stmt->close();

require_once 'includes/header.php';
?>

<div class="container mt-4 mb-5">


    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show fade-in">
        <i class="bi bi-check-circle-fill"></i>
        <?php 
                echo htmlspecialchars($_SESSION['success']); 
                unset($_SESSION['success']);
            ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show fade-in">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
            ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>


    <div class="row mb-4">
        <div class="col-12">
            <div class="card glass-effect text-white p-4">
                <h2 class="mb-2">Hoş Geldin, <?php echo htmlspecialchars($_SESSION['username']); ?>! 👋</h2>
                <p class="mb-0 opacity-75">Bugün ne yapmayı planlıyorsun?</p>
            </div>
        </div>
    </div>


    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card bg-primary text-white stats-card">
                <div class="card-body text-center p-4">
                    <i class="bi bi-list-task" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3 mb-2">Toplam Görev</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $stats['total']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white stats-card">
                <div class="card-body text-center p-4">
                    <i class="bi bi-check-circle-fill" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3 mb-2">Tamamlanan</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $stats['completed']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white stats-card">
                <div class="card-body text-center p-4">
                    <i class="bi bi-clock-fill" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3 mb-2">Bekleyen</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $stats['pending']; ?></h2>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-high-contrast fw-bold mb-0">
            <i class="bi bi-clipboard-check"></i> Görev Listesi
        </h3>
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="bi bi-plus-circle"></i> Yeni Görev Ekle
        </button>
    </div>


    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo $filter === 'all' ? 'active' : ''; ?>" href="?filter=all">
                <i class="bi bi-list"></i> Tümü (<?php echo $stats['total']; ?>)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $filter === 'pending' ? 'active' : ''; ?>" href="?filter=pending">
                <i class="bi bi-hourglass-split"></i> Bekleyen (<?php echo $stats['pending']; ?>)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $filter === 'completed' ? 'active' : ''; ?>" href="?filter=completed">
                <i class="bi bi-check-all"></i> Tamamlanan (<?php echo $stats['completed']; ?>)
            </a>
        </li>
    </ul>


    <?php if (empty($tasks)): ?>
    <div class="card glass-effect text-center p-5">
        <i class="bi bi-inbox" style="font-size: 4rem; color: var(--primary-color);"></i>
        <h4 class="mt-3 mb-2">Henüz görev yok</h4>
        <p class="text-muted mb-4">
            <?php if ($filter === 'completed'): ?>
            Henüz tamamlanmış görev bulunmuyor.
            <?php elseif ($filter === 'pending'): ?>
            Tüm görevler tamamlanmış! Aferin! 🎉
            <?php else: ?>
            Yeni bir görev ekleyerek başlayın.
            <?php endif; ?>
        </p>
        <?php if ($filter === 'all' || $filter === 'pending'): ?>
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
            data-bs-target="            <i class=" bi bi-plus-circle"></i> İlk Görevini Ekle
        </button>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($tasks as $task): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card task-card h-100 <?php echo $task['is_completed'] ? 'completed' : ''; ?>">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5
                            class="card-title mb-0 flex-grow-1 <?php echo $task['is_completed'] ? 'text-decoration-line-through text-muted' : 'fw-bold'; ?>">
                            <?php echo htmlspecialchars($task['title']); ?>
                        </h5>
                        <?php if ($task['is_completed']): ?>
                        <span class="badge bg-success ms-2">
                            <i class="bi bi-check-lg"></i>
                        </span>
                        <?php else: ?>
                        <span class="badge bg-warning ms-2">
                            <i class="bi bi-clock"></i>
                        </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($task['description'])): ?>
                    <p class="card-text flex-grow-1 <?php echo $task['is_completed'] ? 'text-muted' : ''; ?>">
                        <?php echo nl2br(htmlspecialchars($task['description'])); ?>
                    </p>
                    <?php endif; ?>

                    <div class="mt-auto">
                        <p class="card-text mb-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event"></i>
                                <?php echo date('d M Y, H:i', strtotime($task['created_at'])); ?>
                            </small>
                        </p>

                        <div class="d-grid gap-2">
                            <div class="btn-group" role="group">

                                <form method="POST" action="tasks/update.php" class="flex-fill">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <input type="hidden" name="action" value="toggle">
                                    <button type="submit"
                                        class="btn btn-sm w-100 <?php echo $task['is_completed'] ? 'btn-warning' : 'btn-success'; ?>">
                                        <i
                                            class="bi <?php echo $task['is_completed'] ? 'bi-arrow-counterclockwise' : 'bi-check-lg'; ?>"></i>
                                    </button>
                                </form>


                                <button type="button" class="btn btn-sm btn-info flex-fill" data-bs-toggle="modal"
                                    data-bs-target="                                    <i class=" bi
                                    bi-pencil-square"></i>
                                </button>


                                <form method="POST" action="tasks/delete.php" class="flex-fill"
                                    onsubmit="return confirm('Bu görevi silmek istediğinizden emin misiniz?');">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal<?php echo $task['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="tasks/update.php">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="bi bi-pencil-square"></i> Görevi Düzenle
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <input type="hidden" name="action" value="edit">

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-card-heading"></i> Görev Başlığı *
                                </label>
                                <input type="text" class="form-control" name="title"
                                    value="<?php echo htmlspecialchars($task['title']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-text-paragraph"></i> Açıklama
                                </label>
                                <textarea class="form-control" name="description"
                                    rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> İptal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>


<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="tasks/create.php">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle-fill"></i> Yeni Görev Ekle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="bi bi-card-heading"></i> Görev Başlığı *
                        </label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Örn: Proje sunumunu hazırla" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="bi bi-text-paragraph"></i> Açıklama (Opsiyonel)
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            placeholder="Görev hakkında detaylı bilgi..."></textarea>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Göreve dair ek notlarınızı buraya yazabilirsiniz.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> İptal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Görevi Ekle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once 'includes/footer.php'; ?>
