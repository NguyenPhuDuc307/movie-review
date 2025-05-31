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
    
    // Phương thức admin
    
    /**
     * Lấy tổng số người dùng (admin)
     */
    public function getTotalCount($search = '') {
        $sql = "SELECT COUNT(*) FROM users WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (username LIKE ? OR email LIKE ? OR full_name LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    /**
     * Lấy users cho admin với phân trang
     */
    public function getForAdmin($search = '', $limit = 10, $offset = 0) {
        $sql = "SELECT u.*, 
                       COUNT(r.id) as review_count,
                       COUNT(d.id) as discussion_count
                FROM users u 
                LEFT JOIN reviews r ON u.id = r.user_id
                LEFT JOIN discussions d ON u.id = d.user_id
                WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (u.username LIKE ? OR u.email LIKE ? OR u.full_name LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        $sql .= " GROUP BY u.id ORDER BY u.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy users mới nhất (admin)
     */
    public function getRecent($limit = 5) {
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Xóa user (admin)
     */
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
