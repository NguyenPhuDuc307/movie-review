-- Tạo database movie_review
CREATE DATABASE IF NOT EXISTS movie_review CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE movie_review;

-- Bảng users (người dùng)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng genres (thể loại phim)
CREATE TABLE genres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng movies (phim)
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    director VARCHAR(100),
    cast TEXT,
    release_year YEAR,
    duration INT, -- phút
    poster VARCHAR(255),
    trailer_url VARCHAR(255),
    genre_id INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Bảng reviews (đánh giá phim)
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    movie_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('approved', 'pending', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_movie (user_id, movie_id)
);

-- Bảng discussions (thảo luận)
CREATE TABLE discussions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    movie_id INT,
    user_id INT NOT NULL,
    views INT DEFAULT 0,
    status ENUM('active', 'closed', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bảng comments (bình luận)
CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    review_id INT NULL,
    discussion_id INT NULL,
    parent_id INT NULL, -- cho reply comment
    status ENUM('active', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE,
    FOREIGN KEY (discussion_id) REFERENCES discussions(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE
);

-- Bảng likes (lượt thích)
CREATE TABLE likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    review_id INT NULL,
    comment_id INT NULL,
    discussion_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE,
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE,
    FOREIGN KEY (discussion_id) REFERENCES discussions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_review (user_id, review_id),
    UNIQUE KEY unique_user_comment (user_id, comment_id),
    UNIQUE KEY unique_user_discussion (user_id, discussion_id)
);

-- Insert dữ liệu mẫu

-- Thêm thể loại phim
INSERT INTO genres (name, slug, description) VALUES
('Hành Động', 'hanh-dong', 'Phim hành động, phiêu lưu'),
('Hài Kịch', 'hai-kich', 'Phim hài hước, giải trí'),
('Chính Kịch', 'chinh-kich', 'Phim chính kịch, tâm lý'),
('Kinh Dị', 'kinh-di', 'Phim kinh dị, ma quái'),
('Lãng Mạn', 'lang-man', 'Phim tình cảm, lãng mạn'),
('Khoa Học Viễn Tưởng', 'khoa-hoc-vien-tuong', 'Phim khoa học viễn tưởng'),
('Anime', 'anime', 'Phim hoạt hình Nhật Bản'),
('Tài Liệu', 'tai-lieu', 'Phim tài liệu');

-- Thêm users mẫu
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@moviereview.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Quản Trị Viên', 'admin'),
('user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn An', 'user'),
('user2', 'user2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị Bình', 'user'),
('cinephile', 'cinephile@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Minh Cường', 'user');

-- Thêm phim mẫu
INSERT INTO movies (title, slug, description, director, cast, release_year, duration, genre_id, created_by) VALUES
('Avengers: Endgame', 'avengers-endgame', 'Sau những sự kiện tàn khốc của Infinity War, vũ trụ đang trong tình trạng hỗn loạn. Các Avengers còn lại phải tập hợp lại một lần nữa để hoàn tác hành động của Thanos và khôi phục lại trật tự vũ trụ.', 'Anthony Russo, Joe Russo', 'Robert Downey Jr., Chris Evans, Mark Ruffalo, Chris Hemsworth', 2019, 181, 1, 1),
('Parasite', 'parasite', 'Bộ phim kể về gia đình Ki-taek nghèo khó sống trong một căn hầm bán ngầm tồi tàn. Khi con trai Ki-woo được giới thiệu làm gia sư cho con gái nhà Park giàu có, cả gia đình bắt đầu thâm nhập vào ngôi nhà sang trọng.', 'Bong Joon-ho', 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong, Choi Woo-shik', 2019, 132, 3, 1),
('Spirited Away', 'spirited-away', 'Chihiro 10 tuổi cùng bố mẹ chuyển đến thị trấn mới. Trên đường đi, họ lạc vào thế giới thần linh kỳ bí. Bố mẹ Chihiro bị biến thành lợn, cô bé phải làm việc trong nhà tắm của các vị thần để cứu họ.', 'Hayao Miyazaki', 'Rumi Hiiragi, Miyu Irino, Mari Natsuki', 2001, 125, 7, 1),
('The Dark Knight', 'the-dark-knight', 'Batman phải đối mặt với thử thách lớn nhất khi Joker xuất hiện và gây ra hỗn loạn ở Gotham City. Với sự giúp đỡ của Jim Gordon và Harvey Dent, Batman phải ngăn chặn Joker phá hủy thành phố.', 'Christopher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart', 2008, 152, 1, 1),
('Your Name', 'your-name', 'Mitsuha và Taki là hai học sinh trung học sống ở những nơi khác nhau. Một ngày nọ, họ phát hiện ra mình có thể hoán đổi cơ thể với nhau trong giấc mơ, dẫn đến những tình huống dở khóc dở cười.', 'Makoto Shinkai', 'Ryunosuke Kamiki, Mone Kamishiraishi', 2016, 106, 7, 1);

-- Thêm reviews mẫu
INSERT INTO reviews (movie_id, user_id, rating, title, content, status) VALUES
(1, 2, 5, 'Kiệt tác kết thúc hoàn hảo', 'Endgame là một bộ phim tuyệt vời, kết thúc hoàn hảo cho saga Infinity. Cảm xúc, hành động, kỹ xảo đều ở mức tuyệt vời. Đây thực sự là một trải nghiệm điện ảnh không thể bỏ lỡ.', 'approved'),
(2, 3, 5, 'Tác phẩm nghệ thuật đỉnh cao', 'Parasite không chỉ là một bộ phim giải trí mà còn là một tác phẩm nghệ thuật sâu sắc về bất bình đẳng xã hội. Bong Joon-ho đã tạo ra một kiệt tác thực sự.', 'approved'),
(3, 4, 5, 'Phim hoạt hình hay nhất mọi thời đại', 'Spirited Away của Miyazaki là một thế giới kỳ diệu đầy màu sắc và ý nghĩa. Câu chuyện về sự trưởng thành và lòng dũng cảm được kể một cách tuyệt vời.', 'approved'),
(1, 3, 4, 'Phim hay nhưng hơi dài', 'Mặc dù nội dung rất hay và cảm động, nhưng 3 tiếng đồng hồ có vẻ hơi dài đối với tôi. Tuy nhiên, đây vẫn là một bộ phim tuyệt vời.', 'approved'),
(4, 2, 5, 'Heath Ledger xuất sắc', 'The Dark Knight với màn thể hiện Joker của Heath Ledger quả thực là một tuyệt tác. Phim có cốt truyện chặt chẽ và những pha hành động đỉnh cao.', 'approved');

-- Thêm discussions mẫu
INSERT INTO discussions (title, content, movie_id, user_id) VALUES
('Cái kết của Endgame có thỏa mãn không?', 'Mọi người nghĩ sao về cái kết của Avengers Endgame? Có ai cảm thấy hơi buồn như mình không?', 1, 2),
('Ý nghĩa sâu xa trong Parasite', 'Parasite không chỉ là về sự khác biệt giàu nghèo. Các bạn có phát hiện những ẩn dụ nào khác trong phim không?', 2, 3),
('Studio Ghibli vs Disney - ai thắng?', 'So sánh giữa phim hoạt hình của Studio Ghibli và Disney, các bạn thích studio nào hơn và tại sao?', 3, 4),
('Phim siêu anh hùng có quá nhiều không?', 'Hiện tại có quá nhiều phim siêu anh hùng, các bạn có cảm thấy nhàm chán không? Hay vẫn thích xem tiếp?', NULL, 2);

-- Thêm comments mẫu
INSERT INTO comments (content, user_id, review_id) VALUES
('Tôi hoàn toàn đồng ý! Endgame thực sự là một kiệt tác', 3, 1),
('Mình cũng nghĩ vậy, mặc dù có một số lỗ hổng nhỏ trong cốt truyện', 4, 1),
('Parasite xứng đáng với Oscar', 2, 2);

INSERT INTO comments (content, user_id, discussion_id) VALUES
('Mình thấy cái kết rất cảm động, đặc biệt là phân đoạn cuối', 3, 1),
('Có đúng là buồn, nhưng đó là cái kết phù hợp nhất', 4, 1),
('Mình nghĩ còn nhiều ý nghĩa về môi trường và sự tham lam nữa', 2, 2);

-- Thêm likes mẫu
INSERT INTO likes (user_id, review_id) VALUES
(3, 1), (4, 1), (2, 2), (4, 2), (2, 3), (3, 3);

INSERT INTO likes (user_id, discussion_id) VALUES
(3, 1), (4, 1), (2, 2), (4, 3);
