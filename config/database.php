<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'movie_review';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            // Sử dụng socket path cho XAMPP trên macOS
            $dsn = "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=" . $this->db_name . ";charset=utf8mb4";
            
            $this->conn = new PDO(
                $dsn,
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                )
            );
        } catch(PDOException $exception) {
            echo "Lỗi kết nối database: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}

// Tạo instance global
$database = new Database();
$pdo = $database->getConnection();
?>
