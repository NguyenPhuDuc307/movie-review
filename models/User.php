<?php
class User extends Model {
    protected $table = 'users';
    
    // Đăng ký user mới
    public function register($data) {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Check email exists
        if ($this->emailExists($data['email'])) {
            return false;
        }
        
        // Check username exists
        if ($this->usernameExists($data['username'])) {
            return false;
        }
        
        return $this->create($data);
    }
    
    // Đăng nhập
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    // Kiểm tra email tồn tại
    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
    
    // Kiểm tra username tồn tại
    public function usernameExists($username) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() ? true : false;
    }
    
    // Lấy thông tin user theo email
    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    // Lấy thông tin user theo username
    public function getByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    // Cập nhật thông tin profile
    public function updateProfile($id, $data) {
        // Loại bỏ password khỏi data nếu có
        unset($data['password']);
        return $this->update($id, $data);
    }
    
    // Thay đổi mật khẩu
    public function changePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }
}
?>
