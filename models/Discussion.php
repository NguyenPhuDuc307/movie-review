<?php
class Discussion extends Model {
    protected $table = 'discussions';
    
    // Lấy tất cả discussions với thông tin user và movie
    public function getAllWithDetails() {
        $sql = "SELECT d.*, u.full_name, u.avatar, m.title as movie_title,
                       COUNT(c.id) as comment_count
                FROM discussions d 
                INNER JOIN users u ON d.user_id = u.id 
                LEFT JOIN movies m ON d.movie_id = m.id
                LEFT JOIN comments c ON d.id = c.discussion_id AND c.status = 'active'
                WHERE d.status = 'active'
                GROUP BY d.id
                ORDER BY d.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy discussion theo ID với thông tin chi tiết
    public function getByIdWithDetails($id) {
        $sql = "SELECT d.*, u.full_name, u.avatar, m.title as movie_title,
                       COUNT(c.id) as comment_count
                FROM discussions d 
                INNER JOIN users u ON d.user_id = u.id 
                LEFT JOIN movies m ON d.movie_id = m.id
                LEFT JOIN comments c ON d.id = c.discussion_id AND c.status = 'active'
                WHERE d.id = ? AND d.status = 'active'
                GROUP BY d.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Lấy discussions theo movie
    public function getByMovie($movieId) {
        $sql = "SELECT d.*, u.full_name, u.avatar,
                       COUNT(c.id) as comment_count
                FROM discussions d 
                INNER JOIN users u ON d.user_id = u.id 
                LEFT JOIN comments c ON d.id = c.discussion_id AND c.status = 'active'
                WHERE d.movie_id = ? AND d.status = 'active'
                GROUP BY d.id
                ORDER BY d.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId]);
        return $stmt->fetchAll();
    }
    
    // Tạo discussion mới
    public function createDiscussion($data) {
        $sql = "INSERT INTO discussions (title, content, movie_id, user_id) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['movie_id'],
            $data['user_id']
        ]);
    }
    
    // Tăng view count
    public function incrementViews($id) {
        $sql = "UPDATE discussions SET views = views + 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Tìm kiếm discussions
    public function search($keyword) {
        $sql = "SELECT d.*, u.full_name, u.avatar, m.title as movie_title,
                       COUNT(c.id) as comment_count
                FROM discussions d 
                INNER JOIN users u ON d.user_id = u.id 
                LEFT JOIN movies m ON d.movie_id = m.id
                LEFT JOIN comments c ON d.id = c.discussion_id AND c.status = 'active'
                WHERE d.status = 'active' AND (
                    d.title LIKE ? OR 
                    d.content LIKE ? OR 
                    m.title LIKE ?
                )
                GROUP BY d.id
                ORDER BY d.created_at DESC";
        $searchTerm = "%{$keyword}%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    // Lấy discussions mới nhất
    public function getLatest($limit = 5) {
        $sql = "SELECT d.*, u.full_name, u.avatar, m.title as movie_title,
                       COUNT(c.id) as comment_count
                FROM discussions d 
                INNER JOIN users u ON d.user_id = u.id 
                LEFT JOIN movies m ON d.movie_id = m.id
                LEFT JOIN comments c ON d.id = c.discussion_id AND c.status = 'active'
                WHERE d.status = 'active'
                GROUP BY d.id
                ORDER BY d.created_at DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    // Lấy discussions hot (nhiều comment)
    public function getHot($limit = 5) {
        $sql = "SELECT d.*, u.full_name, u.avatar, m.title as movie_title,
                       COUNT(c.id) as comment_count
                FROM discussions d 
                INNER JOIN users u ON d.user_id = u.id 
                LEFT JOIN movies m ON d.movie_id = m.id
                LEFT JOIN comments c ON d.id = c.discussion_id AND c.status = 'active'
                WHERE d.status = 'active'
                GROUP BY d.id
                HAVING comment_count > 0
                ORDER BY comment_count DESC, d.created_at DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    // Lấy comments của discussion
    public function getComments($discussionId) {
        $sql = "SELECT c.*, u.full_name, u.avatar 
                FROM comments c 
                INNER JOIN users u ON c.user_id = u.id 
                WHERE c.discussion_id = ? AND c.status = 'active'
                ORDER BY c.created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$discussionId]);
        return $stmt->fetchAll();
    }
    
    // Thêm comment vào discussion
    public function addComment($data) {
        $sql = "INSERT INTO comments (content, user_id, discussion_id) 
                VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['content'],
            $data['user_id'],
            $data['discussion_id']
        ]);
    }
    
    // Xóa comment (chỉ người viết comment hoặc admin mới được xóa)
    public function deleteComment($commentId, $userId) {
        // Kiểm tra xem comment có thuộc về user này không
        $sql = "SELECT user_id FROM comments WHERE id = ? AND status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$commentId]);
        $comment = $stmt->fetch();
        
        if (!$comment || $comment['user_id'] != $userId) {
            return false; // Không có quyền xóa
        }
        
        // Xóa comment (soft delete)
        $sql = "UPDATE comments SET status = 'deleted' WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$commentId]);
    }
    
    // Lấy thông tin comment theo ID
    public function getCommentById($commentId) {
        $sql = "SELECT c.*, u.full_name, u.avatar 
                FROM comments c 
                INNER JOIN users u ON c.user_id = u.id 
                WHERE c.id = ? AND c.status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$commentId]);
        return $stmt->fetch();
    }
}
?>
