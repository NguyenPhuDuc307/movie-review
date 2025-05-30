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
}
?>
