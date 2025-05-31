<?php
class Movie extends Model {
    protected $table = 'movies';
    
    // Lấy tất cả phim với thông tin thể loại
    public function getAllWithGenre() {
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                WHERE m.status = 'active'
                ORDER BY m.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy phim theo ID với thông tin chi tiết
    public function getByIdWithDetails($id) {
        $sql = "SELECT m.*, g.name as genre_name, 
                       u.full_name as created_by_name,
                       AVG(r.rating) as avg_rating,
                       COUNT(r.id) as review_count
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                LEFT JOIN users u ON m.created_by = u.id
                LEFT JOIN reviews r ON m.id = r.movie_id AND r.status = 'approved'
                WHERE m.id = ? AND m.status = 'active'
                GROUP BY m.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Tìm kiếm phim
    public function search($keyword) {
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                WHERE m.status = 'active' AND (
                    m.title LIKE ? OR 
                    m.description LIKE ? OR 
                    m.director LIKE ? OR 
                    m.cast LIKE ?
                )
                ORDER BY m.created_at DESC";
        $searchTerm = "%{$keyword}%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    // Lấy phim theo thể loại
    public function getByGenre($genreId) {
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                WHERE m.genre_id = ? AND m.status = 'active'
                ORDER BY m.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$genreId]);
        return $stmt->fetchAll();
    }
    
    // Tìm kiếm nâng cao với thể loại và từ khóa
    public function advancedSearch($keyword = '', $genreId = null) {
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                WHERE m.status = 'active'";
        
        $params = [];
        
        if (!empty($keyword)) {
            $sql .= " AND (m.title LIKE ? OR m.description LIKE ? OR m.director LIKE ? OR m.cast LIKE ?)";
            $searchTerm = "%{$keyword}%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        }
        
        if (!empty($genreId)) {
            $sql .= " AND m.genre_id = ?";
            $params[] = $genreId;
        }
        
        $sql .= " ORDER BY m.created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    // Lấy tất cả thể loại
    public function getAllGenres() {
        $sql = "SELECT * FROM genres ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy phim mới nhất
    public function getLatest($limit = 6) {
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                WHERE m.status = 'active'
                ORDER BY m.created_at DESC 
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    // Lấy phim được đánh giá cao nhất
    public function getTopRated($limit = 6) {
        $sql = "SELECT m.*, g.name as genre_name, 
                       AVG(r.rating) as avg_rating,
                       COUNT(r.id) as review_count
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                LEFT JOIN reviews r ON m.id = r.movie_id AND r.status = 'approved'
                WHERE m.status = 'active'
                GROUP BY m.id
                HAVING COUNT(r.id) > 0
                ORDER BY avg_rating DESC, review_count DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    // Lấy reviews của phim
    public function getMovieReviews($movieId) {
        $sql = "SELECT r.*, u.full_name, u.avatar 
                FROM reviews r 
                INNER JOIN users u ON r.user_id = u.id 
                WHERE r.movie_id = ? AND r.status = 'approved'
                ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId]);
        return $stmt->fetchAll();
    }
    
    // Phương thức admin
    
    /**
     * Lấy tổng số phim (admin)
     */
    public function getTotalCount($search = '') {
        $sql = "SELECT COUNT(*) FROM movies WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (title LIKE ? OR director LIKE ? OR cast LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    /**
     * Lấy phim cho admin với phân trang
     */
    public function getForAdmin($search = '', $limit = 10, $offset = 0) {
        $sql = "SELECT m.*, g.name as genre_name,
                       COUNT(r.id) as review_count,
                       AVG(r.rating) as avg_rating
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id
                LEFT JOIN reviews r ON m.id = r.movie_id
                WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (m.title LIKE ? OR m.director LIKE ? OR m.cast LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        $sql .= " GROUP BY m.id ORDER BY m.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy phim mới nhất (admin)
     */
    public function getRecent($limit = 5) {
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                ORDER BY m.created_at DESC 
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Tạo phim mới (admin)
     */
    public function create($data) {
        $sql = "INSERT INTO movies (title, description, release_year, director, cast, duration, genre_id, poster, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['release_year'],
            $data['director'],
            $data['cast'],
            $data['duration'],
            $data['genre_id'],
            $data['poster'] ?? null
        ]);
    }
    
    /**
     * Cập nhật phim (admin)
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        foreach ($data as $field => $value) {
            $fields[] = "$field = ?";
            $params[] = $value;
        }
        
        $sql = "UPDATE movies SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = ?";
        $params[] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Xóa phim (admin)
     */
    public function delete($id) {
        $sql = "DELETE FROM movies WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    /**
     * Tìm phim theo ID - alias cho getById
     */
    public function findById($id) {
        return $this->getById($id);
    }
    
    /**
     * Lấy danh sách thể loại
     */
    public function getGenres() {
        $sql = "SELECT * FROM genres ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
