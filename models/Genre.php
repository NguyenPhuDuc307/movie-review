<?php
class Genre extends Model {
    protected $table = 'genres';
    
    /**
     * Lấy tất cả thể loại với số lượng phim
     */
    public function getAllWithMovieCount() {
        $sql = "SELECT g.*, COUNT(m.id) as movie_count 
                FROM genres g 
                LEFT JOIN movies m ON g.id = m.genre_id AND m.status = 'active'
                GROUP BY g.id 
                ORDER BY g.name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Kiểm tra tên thể loại đã tồn tại
     */
    public function nameExists($name, $excludeId = null) {
        $sql = "SELECT id FROM genres WHERE name = ?";
        $params = [$name];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }
    
    /**
     * Tạo thể loại mới
     */
    public function createGenre($data) {
        $sql = "INSERT INTO genres (name, description, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null
        ]);
    }
    
    /**
     * Cập nhật thể loại
     */
    public function updateGenre($id, $data) {
        $sql = "UPDATE genres SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $id
        ]);
    }
    
    /**
     * Kiểm tra có thể xóa thể loại không (không có phim nào sử dụng)
     */
    public function canDelete($id) {
        $sql = "SELECT COUNT(*) as movie_count FROM movies WHERE genre_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result['movie_count'] == 0;
    }
    
    /**
     * Xóa thể loại
     */
    public function deleteGenre($id) {
        $sql = "DELETE FROM genres WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    /**
     * Lấy tổng số thể loại
     */
    public function getTotalCount($search = '') {
        $sql = "SELECT COUNT(*) FROM genres WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    /**
     * Lấy thể loại cho admin với phân trang
     */
    public function getForAdmin($search = '', $limit = 10, $offset = 0) {
        $sql = "SELECT g.*, COUNT(m.id) as movie_count 
                FROM genres g 
                LEFT JOIN movies m ON g.id = m.genre_id AND m.status = 'active'
                WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (g.name LIKE ? OR g.description LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm];
        }
        
        $sql .= " GROUP BY g.id ORDER BY g.name ASC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
