<?php
$page_title = 'Kayıt Ol - TaskMaster';
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
                            <i class="bi bi-person-plus-fill text-gradient" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="fw-bold text-gradient">Aramıza Katıl!</h2>
                        <p class="text-muted">Ücretsiz hesap oluştur ve görevlerini yönetmeye başla</p>
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

                    <form method="POST" action="auth/register.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="bi bi-person-circle"></i> Kullanıcı Adı
                            </label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username"
                                placeholder="kullaniciadi" minlength="3" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> En az 3 karakter
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Adresi
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                placeholder="email@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-shield-lock"></i> Şifre
                            </label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                placeholder="••••••••" minlength="6" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> En az 6 karakter
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">
                                <i class="bi bi-shield-lock-fill"></i> Şifre Tekrar
                            </label>
                            <input type="password" class="form-control form-control-lg" id="confirm_password"
                                name="confirm_password" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-person-plus-fill"></i>
                                Hemen Başla</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Zaten hesabın var mı?
                                <a href="login_form.php" class="text-decoration-none fw-bold">
                                    Giriş Yap <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <small class="text-white-50">
                        <i class="bi bi-shield-check"></i> 100% Güvenli & Ücretsiz
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>