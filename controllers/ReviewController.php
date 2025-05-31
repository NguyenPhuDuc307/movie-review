<?php
class ReviewController extends Controller {
    private $pdo;
    
    public function write($movieId = null) {
        // Kiểm tra đăng nhập
        $this->requireLogin();
        
        // Lấy movie_id từ parameter hoặc GET
        if ($movieId) {
            $movieId = (int)$movieId;
        } else {
            $movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
        }
        
        if (!$movieId) {
            $this->setFlash('error', 'ID phim không hợp lệ.');
            $this->redirect('movie');
        }
        
        $movieModel = $this->model('Movie');
        $reviewModel = $this->model('Review');
        
        // Kiểm tra phim có tồn tại không
        $movie = $movieModel->getById($movieId);
        if (!$movie) {
            $this->setFlash('error', 'Không tìm thấy phim.');
            $this->redirect('movie');
        }
        
        // Kiểm tra user đã review phim này chưa
        $existingReview = $reviewModel->getUserReviewForMovie($_SESSION['user_id'], $movieId);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->handleReviewSubmission($reviewModel, $movie, $existingReview);
            return;
        }
        
        $data = [
            'movie' => $movie,
            'existingReview' => $existingReview,
            'pageTitle' => $existingReview ? 'Chỉnh Sửa Review' : 'Viết Review'
        ];
        
        $this->view('review/write', $data);
    }
    
    private function handleReviewSubmission($reviewModel, $movie, $existingReview) {
        $data = [
            'movie_id' => $movie['id'],
            'user_id' => $_SESSION['user_id'],
            'rating' => (int)$_POST['rating'],
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content'])
        ];
        
        // Validation
        $errors = [];
        
        if ($data['rating'] < 1 || $data['rating'] > 5) {
            $errors[] = 'Vui lòng chọn rating từ 1 đến 5 sao.';
        }
        
        if (empty($data['title'])) {
            $errors[] = 'Tiêu đề review không được để trống.';
        }
        
        if (empty($data['content'])) {
            $errors[] = 'Nội dung review không được để trống.';
        }
        
        if (strlen($data['content']) < 50) {
            $errors[] = 'Nội dung review phải có ít nhất 50 ký tự.';
        }
        
        if (empty($errors)) {
            if ($existingReview) {
                // Cập nhật review
                if ($reviewModel->updateReview($existingReview['id'], $data)) {
                    $this->setFlash('success', 'Review đã được cập nhật và đang chờ duyệt.');
                } else {
                    $this->setFlash('error', 'Có lỗi xảy ra khi cập nhật review.');
                }
            } else {
                // Tạo review mới
                if ($reviewModel->createReview($data)) {
                    $this->setFlash('success', 'Review đã được gửi và đang chờ duyệt.');
                } else {
                    $this->setFlash('error', 'Có lỗi xảy ra khi tạo review.');
                }
            }
            
            $this->redirect('movie/detail/' . $movie['id']);
        } else {
            $this->setFlash('error', implode('<br>', $errors));
            $this->redirect('review/write?movie_id=' . $movie['id']);
        }
    }
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
}
?>
