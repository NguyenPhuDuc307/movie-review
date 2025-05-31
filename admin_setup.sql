-- Thêm cột role vào bảng users
ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user' AFTER email;

-- Tạo admin mặc định (password: admin123)
UPDATE users SET role = 'admin' WHERE username = 'admin' OR email = 'admin@moviereview.com';

-- Nếu chưa có user admin, tạo mới (password: admin123)
INSERT IGNORE INTO users (username, email, password, full_name, role, created_at) 
VALUES ('admin', 'admin@moviereview.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', NOW());
