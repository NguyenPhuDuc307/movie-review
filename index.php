<?php
session_start();

// Định nghĩa các hằng số
define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/movie-review');

// Include các file cần thiết
require_once 'config/database.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'core/URLHelper.php';

// Include các model
require_once 'models/Movie.php';
require_once 'models/User.php';
require_once 'models/Review.php';

// Include các controller
require_once 'controllers/HomeController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/ReviewController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/DiscussionController.php';

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
if (!empty($query_string)) {
    parse_str($query_string, $additional_params);
    $_GET = array_merge($_GET, $additional_params);
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

// Routing đặc biệt cho các patterns phổ biến
switch ($controller) {
    case 'Movie':
        // /movie/123 -> movie/detail/123
        if (is_numeric($action)) {
            $params = [$action];
            $action = 'detail';
        }
        // /movie/detail/123
        elseif ($action === 'detail' && isset($params[0])) {
            $params[0] = (int)$params[0];
        }
        break;
        
    case 'Discussion':
        // /discussion/123 -> discussion/detail/123
        if (is_numeric($action)) {
            $params = [$action];
            $action = 'detail';
        }
        // /discussion/detail/123
        elseif ($action === 'detail' && isset($params[0])) {
            $params[0] = (int)$params[0];
        }
        break;
        
    case 'Review':
        // /review/write/123
        if ($action === 'write' && isset($params[0])) {
            $params[0] = (int)$params[0];
        }
        break;
        
    case 'User':
        // Các action cho user
        break;
        
    case 'Auth':
        // Các action cho authentication
        break;
        
    case 'Admin':
        // /admin -> admin/index (dashboard)
        if ($action === 'index' || empty($action)) {
            $action = 'index';
        }
        // /admin/movies/create -> admin/createMovie
        // /admin/movies/edit/123 -> admin/editMovie/123
        // /admin/movies/delete/123 -> admin/deleteMovie/123
        if ($action === 'movies') {
            if (isset($params[0])) {
                if ($params[0] === 'create') {
                    $action = 'createMovie';
                    $params = [];
                } elseif ($params[0] === 'edit' && isset($params[1])) {
                    $action = 'editMovie';
                    $params = [(int)$params[1]];
                } elseif ($params[0] === 'delete' && isset($params[1])) {
                    $action = 'deleteMovie';
                    $params = [(int)$params[1]];
                } else {
                    $action = 'movies';
                    $params = [];
                }
            } else {
                $action = 'movies';
            }
        }
        // /admin/users/delete/123 -> admin/deleteUser/123
        elseif ($action === 'users') {
            if (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                $action = 'deleteUser';
                $params = [(int)$params[1]];
            } else {
                $action = 'users';
                $params = [];
            }
        }
        // /admin/reviews/delete/123 -> admin/deleteReview/123
        elseif ($action === 'reviews') {
            if (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                $action = 'deleteReview';
                $params = [(int)$params[1]];
            } else {
                $action = 'reviews';
                $params = [];
            }
        }
        break;
}

// Routing shortcuts cho các trang phổ biến
$shortcuts = [
    'login' => ['Auth', 'login'],
    'register' => ['Auth', 'register'],
    'logout' => ['Auth', 'logout'],
    'movies' => ['Movie', 'index'],
    'discussions' => ['Discussion', 'index'],
    'profile' => ['User', 'profile']
];

if (isset($shortcuts[$controller])) {
    list($controller, $action) = $shortcuts[$controller];
}

// Debug routing (có thể xóa sau)
// echo "Controller: $controller, Action: $action, Params: "; print_r($params); echo "<br>";
// echo "GET params: "; print_r($_GET); echo "<br>";
// echo "URI: $uri<br>";
// echo "URI Parts: "; print_r($uri_parts); echo "<br><br>";

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
