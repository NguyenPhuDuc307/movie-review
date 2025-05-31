<?php
class MovieController extends Controller {
    private $pdo;
    
    public function index() {
        $movieModel = $this->model('Movie');
        
        // Lấy tham số tìm kiếm từ URL
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $genreId = isset($_GET['genre']) && $_GET['genre'] !== '' ? (int)$_GET['genre'] : null;
        
        // Tìm kiếm hoặc lấy tất cả phim
        if (!empty($keyword) || !empty($genreId)) {
            $movies = $movieModel->advancedSearch($keyword, $genreId);
        } else {
            $movies = $movieModel->getAllWithGenre();
        }
        
        // Lấy danh sách thể loại cho dropdown
        $genres = $movieModel->getAllGenres();
        
        $data = [
            'movies' => $movies,
            'genres' => $genres,
            'currentSearch' => $keyword,
            'currentGenre' => $genreId,
            'pageTitle' => 'Danh Sách Phim'
        ];
        
        $this->view('movie/index', $data);
    }
    
    public function detail($id = null) {
        if (!$id || !is_numeric($id)) {
            $this->setFlash('error', 'ID phim không hợp lệ.');
            $this->redirect('movie');
            return;
        }
        
        $id = (int)$id;
        $movieModel = $this->model('Movie');
        $movie = $movieModel->getByIdWithDetails($id);
        
        if (!$movie) {
            $this->setFlash('error', 'Không tìm thấy phim.');
            $this->redirect('movie');
            return;
        }
        
        // Lấy reviews của phim
        $reviews = $movieModel->getMovieReviews($id);
        
        // Kiểm tra user đã review chưa (nếu đã đăng nhập)
        $userReview = null;
        if (isset($_SESSION['user_id'])) {
            $reviewModel = $this->model('Review');
            $userReview = $reviewModel->getUserReviewForMovie($_SESSION['user_id'], $id);
        }
        
        $data = [
            'movie' => $movie,
            'reviews' => $reviews,
            'userReview' => $userReview,
            'pageTitle' => $movie['title']
        ];
        
        $this->view('movie/detail', $data);
    }
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
}
?>
