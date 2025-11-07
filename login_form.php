<?php
$page_title = 'Giriş Yap - TaskMaster';
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once 'includes/header.php';
?>

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card fade-in">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-box-arrow-in-right text-gradient" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="fw-bold text-gradient">Hoş Geldin!</h2>
                        <p class="text-muted">Hesabına giriş yap ve görevlerini yönetmeye başla</p>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php 
                                echo htmlspecialchars($_SESSION['error']); 
                                unset($_SESSION['error']);
                            ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill"></i>
                        <?php 
                                echo htmlspecialchars($_SESSION['success']); 
                                unset($_SESSION['success']);
                            ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="auth/login.php">
                        <div class="mb-4">
                            <label for="username" class="form-label">
                                <i class="bi bi-person-circle"></i> Kullanıcı Adı veya Email
                            </label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username"
                                placeholder="kullaniciadi veya email@example.com" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-shield-lock"></i> Şifre
                            </label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                placeholder="••••••••" required>

                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg"><i
                                    class="bi bi-box-arrow-in-right"></i> Giriş Yap</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Hesabın yok mu?
                                <a href="register_form.php" class="text-decoration-none fw-bold">
                                    Hemen Kayıt Ol <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>