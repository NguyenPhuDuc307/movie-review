<?php
class Controller {
    
    // Load view
    protected function view($view, $data = []) {
        // Truyền dữ liệu vào view
        extract($data);
        
        // Include view file
        $viewFile = BASE_PATH . '/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die('View không tồn tại: ' . $view);
        }
    }
    
    // Load model
    protected function model($model) {
        $modelFile = BASE_PATH . '/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            die('Model không tồn tại: ' . $model);
        }
    }
    
    // Redirect
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit();
    }
    
    // Set flash message
    protected function setFlash($type, $message) {
        $_SESSION['flash'][$type] = $message;
    }
    
    // Get flash message
    protected function getFlash($type) {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }
    
    // Check if user is logged in
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Require login
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Bạn cần đăng nhập để truy cập trang này.');
            $this->redirect('login');
        }
    }
}
?>
