<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="card-header text-center py-4">
                <h3 class="mb-0">
                    <i class="bi bi-box-arrow-in-right text-primary"></i>
                    Đăng Nhập
                </h3>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/login">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="bi bi-person"></i> Tên đăng nhập hoặc Email
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Nhập tên đăng nhập hoặc email"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Mật khẩu
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Nhập mật khẩu"
                                   required>
                            <button class="btn btn-outline-secondary" 
                                    type="button" 
                                    onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="password-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                        </button>
                    </div>
                </form>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <p class="mb-2">Chưa có tài khoản?</p>
                    <a href="<?php echo BASE_URL; ?>/register" class="btn btn-outline-light">
                        <i class="bi bi-person-plus"></i> Đăng Ký Ngay
                    </a>
                </div>
                
                <div class="text-center mt-3">
                    <a href="<?php echo BASE_URL; ?>/forgot-password" class="text-decoration-none">
                        <small>Quên mật khẩu?</small>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Demo Account Info -->
        <div class="card mt-3 border-warning">
            <div class="card-body">
                <h6 class="card-title text-warning">
                    <i class="bi bi-info-circle"></i> Tài Khoản Demo
                </h6>
                <small class="text-muted">
                    <strong>Admin:</strong> admin / password<br>
                    <strong>User:</strong> user1 / password
                </small>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
