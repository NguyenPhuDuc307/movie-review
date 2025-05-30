<?php
// Tạo ảnh poster mẫu cho các bộ phim
function createMoviePoster($title, $year, $genre, $filename) {
    // Kích thước poster chuẩn (300x450)
    $width = 300;
    $height = 450;
    
    // Tạo canvas
    $image = imagecreate($width, $height);
    
    // Màu nền gradient
    $bg1 = imagecolorallocate($image, 30, 30, 40);  // Màu tối
    $bg2 = imagecolorallocate($image, 60, 60, 80);  // Màu sáng hơn
    $text_color = imagecolorallocate($image, 255, 255, 255); // Trắng
    $accent_color = imagecolorallocate($image, 255, 193, 7); // Vàng
    
    // Tô nền gradient
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)(30 + (60 - 30) * $ratio);
        $g = (int)(30 + (60 - 30) * $ratio);
        $b = (int)(40 + (80 - 40) * $ratio);
        $line_color = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width, $y, $line_color);
    }
    
    // Vẽ khung viền
    imagerectangle($image, 0, 0, $width-1, $height-1, $accent_color);
    imagerectangle($image, 2, 2, $width-3, $height-3, $accent_color);
    
    // Font mặc định của PHP (built-in)
    $title_font = 5; // Font lớn
    $info_font = 3;  // Font nhỏ
    
    // Viết tiêu đề phim (chia thành nhiều dòng nếu quá dài)
    $title_words = explode(' ', $title);
    $title_lines = [];
    $current_line = '';
    
    foreach ($title_words as $word) {
        $test_line = $current_line . ($current_line ? ' ' : '') . $word;
        if (strlen($test_line) > 20) { // Giới hạn 20 ký tự mỗi dòng
            if ($current_line) {
                $title_lines[] = $current_line;
                $current_line = $word;
            } else {
                $title_lines[] = $word;
            }
        } else {
            $current_line = $test_line;
        }
    }
    if ($current_line) {
        $title_lines[] = $current_line;
    }
    
    // Vẽ tiêu đề ở giữa poster
    $start_y = 180; // Vị trí bắt đầu
    foreach ($title_lines as $i => $line) {
        $text_width = strlen($line) * imagefontwidth($title_font);
        $x = ($width - $text_width) / 2;
        $y = $start_y + ($i * 25);
        imagestring($image, $title_font, $x, $y, $line, $text_color);
    }
    
    // Viết năm
    $year_text = "(" . $year . ")";
    $year_width = strlen($year_text) * imagefontwidth($info_font);
    $year_x = ($width - $year_width) / 2;
    $year_y = $start_y + (count($title_lines) * 25) + 20;
    imagestring($image, $info_font, $year_x, $year_y, $year_text, $accent_color);
    
    // Viết thể loại
    $genre_width = strlen($genre) * imagefontwidth($info_font);
    $genre_x = ($width - $genre_width) / 2;
    $genre_y = $year_y + 30;
    imagestring($image, $info_font, $genre_x, $genre_y, $genre, $text_color);
    
    // Vẽ các ngôi sao trang trí
    for ($i = 0; $i < 5; $i++) {
        $star_x = 50 + ($i * 40);
        $star_y = 350;
        // Vẽ ngôi sao đơn giản bằng dấu *
        imagestring($image, 4, $star_x, $star_y, '*', $accent_color);
    }
    
    // Thêm text "MOVIE REVIEW" ở dưới
    $footer_text = "MOVIE REVIEW";
    $footer_width = strlen($footer_text) * imagefontwidth($info_font);
    $footer_x = ($width - $footer_width) / 2;
    $footer_y = 400;
    imagestring($image, $info_font, $footer_x, $footer_y, $footer_text, $accent_color);
    
    // Lưu ảnh
    $poster_path = "/Applications/XAMPP/xamppfiles/htdocs/movie-review/uploads/posters/" . $filename;
    imagejpeg($image, $poster_path, 90);
    imagedestroy($image);
    
    return $poster_path;
}

// Tạo poster cho từng phim
$movies = [
    ['Avengers: Endgame', '2019', 'Action', 'avengers-endgame.jpg'],
    ['Parasite', '2019', 'Drama', 'parasite.jpg'],
    ['Spirited Away', '2001', 'Anime', 'spirited-away.jpg'],
    ['The Dark Knight', '2008', 'Action', 'the-dark-knight.jpg'],
    ['Your Name', '2016', 'Anime', 'your-name.jpg']
];

echo "Đang tạo poster cho các bộ phim...\n";

foreach ($movies as $movie) {
    $path = createMoviePoster($movie[0], $movie[1], $movie[2], $movie[3]);
    echo "✓ Đã tạo poster: " . $movie[3] . "\n";
}

echo "Hoàn thành! Tất cả poster đã được tạo.\n";
?>
