<?php
session_start();

// Định nghĩa các hằng số
define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/movie-review');

// Include các file cần thiết
require_once 'config/database.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';

// Tạo hệ thống routing mới
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

// Loại bỏ base path từ URI
$uri = str_replace($base_path, '', $request_uri);
$uri = trim($uri, '/');

// Tách query string (nếu có)
$query_string = '';
if (strpos($uri, '?') !== false) {
    list($uri, $query_string) = explode('?', $uri, 2);
}

// Phân tích các tham số từ query string
$_GET = array();
if (!empty($query_string)) {
    parse_str($query_string, $_GET);
}

// Tách route thành các phần
$uri_parts = explode('/', $uri);

// Route mặc định
$controller = 'Home'; 
$action = 'index';
$params = array();

// Phân tích route
if (isset($uri_parts[0]) && !empty($uri_parts[0])) {
    $controller = ucfirst($uri_parts[0]);
    
    if (isset($uri_parts[1]) && !empty($uri_parts[1])) {
        $action = $uri_parts[1];
        
        // Các tham số còn lại là params
        if (count($uri_parts) > 2) {
            $params = array_slice($uri_parts, 2);
        }
    }
}

// Điều chỉnh routing đặc biệt
if ($controller == 'Movie' && $action == 'index' && isset($_GET['id']) && !empty($_GET['id'])) {
    $action = 'detail';
    $params = [(int)$_GET['id']];
}

// Xử lý trường hợp đặc biệt
if ($controller == 'Movies') {
    $controller = 'Movie';
}

// Debug routing (có thể xóa sau)
// echo "Controller: $controller, Action: $action, Params: "; print_r($params); echo "<br>";
// echo "GET params: "; print_r($_GET); echo "<br>";

// Đường dẫn đến file controller
$controller_file = 'controllers/' . $controller . 'Controller.php';

// Kiểm tra controller tồn tại
if (file_exists($controller_file)) {
    require_once $controller_file;
    
    $controller_class = $controller . 'Controller';
    $controller_instance = new $controller_class();
    
    // Kiểm tra method tồn tại
    if (method_exists($controller_instance, $action)) {
        // Gọi method với params
        call_user_func_array([$controller_instance, $action], $params);
    } else {
        // Method không tồn tại
        require_once 'views/errors/404.php';
    }
} else {
    // Controller không tồn tại
    require_once 'views/errors/404.php';
}
?>
