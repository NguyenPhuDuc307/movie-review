<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header text-center py-4">
                <h3 class="mb-0">
                    <i class="bi bi-person-plus text-primary"></i>
                    Đăng Ký Tài Khoản
                </h3>
                <p class="text-muted mb-0 mt-2">Tham gia cộng đồng yêu phim</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/auth/register" id="registerForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">
                                <i class="bi bi-person"></i> Tên đăng nhập *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Nhập tên đăng nhập"
                                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                   required
                                   minlength="3">
                            <div class="form-text">Ít nhất 3 ký tự</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email *
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Nhập địa chỉ email"
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                   required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="full_name" class="form-label">
                            <i class="bi bi-card-text"></i> Họ và tên *
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="full_name" 
                               name="full_name" 
                               placeholder="Nhập họ và tên đầy đủ"
                               value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                               required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> Mật khẩu *
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Nhập mật khẩu"
                                       required
                                       minlength="6"
                                       onkeyup="checkPasswordStrength()">
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePassword('password')">
                                    <i class="bi bi-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <div class="form-text">Ít nhất 6 ký tự</div>
                            <div id="password-strength" class="mt-1"></div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">
                                <i class="bi bi-lock-fill"></i> Xác nhận mật khẩu *
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       placeholder="Nhập lại mật khẩu"
                                       required
                                       onkeyup="checkPasswordMatch()">
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePassword('confirm_password')">
                                    <i class="bi bi-eye" id="confirm_password-icon"></i>
                                </button>
                            </div>
                            <div id="password-match" class="form-text mt-1"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Tôi đồng ý với 
                            <a href="<?php echo BASE_URL; ?>/terms" class="text-decoration-none">
                                Điều khoản sử dụng
                            </a> và 
                            <a href="<?php echo BASE_URL; ?>/privacy" class="text-decoration-none">
                                Chính sách bảo mật
                            </a>
                        </label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="bi bi-person-plus"></i> Đăng Ký
                        </button>
                    </div>
                </form>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <p class="mb-2">Đã có tài khoản?</p>
                    <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập Ngay
                    </a>
                </div>
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

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthDiv = document.getElementById('password-strength');
    
    if (password.length === 0) {
        strengthDiv.innerHTML = '';
        return;
    }
    
    let strength = 0;
    let strengthText = '';
    let strengthClass = '';
    
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    switch(strength) {
        case 0:
        case 1:
            strengthText = 'Rất yếu';
            strengthClass = 'text-danger';
            break;
        case 2:
            strengthText = 'Yếu';
            strengthClass = 'text-warning';
            break;
        case 3:
            strengthText = 'Trung bình';
            strengthClass = 'text-info';
            break;
        case 4:
            strengthText = 'Mạnh';
            strengthClass = 'text-success';
            break;
        case 5:
            strengthText = 'Rất mạnh';
            strengthClass = 'text-success fw-bold';
            break;
    }
    
    strengthDiv.innerHTML = `<small class="${strengthClass}">Độ mạnh: ${strengthText}</small>`;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const matchDiv = document.getElementById('password-match');
    
    if (confirmPassword.length === 0) {
        matchDiv.innerHTML = '';
        return;
    }
    
    if (password === confirmPassword) {
        matchDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> Mật khẩu khớp</small>';
    } else {
        matchDiv.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle"></i> Mật khẩu không khớp</small>';
    }
}

// Form validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Mật khẩu phải có ít nhất 6 ký tự!');
        return false;
    }
});
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
