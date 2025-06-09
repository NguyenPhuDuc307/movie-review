<?php

class AdminController extends Controller {
    
    private $movieModel;
    private $userModel;
    private $reviewModel;
    private $genreModel;
    private $discussionModel;
    
    public function __construct() {
        $this->checkAdminAuth();
        $this->movieModel = new Movie();
        $this->userModel = new User();
        $this->reviewModel = new Review();
        $this->genreModel = new Genre();
        $this->discussionModel = new Discussion();
    }
    
    /**
     * Kiểm tra quyền admin
     */
    private function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            URLHelper::redirect(URLHelper::login());
        }
    }
    
    /**
     * Trang chính admin
     */
    public function index() {
        $stats = [
            'total_movies' => $this->movieModel->getTotalCount(),
            'total_users' => $this->userModel->getTotalCount(),
            'total_reviews' => $this->reviewModel->getTotalCount(),
            'total_discussions' => $this->discussionModel->getTotalCount(),
            'recent_movies' => $this->movieModel->getRecent(5),
            'recent_users' => $this->userModel->getRecent(5),
            'recent_reviews' => $this->reviewModel->getRecent(5),
            'recent_discussions' => $this->discussionModel->getLatest(5)
        ];
        
        $this->view('admin/dashboard', $stats);
    }
    
    /**
     * Quản lý phim
     */
    public function movies() {
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $movies = $this->movieModel->getForAdmin($search, $limit, $offset);
        $totalMovies = $this->movieModel->getTotalCount($search);
        $totalPages = ceil($totalMovies / $limit);
        
        $this->view('admin/movies/index', [
            'movies' => $movies,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }
    
    /**
     * Thêm phim mới
     */
    public function createMovie() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'release_year' => $_POST['release_year'] ?? '',
                'director' => $_POST['director'] ?? '',
                'cast' => $_POST['cast'] ?? '',
                'duration' => $_POST['duration'] ?? null,
                'genre_id' => $_POST['genre_id'] ?? null
            ];
            
            // Xử lý upload poster
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
                $uploadResult = $this->uploadPoster($_FILES['poster']);
                if ($uploadResult['success']) {
                    $data['poster'] = $uploadResult['filename'];
                } else {
                    $_SESSION['error'] = $uploadResult['message'];
                    $this->view('admin/movies/create', ['genres' => $this->movieModel->getGenres()]);
                    return;
                }
            }
            
            if ($this->movieModel->create($data)) {
                $_SESSION['success'] = 'Thêm phim thành công!';
                URLHelper::redirect(URLHelper::adminMovies());
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra!';
            }
        }
        
        $genres = $this->movieModel->getGenres();
        $this->view('admin/movies/create', ['genres' => $genres]);
    }
    
    /**
     * Sửa phim
     */
    public function editMovie($id) {
        $movie = $this->movieModel->findById($id);
        if (!$movie) {
            $_SESSION['error'] = 'Không tìm thấy phim!';
            URLHelper::redirect(URLHelper::adminMovies());
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'release_year' => $_POST['release_year'] ?? '',
                'director' => $_POST['director'] ?? '',
                'genre_id' => $_POST['genre_id'] ?? '',
                'duration' => $_POST['duration'] ?? null,
                'trailer_url' => $_POST['trailer_url'] ?? ''
            ];
            
            // Xử lý upload poster mới
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
                $uploadResult = $this->uploadPoster($_FILES['poster']);
                if ($uploadResult['success']) {
                    // Xóa poster cũ
                    if ($movie['poster'] && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])) {
                        unlink(BASE_PATH . '/uploads/posters/' . $movie['poster']);
                    }
                    $data['poster'] = $uploadResult['filename'];
                } else {
                    $_SESSION['error'] = $uploadResult['message'];
                    $genres = $this->movieModel->getGenres();
                    $this->view('admin/movies/edit', ['movie' => $movie, 'genres' => $genres]);
                    return;
                }
            }
            
            if ($this->movieModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật phim thành công!';
                URLHelper::redirect(URLHelper::adminMovies());
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra!';
            }
        }
        
        $genres = $this->movieModel->getGenres();
        $this->view('admin/movies/edit', ['movie' => $movie, 'genres' => $genres]);
    }
    
    /**
     * Xóa phim
     */
    public function deleteMovie($id) {
        $movie = $this->movieModel->findById($id);
        if (!$movie) {
            $_SESSION['error'] = 'Không tìm thấy phim!';
            URLHelper::redirect(URLHelper::adminMovies());
        }
        
        if ($this->movieModel->delete($id)) {
            // Xóa poster
            if ($movie['poster'] && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])) {
                unlink(BASE_PATH . '/uploads/posters/' . $movie['poster']);
            }
            $_SESSION['success'] = 'Xóa phim thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
        
        URLHelper::redirect(URLHelper::adminMovies());
    }
    
    /**
     * Quản lý người dùng
     */
    public function users() {
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $users = $this->userModel->getForAdmin($search, $limit, $offset);
        $totalUsers = $this->userModel->getTotalCount($search);
        $totalPages = ceil($totalUsers / $limit);
        
        $this->view('admin/users/index', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }
    
    /**
     * Xóa người dùng
     */
    public function deleteUser($id) {
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không thể xóa chính mình!';
            URLHelper::redirect(URLHelper::adminUsers());
        }
        
        if ($this->userModel->delete($id)) {
            $_SESSION['success'] = 'Xóa người dùng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
        
        URLHelper::redirect(URLHelper::adminUsers());
    }
    
    /**
     * Quản lý reviews
     */
    public function reviews() {
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $reviews = $this->reviewModel->getForAdmin($search, $limit, $offset);
        $totalReviews = $this->reviewModel->getTotalCount($search);
        $totalPages = ceil($totalReviews / $limit);
        
        $this->view('admin/reviews/index', [
            'reviews' => $reviews,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }
    
    /**
     * Duyệt review
     */
    public function approveReview($id) {
        if ($this->reviewModel->updateStatus($id, 'approved')) {
            $_SESSION['success'] = 'Duyệt review thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
        
        URLHelper::redirect(URLHelper::adminReviews());
    }
    
    /**
     * Từ chối review
     */
    public function rejectReview($id) {
        if ($this->reviewModel->updateStatus($id, 'rejected')) {
            $_SESSION['success'] = 'Từ chối review thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
        
        URLHelper::redirect(URLHelper::adminReviews());
    }
    
    /**
     * Xóa review
     */
    public function deleteReview($id) {
        if ($this->reviewModel->delete($id)) {
            $_SESSION['success'] = 'Xóa review thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
        
        URLHelper::redirect(URLHelper::adminReviews());
    }
    
    /**
     * Upload poster
     */
    private function uploadPoster($file) {
        $uploadDir = BASE_PATH . '/uploads/posters/';
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'message' => 'Chỉ chấp nhận file JPG, JPEG, PNG'];
        }
        
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'File quá lớn. Tối đa 5MB'];
        }
        
        $filename = time() . '_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadPath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'filename' => $filename];
        }
        
        return ['success' => false, 'message' => 'Không thể upload file'];
    }

    /**
     * Quản lý thể loại
     */
    public function genres() {
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $genres = $this->genreModel->getForAdmin($search, $limit, $offset);
        $totalGenres = $this->genreModel->getTotalCount($search);
        $totalPages = ceil($totalGenres / $limit);
        
        $this->view('admin/genres/index', [
            'genres' => $genres,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }

    /**
     * Thêm thể loại mới
     */
    public function createGenre() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'] ?? '')
            ];

            // Validation
            $errors = [];
            if (empty($data['name'])) {
                $errors[] = 'Tên thể loại không được để trống.';
            } elseif ($this->genreModel->nameExists($data['name'])) {
                $errors[] = 'Tên thể loại đã tồn tại.';
            }

            if (empty($errors)) {
                if ($this->genreModel->createGenre($data)) {
                    $_SESSION['success'] = 'Thêm thể loại thành công!';
                    URLHelper::redirect(URLHelper::adminGenres());
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra!';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/genres/create');
    }

    /**
     * Sửa thể loại
     */
    public function editGenre($id) {
        $genre = $this->genreModel->getById($id);
        if (!$genre) {
            $_SESSION['error'] = 'Không tìm thấy thể loại!';
            URLHelper::redirect(URLHelper::adminGenres());
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'] ?? '')
            ];

            // Validation
            $errors = [];
            if (empty($data['name'])) {
                $errors[] = 'Tên thể loại không được để trống.';
            } elseif ($this->genreModel->nameExists($data['name'], $id)) {
                $errors[] = 'Tên thể loại đã tồn tại.';
            }

            if (empty($errors)) {
                if ($this->genreModel->updateGenre($id, $data)) {
                    $_SESSION['success'] = 'Cập nhật thể loại thành công!';
                    URLHelper::redirect(URLHelper::adminGenres());
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra!';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/genres/edit', ['genre' => $genre]);
    }

    /**
     * Xóa thể loại
     */
    public function deleteGenre($id) {
        $genre = $this->genreModel->getById($id);
        if (!$genre) {
            $_SESSION['error'] = 'Không tìm thấy thể loại!';
            URLHelper::redirect(URLHelper::adminGenres());
        }

        // Kiểm tra xem có phim nào đang sử dụng thể loại này không
        if (!$this->genreModel->canDelete($id)) {
            $_SESSION['error'] = 'Không thể xóa thể loại này vì còn phim đang sử dụng!';
            URLHelper::redirect(URLHelper::adminGenres());
        }

        if ($this->genreModel->deleteGenre($id)) {
            $_SESSION['success'] = 'Xóa thể loại thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        URLHelper::redirect(URLHelper::adminGenres());
    }
    
    /**
     * Quản lý thảo luận
     */
    public function discussions() {
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $discussions = $this->discussionModel->getForAdmin($search, $limit, $offset);
        $total = $this->discussionModel->getTotalCount($search);
        $totalPages = ceil($total / $limit);
        
        $data = [
            'discussions' => $discussions,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total
        ];
        
        $this->view('admin/discussions/index', $data);
    }
    
    /**
     * Xóa thảo luận
     */
    public function deleteDiscussion($id) {
        if ($this->discussionModel->delete($id)) {
            $_SESSION['success'] = 'Xóa thảo luận thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }
        
        URLHelper::redirect(URLHelper::adminDiscussions());
    }
}
