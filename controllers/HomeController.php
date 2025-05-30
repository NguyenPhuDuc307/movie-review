<?php
class HomeController extends Controller {
    
    public function index() {
        $movieModel = $this->model('Movie');
        
        // Lấy phim mới nhất
        $latestMovies = $movieModel->getLatest(6);
        
        // Lấy phim được đánh giá cao nhất
        $topRatedMovies = $movieModel->getTopRated(6);
        
        $data = [
            'latestMovies' => $latestMovies,
            'topRatedMovies' => $topRatedMovies,
            'pageTitle' => 'Trang Chủ'
        ];
        
        $this->view('home/index', $data);
    }
}
?>
