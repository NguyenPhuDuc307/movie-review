<?php
session_start();

// Định nghĩa các hằng số
define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/movie-review');

// Include autoloader
require_once 'config/database.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';

// Lấy route từ URL
$route = isset($_GET['route']) ? $_GET['route'] : 'home';
$route = rtrim($route, '/');
$route = filter_var($route, FILTER_SANITIZE_URL);

// Debug routing (có thể xóa sau khi fix)
// echo "DEBUG: Route = " . $route . "<br>";
// echo "DEBUG: GET parameters: "; print_r($_GET); echo "<br>";

// Router sử dụng switch case
switch($route) {
    case 'home':
    case '':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'movie':
    case 'movies':
        require_once 'controllers/MovieController.php';
        $controller = new MovieController();
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = (int)$_GET['id'];
            $controller->detail($id);
        } else {
            $controller->index();
        }
        break;
        
    case 'profile':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->profile();
        break;
        
    case 'review/write':
        require_once 'controllers/ReviewController.php';
        $controller = new ReviewController();
        $controller->write();
        break;
        
    default:
        // 404 Page
        require_once 'views/errors/404.php';
        break;
}
?>
