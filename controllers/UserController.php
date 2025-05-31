<?php
class UserController extends Controller {
    private $pdo;
    
    public function profile() {
        // Require login để truy cập profile
        $this->requireLogin();
        
        $userModel = $this->model('User');
        $movieModel = $this->model('Movie');
        
        // Lấy thông tin user hiện tại
        $user = $userModel->getById($_SESSION['user_id']);
        
        if (!$user) {
            $this->setFlash('error', 'Không tìm thấy thông tin người dùng.');
            $this->redirect('home');
        }
        
        // Lấy thống kê của user
        $userStats = $this->getUserStats($_SESSION['user_id']);
        
        // Lấy reviews gần đây của user
        $recentReviews = $this->getUserRecentReviews($_SESSION['user_id'], 5);
        
        // Lấy discussions gần đây của user
        $recentDiscussions = $this->getUserRecentDiscussions($_SESSION['user_id'], 5);
        
        // Xử lý form cập nhật profile
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->updateProfile($userModel, $user);
            return;
        }
        
        $data = [
            'user' => $user,
            'userStats' => $userStats,
            'recentReviews' => $recentReviews,
            'recentDiscussions' => $recentDiscussions,
            'pageTitle' => 'Hồ Sơ Cá Nhân'
        ];
        
        $this->view('user/profile', $data);
    }
    
    private function updateProfile($userModel, $currentUser) {
        $data = [
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email'])
        ];
        
        // Validation
        $errors = [];
        
        if (empty($data['full_name'])) {
            $errors[] = 'Họ và tên không được để trống.';
        }
        
        if (empty($data['email'])) {
            $errors[] = 'Email không được để trống.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }
        
        // Check email exists (trừ email hiện tại)
        if ($data['email'] !== $currentUser['email'] && $userModel->emailExists($data['email'])) {
            $errors[] = 'Email đã được sử dụng bởi tài khoản khác.';
        }
        
        // Xử lý upload avatar
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarResult = $this->handleAvatarUpload($_FILES['avatar']);
            if ($avatarResult['success']) {
                $data['avatar'] = $avatarResult['filename'];
            } else {
                $errors[] = $avatarResult['error'];
            }
        }
        
        // Xử lý thay đổi mật khẩu
        if (!empty($_POST['new_password'])) {
            if (empty($_POST['current_password'])) {
                $errors[] = 'Vui lòng nhập mật khẩu hiện tại.';
            } elseif (!password_verify($_POST['current_password'], $currentUser['password'])) {
                $errors[] = 'Mật khẩu hiện tại không đúng.';
            } elseif (strlen($_POST['new_password']) < 6) {
                $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
            } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                $errors[] = 'Xác nhận mật khẩu mới không khớp.';
            } else {
                // Cập nhật mật khẩu
                $userModel->changePassword($_SESSION['user_id'], $_POST['new_password']);
                $this->setFlash('success', 'Mật khẩu đã được thay đổi thành công.');
            }
        }
        
        if (empty($errors)) {
            if ($userModel->updateProfile($_SESSION['user_id'], $data)) {
                // Cập nhật session
                $_SESSION['full_name'] = $data['full_name'];
                $this->setFlash('success', 'Thông tin cá nhân đã được cập nhật thành công.');
            } else {
                $this->setFlash('error', 'Có lỗi xảy ra khi cập nhật thông tin.');
            }
        } else {
            $this->setFlash('error', implode('<br>', $errors));
        }
        
        $this->redirect('profile');
    }
    
    private function handleAvatarUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Chỉ chấp nhận file JPG, PNG, GIF.'];
        }
        
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'File không được vượt quá 2MB.'];
        }
        
        $uploadDir = BASE_PATH . '/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'error' => 'Không thể upload file.'];
        }
    }
    
    private function getUserStats($userId) {
        global $pdo;
        $stats = [];
        
        // Số lượng reviews
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM reviews WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['reviews'] = $stmt->fetch()['count'];
        
        // Số lượng discussions
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM discussions WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['discussions'] = $stmt->fetch()['count'];
        
        return $stats;
    }
    
    private function getUserRecentReviews($userId, $limit) {
        global $pdo;
        $sql = "SELECT r.*, m.title as movie_title, m.poster as movie_poster
                FROM reviews r
                INNER JOIN movies m ON r.movie_id = m.id
                WHERE r.user_id = ?
                ORDER BY r.created_at DESC
                LIMIT ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }
    
    private function getUserRecentDiscussions($userId, $limit) {
        global $pdo;
        $sql = "SELECT d.*, m.title as movie_title
                FROM discussions d
                LEFT JOIN movies m ON d.movie_id = m.id
                WHERE d.user_id = ?
                ORDER BY d.created_at DESC
                LIMIT ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }
    
    public function reviews() {
        // Require login để truy cập reviews
        $this->requireLogin();
        
        $userId = $_SESSION['user_id'];
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Lấy tất cả reviews của user với thông tin phim
        $sql = "SELECT r.*, m.title as movie_title, m.poster as movie_poster, m.id as movie_id
                FROM reviews r
                INNER JOIN movies m ON r.movie_id = m.id
                WHERE r.user_id = ?
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $limit, $offset]);
        $reviews = $stmt->fetchAll();
        
        // Đếm tổng số reviews
        $countSql = "SELECT COUNT(*) as total FROM reviews WHERE user_id = ?";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute([$userId]);
        $totalReviews = $countStmt->fetch()['total'];
        
        $totalPages = ceil($totalReviews / $limit);
        
        $data = [
            'reviews' => $reviews,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalReviews' => $totalReviews,
            'pageTitle' => 'Reviews Của Tôi'
        ];
        
        $this->view('user/reviews', $data);
    }

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
}
?>
