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
     * Tạo slug từ tên
     */
    private function createSlug($name) {
        // Chuyển thành chữ thường
        $slug = strtolower($name);
        
        // Thay thế ký tự tiếng Việt
        $vietnamese = array(
            'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ',
            'è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ',
            'ì','í','ị','ỉ','ĩ',
            'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ',
            'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
            'ỳ','ý','ỵ','ỷ','ỹ',
            'đ'
        );
        $latin = array(
            'a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a',
            'e','e','e','e','e','e','e','e','e','e','e',
            'i','i','i','i','i',
            'o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o',
            'u','u','u','u','u','u','u','u','u','u','u',
            'y','y','y','y','y',
            'd'
        );
        $slug = str_replace($vietnamese, $latin, $slug);
        
        // Loại bỏ ký tự đặc biệt, chỉ giữ lại a-z, 0-9, và dấu gạch ngang
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        
        // Thay khoảng trắng bằng dấu gạch ngang
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        
        // Loại bỏ dấu gạch ngang ở đầu và cuối
        $slug = trim($slug, '-');
        
        return $slug;
    }
    
    /**
     * Tạo thể loại mới
     */
    public function createGenre($data) {
        $slug = $this->createSlug($data['name']);
        $sql = "INSERT INTO genres (name, slug, description, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $slug,
            $data['description'] ?? null
        ]);
    }
    
    /**
     * Cập nhật thể loại
     */
    public function updateGenre($id, $data) {
        $slug = $this->createSlug($data['name']);
        $sql = "UPDATE genres SET name = ?, slug = ?, description = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $slug,
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
