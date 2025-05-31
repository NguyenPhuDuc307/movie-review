<?php
/**
 * URL Helper - Các hàm hỗ trợ tạo URL
 */

class URLHelper {
    
    /**
     * Tạo URL cho trang chủ
     */
    public static function home() {
        return BASE_URL;
    }
    
    /**
     * Tạo URL cho danh sách phim
     */
    public static function movies($search = '', $genre = '') {
        $url = BASE_URL . '/movie';
        $params = [];
        
        if (!empty($search)) {
            $params['search'] = $search;
        }
        
        if (!empty($genre)) {
            $params['genre'] = $genre;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }
    
    /**
     * Tạo URL cho chi tiết phim
     */
    public static function movieDetail($movieId) {
        return BASE_URL . '/movie/detail/' . (int)$movieId;
    }
    
    /**
     * Tạo URL cho viết review phim
     */
    public static function writeReview($movieId) {
        return BASE_URL . '/review/write/' . (int)$movieId;
    }
    
    /**
     * Tạo URL cho danh sách thảo luận
     */
    public static function discussions($search = '', $movie_id = '') {
        $url = BASE_URL . '/discussion';
        $params = [];
        
        if (!empty($search)) {
            $params['search'] = $search;
        }
        
        if (!empty($movie_id)) {
            $params['movie_id'] = $movie_id;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }
    
    /**
     * Tạo URL cho chi tiết thảo luận
     */
    public static function discussionDetail($discussionId) {
        return BASE_URL . '/discussion/detail/' . (int)$discussionId;
    }
    
    /**
     * Tạo URL cho tạo thảo luận mới
     */
    public static function createDiscussion($movieId = null) {
        $url = BASE_URL . '/discussion/create';
        if ($movieId) {
            $url .= '?movie_id=' . (int)$movieId;
        }
        return $url;
    }
    
    /**
     * Tạo URL cho hồ sơ người dùng
     */
    public static function userProfile($userId = null) {
        if ($userId) {
            return BASE_URL . '/user/profile/' . (int)$userId;
        }
        return BASE_URL . '/user/profile';
    }
    
    /**
     * Tạo URL cho reviews của người dùng
     */
    public static function userReviews() {
        return BASE_URL . '/user/reviews';
    }
    
    /**
     * Tạo URL cho đăng nhập
     */
    public static function login() {
        return BASE_URL . '/auth/login';
    }
    
    /**
     * Tạo URL cho đăng ký
     */
    public static function register() {
        return BASE_URL . '/auth/register';
    }
    
    /**
     * Tạo URL cho đăng xuất
     */
    public static function logout() {
        return BASE_URL . '/auth/logout';
    }
    
    /**
     * Tạo URL cho admin dashboard
     */
    public static function adminDashboard() {
        return BASE_URL . '/admin';
    }
    
    /**
     * Tạo URL cho quản lý phim admin
     */
    public static function adminMovies($search = '', $page = 1) {
        $url = BASE_URL . '/admin/movies';
        $params = [];
        
        if (!empty($search)) {
            $params['search'] = $search;
        }
        
        if ($page > 1) {
            $params['page'] = $page;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }
    
    /**
     * Tạo URL cho thêm phim admin
     */
    public static function adminCreateMovie() {
        return BASE_URL . '/admin/movies/create';
    }
    
    /**
     * Tạo URL cho sửa phim admin
     */
    public static function adminEditMovie($movieId) {
        return BASE_URL . '/admin/movies/edit/' . (int)$movieId;
    }
    
    /**
     * Tạo URL cho cập nhật phim admin (POST)
     */
    public static function adminUpdateMovie($movieId) {
        return BASE_URL . '/admin/movies/edit/' . (int)$movieId;
    }
    
    /**
     * Tạo URL cho xóa phim admin
     */
    public static function adminDeleteMovie($movieId) {
        return BASE_URL . '/admin/movies/delete/' . (int)$movieId;
    }
    
    /**
     * Tạo URL cho quản lý users admin
     */
    public static function adminUsers($search = '', $page = 1) {
        $url = BASE_URL . '/admin/users';
        $params = [];
        
        if (!empty($search)) {
            $params['search'] = $search;
        }
        
        if ($page > 1) {
            $params['page'] = $page;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }
    
    /**
     * Tạo URL cho xóa user admin
     */
    public static function adminDeleteUser($userId) {
        return BASE_URL . '/admin/users/delete/' . (int)$userId;
    }
    
    /**
     * Tạo URL cho quản lý reviews admin
     */
    public static function adminReviews($search = '', $page = 1) {
        $url = BASE_URL . '/admin/reviews';
        $params = [];
        
        if (!empty($search)) {
            $params['search'] = $search;
        }
        
        if ($page > 1) {
            $params['page'] = $page;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }
    
    /**
     * Tạo URL cho xóa review admin
     */
    public static function adminDeleteReview($reviewId) {
        return BASE_URL . '/admin/reviews/delete/' . (int)$reviewId;
    }
    
    /**
     * Tạo URL cho poster phim
     */
    public static function poster($filename) {
        if (empty($filename)) {
            return BASE_URL . '/uploads/posters/default.jpg';
        }
        return BASE_URL . '/uploads/posters/' . htmlspecialchars($filename);
    }
    
    /**
     * Kiểm tra URL hiện tại
     */
    public static function isActive($path) {
        $current_path = $_SERVER['REQUEST_URI'];
        $base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $current_path = str_replace($base_path, '', $current_path);
        $current_path = trim($current_path, '/');
        
        // Loại bỏ query string
        if (strpos($current_path, '?') !== false) {
            $current_path = explode('?', $current_path)[0];
        }
        
        return $current_path === trim($path, '/');
    }
    
    /**
     * Redirect đến URL khác
     */
    public static function redirect($url) {
        header('Location: ' . $url);
        exit();
    }
    
    /**
     * Redirect về trang trước đó
     */
    public static function back() {
        $referer = $_SERVER['HTTP_REFERER'] ?? self::home();
        self::redirect($referer);
    }
    
    /**
     * Các trang tĩnh
     */
    public static function about() {
        return BASE_URL . '/about';
    }
    
    public static function help() {
        return BASE_URL . '/help';
    }
    
    public static function contact() {
        return BASE_URL . '/contact';
    }
    
    public static function privacy() {
        return BASE_URL . '/privacy';
    }
    
    public static function terms() {
        return BASE_URL . '/terms';
    }
}
