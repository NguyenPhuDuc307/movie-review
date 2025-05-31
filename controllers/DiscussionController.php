<?php
class DiscussionController extends Controller {
    
    public function index() {
        $discussionModel = $this->model('Discussion');
        $movieModel = $this->model('Movie');
        
        // Lấy tham số tìm kiếm
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $movieId = isset($_GET['movie']) && $_GET['movie'] !== '' ? (int)$_GET['movie'] : null;
        
        // Tìm kiếm hoặc lấy tất cả discussions
        if (!empty($keyword)) {
            $discussions = $discussionModel->search($keyword);
        } elseif (!empty($movieId)) {
            $discussions = $discussionModel->getByMovie($movieId);
        } else {
            $discussions = $discussionModel->getAllWithDetails();
        }
        
        // Lấy discussions hot
        $hotDiscussions = $discussionModel->getHot(5);
        
        // Lấy danh sách phim cho dropdown
        $movies = $movieModel->getAllWithGenre();
        
        $data = [
            'discussions' => $discussions,
            'hotDiscussions' => $hotDiscussions,
            'movies' => $movies,
            'currentSearch' => $keyword,
            'currentMovie' => $movieId,
            'pageTitle' => 'Thảo Luận Phim'
        ];
        
        $this->view('discussion/index', $data);
    }
    
    public function detail($id = null) {
        // Nếu không có ID hoặc ID không hợp lệ
        if (!$id || !is_numeric($id)) {
            $this->setFlash('error', 'ID thảo luận không hợp lệ.');
            $this->redirect('discussion');
            return;
        }
        
        $id = (int)$id;
        $discussionModel = $this->model('Discussion');
        $discussion = $discussionModel->getByIdWithDetails($id);
        
        if (!$discussion) {
            $this->setFlash('error', 'Không tìm thấy thảo luận.');
            $this->redirect('discussion');
            return;
        }
        
        // Tăng view count
        $discussionModel->incrementViews($id);
        
        // Lấy comments
        $comments = $discussionModel->getComments($id);
        
        // Xử lý form comment
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $this->handleCommentSubmission($discussionModel, $discussion);
            return;
        }
        
        $data = [
            'discussion' => $discussion,
            'comments' => $comments,
            'pageTitle' => $discussion['title']
        ];
        
        $this->view('discussion/detail', $data);
    }
    
    public function create() {
        // Require login
        $this->requireLogin();
        
        $movieModel = $this->model('Movie');
        
        // Xử lý form tạo discussion
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->handleCreateSubmission();
            return;
        }
        
        // Lấy danh sách phim
        $movies = $movieModel->getAllWithGenre();
        
        $data = [
            'movies' => $movies,
            'pageTitle' => 'Tạo Thảo Luận Mới'
        ];
        
        $this->view('discussion/create', $data);
    }
    
    private function handleCreateSubmission() {
        $discussionModel = $this->model('Discussion');
        
        $data = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'movie_id' => !empty($_POST['movie_id']) ? (int)$_POST['movie_id'] : null,
            'user_id' => $_SESSION['user_id']
        ];
        
        // Validation
        $errors = [];
        
        if (empty($data['title'])) {
            $errors[] = 'Tiêu đề không được để trống.';
        } elseif (strlen($data['title']) < 10) {
            $errors[] = 'Tiêu đề phải có ít nhất 10 ký tự.';
        }
        
        if (empty($data['content'])) {
            $errors[] = 'Nội dung không được để trống.';
        } elseif (strlen($data['content']) < 50) {
            $errors[] = 'Nội dung phải có ít nhất 50 ký tự.';
        }
        
        if (empty($errors)) {
            if ($discussionModel->createDiscussion($data)) {
                $this->setFlash('success', 'Thảo luận đã được tạo thành công!');
                $this->redirect('discussion');
            } else {
                $this->setFlash('error', 'Có lỗi xảy ra khi tạo thảo luận.');
            }
        } else {
            $this->setFlash('error', implode('<br>', $errors));
        }
        
        $this->redirect('discussion/create');
    }
    
    private function handleCommentSubmission($discussionModel, $discussion) {
        $data = [
            'content' => trim($_POST['comment']),
            'user_id' => $_SESSION['user_id'],
            'discussion_id' => $discussion['id']
        ];
        
        // Validation
        if (empty($data['content'])) {
            $this->setFlash('error', 'Nội dung bình luận không được để trống.');
        } elseif (strlen($data['content']) < 10) {
            $this->setFlash('error', 'Bình luận phải có ít nhất 10 ký tự.');
        } else {
            if ($discussionModel->addComment($data)) {
                $this->setFlash('success', 'Bình luận đã được thêm thành công!');
            } else {
                $this->setFlash('error', 'Có lỗi xảy ra khi thêm bình luận.');
            }
        }
        
        $this->redirect('discussion/detail/' . $discussion['id']);
    }
    
    public function deleteComment($commentId = null) {
        // Require login
        $this->requireLogin();
        
        if (!$commentId || !is_numeric($commentId)) {
            $this->setFlash('error', 'ID bình luận không hợp lệ.');
            $this->redirect('discussion');
            return;
        }
        
        $commentId = (int)$commentId;
        $discussionModel = $this->model('Discussion');
        
        // Lấy thông tin comment để biết discussion_id
        $comment = $discussionModel->getCommentById($commentId);
        
        if (!$comment) {
            $this->setFlash('error', 'Không tìm thấy bình luận.');
            $this->redirect('discussion');
            return;
        }
        
        // Xóa comment
        if ($discussionModel->deleteComment($commentId, $_SESSION['user_id'])) {
            $this->setFlash('success', 'Bình luận đã được xóa thành công!');
        } else {
            $this->setFlash('error', 'Bạn không có quyền xóa bình luận này.');
        }
        
        // Redirect về trang detail của discussion
        $this->redirect('discussion/detail/' . $comment['discussion_id']);
    }
}
?>
