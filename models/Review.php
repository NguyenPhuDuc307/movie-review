<?php
class Review extends Model {
    protected $table = 'reviews';
    
    // Kiểm tra user đã review phim này chưa
    public function hasUserReviewed($userId, $movieId) {
        $sql = "SELECT id FROM reviews WHERE user_id = ? AND movie_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetch() !== false;
    }
    
    // Tạo review mới
    public function createReview($data) {
        $sql = "INSERT INTO reviews (movie_id, user_id, rating, title, content, status) 
                VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['movie_id'],
            $data['user_id'], 
            $data['rating'],
            $data['title'],
            $data['content']
        ]);
    }
    
    // Lấy review của user cho phim cụ thể
    public function getUserReviewForMovie($userId, $movieId) {
        $sql = "SELECT r.*, m.title as movie_title 
                FROM reviews r 
                INNER JOIN movies m ON r.movie_id = m.id 
                WHERE r.user_id = ? AND r.movie_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetch();
    }
    
    // Cập nhật review
    public function updateReview($id, $data) {
        $sql = "UPDATE reviews 
                SET rating = ?, title = ?, content = ?, status = 'pending', updated_at = CURRENT_TIMESTAMP 
                WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['rating'],
            $data['title'], 
            $data['content'],
            $id,
            $data['user_id']
        ]);
    }
    
    // Phương thức admin
    
    /**
     * Lấy tổng số reviews (admin)
     */
    public function getTotalCount($search = '') {
        $sql = "SELECT COUNT(*) FROM reviews r 
                LEFT JOIN movies m ON r.movie_id = m.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (r.title LIKE ? OR r.content LIKE ? OR m.title LIKE ? OR u.full_name LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    /**
     * Lấy reviews cho admin với phân trang
     */
    public function getForAdmin($search = '', $limit = 10, $offset = 0) {
        $sql = "SELECT r.*, 
                       m.title as movie_title,
                       u.full_name as user_name,
                       u.username
                FROM reviews r 
                LEFT JOIN movies m ON r.movie_id = m.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (r.title LIKE ? OR r.content LIKE ? OR m.title LIKE ? OR u.full_name LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }
        
        $sql .= " ORDER BY r.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy reviews mới nhất (admin)
     */
    public function getRecent($limit = 5) {
        $sql = "SELECT r.*, 
                       m.title as movie_title,
                       u.full_name as user_name
                FROM reviews r 
                LEFT JOIN movies m ON r.movie_id = m.id
                LEFT JOIN users u ON r.user_id = u.id
                ORDER BY r.created_at DESC 
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Cập nhật trạng thái review (admin)
     */
    public function updateStatus($id, $status) {
        $sql = "UPDATE reviews SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
    
    /**
     * Xóa review (admin)
     */
    public function delete($id) {
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
