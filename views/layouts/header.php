<?php
// Require Movie model for genre dropdown
require_once 'models/Movie.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>MovieReview</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bg-primary: #0d1117;
            --bg-secondary: #161b22;
            --bg-tertiary: #21262d;
            --text-primary: #f0f6fc;
            --text-secondary: #8b949e;
            --accent-color: #f85149;
            --border-color: #30363d;
            --hover-bg: #30363d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        .navbar {
            background-color: var(--bg-secondary) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            color: var(--accent-color) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            color: var(--text-primary) !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
            background-color: var(--hover-bg);
            border-radius: 6px;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--accent-color) !important;
            background-color: var(--hover-bg);
            border-radius: 6px;
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #da4e47;
            border-color: #da4e47;
        }
        
        .btn-outline-light {
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .btn-outline-light:hover {
            background-color: var(--hover-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary) !important;
        }

        .card-body {
            color: var(--text-primary) !important;
        }

        .card-title {
            color: var(--text-primary) !important;
        }

        .card-text {
            color: var(--text-secondary) !important;
        }
        
        .form-control {
            background-color: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .form-control:focus {
            background-color: var(--bg-tertiary);
            border-color: var(--accent-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(248, 81, 73, 0.25);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
        }
        
        .alert-success {
            background-color: #1e4a2e;
            color: #7dd87d;
            border-left: 4px solid #7dd87d;
        }
        
        .alert-danger {
            background-color: #4a1e1e;
            color: #ff7b7b;
            border-left: 4px solid #ff7b7b;
        }
        
        .movie-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .movie-poster {
            width: 100%;
            height: 300px;
            object-fit: cover;
            background-color: var(--bg-tertiary);
        }
        
        .badge {
            background-color: var(--accent-color) !important;
            color: white !important;
        }
        
        .text-muted {
            color: var(--text-secondary) !important;
        }
        
        .rating-stars {
            color: #ffc107;
        }
        
        footer {
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            margin-top: 4rem;
            padding: 2rem 0;
        }
        
        .search-form {
            max-width: 500px;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            padding: 4rem 0;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 3rem;
        }
        
        .section-title {
            color: var(--accent-color);
            font-weight: bold;
            margin-bottom: 2rem;
        }
        
        /* Fix text colors for better readability */
        .text-light {
            color: var(--text-primary) !important;
        }
        
        .text-white {
            color: #ffffff !important;
        }
        
        .text-dark {
            color: var(--text-primary) !important;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary) !important;
        }
        
        p {
            color: var(--text-primary) !important;
        }
        
        .lead {
            color: var(--text-primary) !important;
        }
        
        .display-4 {
            color: var(--text-primary) !important;
        }
        
        /* Dropdown menu styles */
        .dropdown-menu {
            background-color: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
        }
        
        .dropdown-item {
            color: var(--text-primary) !important;
        }
        
        .dropdown-item:hover {
            background-color: var(--hover-bg) !important;
            color: var(--accent-color) !important;
        }
        
        /* Small text fixes */
        small {
            color: var(--text-secondary) !important;
        }
        
        /* Discussion specific styles */
        .container {
            color: var(--text-primary) !important;
        }
        
        .text-muted {
            color: var(--text-secondary) !important;
        }
        
        .card-text.text-muted {
            color: var(--text-secondary) !important;
        }
        
        .small.text-muted {
            color: var(--text-secondary) !important;
        }
        
        /* Form controls */
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        
        .form-label {
            color: var(--text-primary) !important;
        }
        
        .form-text {
            color: var(--text-secondary) !important;
        }
        
        /* Alert improvements */
        .alert-info {
            background-color: #1e3a5f;
            color: #58a6ff;
            border-left: 4px solid #58a6ff;
        }
        
        /* Link colors - chỉ áp dụng cho specific links */
        .discussion-title a {
            color: #58a6ff !important;
        }
        
        .discussion-title a:hover {
            color: var(--accent-color) !important;
        }
        
        .card-title a {
            color: var(--text-primary) !important;
            text-decoration: none;
        }
        
        .card-title a:hover {
            color: var(--accent-color) !important;
        }
        
        /* Discussion System CSS Fixes */
        .container * {
            color: #f0f6fc !important;
        }

        .text-muted, .small.text-muted {
            color: #8b949e !important;
        }

        h2, h3, h4, h5, h6 {
            color: #f0f6fc !important;
        }

        .form-label {
            color: #f0f6fc !important;
        }

        .form-control {
            background-color: #21262d !important;
            border: 1px solid #30363d !important;
            color: #f0f6fc !important;
        }

        .form-control::placeholder {
            color: #8b949e !important;
        }

        .btn {
            color: white !important;
        }

        .alert-info {
            background-color: #1e3a5f !important;
            color: #58a6ff !important;
            border-left: 4px solid #58a6ff !important;
        }

        .alert-warning {
            background-color: #5d4e00 !important;
            color: #ffdf5d !important;
            border-left: 4px solid #ffdf5d !important;
        }

        .card {
            background-color: #161b22 !important;
            border: 1px solid #30363d !important;
        }

        .card-header {
            background-color: #161b22 !important;
            border-bottom: 1px solid #30363d !important;
            color: #f0f6fc !important;
        }

        .card-body {
            background-color: #161b22 !important;
            color: #f0f6fc !important;
        }

        .comment {
            background-color: #21262d !important;
            border: 1px solid #30363d !important;
        }

        .comment:hover {
            background-color: #30363d !important;
        }

        .discussion-content {
            color: #f0f6fc !important;
        }

        .comment-content {
            color: #f0f6fc !important;
        }

        /* Sửa màu nút và icon */
        .btn-outline-danger {
            color: #f85149 !important;
            border-color: #f85149 !important;
            background-color: transparent !important;
        }

        .btn-outline-danger:hover {
            color: #ffffff !important;
            background-color: #f85149 !important;
            border-color: #f85149 !important;
        }

        .btn-outline-secondary {
            color: #8b949e !important;
            border-color: #30363d !important;
            background-color: transparent !important;
        }

        .btn-outline-secondary:hover {
            color: #ffffff !important;
            background-color: #30363d !important;
            border-color: #30363d !important;
        }

        .btn-primary {
            background-color: #238636 !important;
            border-color: #238636 !important;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background-color: #2ea043 !important;
            border-color: #2ea043 !important;
            color: #ffffff !important;
        }

        /* Sửa màu cho các elements khác */
        strong {
            color: #f0f6fc !important;
        }

        .fas, .fa {
            color: inherit !important;
        }

        /* CSS cho rating stars - màu vàng (chỉ cho display, không ảnh hưởng input) */
        .star-rating .star {
            color: #ffd700 !important; /* Màu vàng cho ngôi sao */
            font-size: 1.2em;
        }

        .star-rating .star.filled {
            color: #ffd700 !important; /* Màu vàng cho ngôi sao đã chọn */
        }

        .star-rating .star.empty {
            color: #30363d !important; /* Màu xám cho ngôi sao trống */
        }

        /* CSS cho display stars (chỉ hiển thị) */
        .rating-display .star,
        .rating-stars .star {
            color: #ffd700 !important; /* Màu vàng */
        }

        /* Specific for Bootstrap icons - chỉ cho display */
        .bi-star,
        .bi-star-fill,
        .bi-star-half {
            color: #ffd700 !important;
        }

        /* CSS cho interactive rating input - ưu tiên cao nhất */
        .rating-input {
            display: flex !important;
            flex-direction: row-reverse !important;
            justify-content: flex-end !important;
        }

        .rating-input input[type="radio"] {
            display: none !important;
        }

        .rating-input .star-label {
            font-size: 2rem !important;
            color: #ddd !important;
            cursor: pointer !important;
            transition: color 0.2s !important;
            margin-left: 5px !important;
            order: 1 !important;
            pointer-events: auto !important;
        }

        /* Khi radio được chọn, tô màu vàng cho nó và tất cả các sao trước đó */
        .rating-input input[type="radio"]:checked ~ input[type="radio"] + .star-label,
        .rating-input input[type="radio"]:checked + .star-label {
            color: #ffc107 !important;
        }

        /* Hiệu ứng hover */
        .rating-input .star-label:hover,
        .rating-input .star-label:hover ~ .star-label {
            color: #ffc107 !important;
        }

        /* Reset màu khi không hover */
        .rating-input:not(:hover) .star-label {
            color: #ddd !important;
        }

        /* Tô màu các sao đã chọn khi không hover */
        .rating-input:not(:hover) input[type="radio"]:checked ~ input[type="radio"] + .star-label,
        .rating-input:not(:hover) input[type="radio"]:checked + .star-label {
            color: #ffc107 !important;
        }
        
        /* Search and filter form */
        .search-form .form-select {
            background-color: #21262d !important;
            border: 1px solid #30363d !important;
            color: #f0f6fc !important;
        }

        .search-form .form-select option {
            background-color: #21262d !important;
            color: #f0f6fc !important;
        }

        /* Discussion list items */
        .discussion-item {
            background-color: #21262d !important;
            border: 1px solid #30363d !important;
        }

        .discussion-item:hover {
            background-color: #30363d !important;
        }

        .discussion-title a {
            color: #58a6ff !important;
        }

        /* Tab Navigation Fixes */
        .nav-tabs {
            border-bottom: 1px solid #30363d !important;
        }

        .nav-tabs .nav-link {
            background-color: #21262d !important;
            border: 1px solid #30363d !important;
            color: #8b949e !important;
            margin-bottom: -1px;
        }

        .nav-tabs .nav-link:hover {
            background-color: #30363d !important;
            color: #f0f6fc !important;
            border-color: #30363d !important;
        }

        .nav-tabs .nav-link.active {
            background-color: #f85149 !important;
            color: #ffffff !important;
            border-color: #f85149 !important;
            border-bottom-color: #f85149 !important;
        }

        .nav-tabs .nav-link.active:hover {
            background-color: #da3633 !important;
            color: #ffffff !important;
            border-color: #da3633 !important;
        }

        /* Tab Content */
        .tab-content {
            background-color: transparent !important;
        }

        .tab-pane {
            color: #f0f6fc !important;
        }

        /* Form và input styles cho dark theme */
        .form-control {
            background-color: var(--bg-tertiary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .form-control:focus {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--accent-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(248, 81, 73, 0.25) !important;
        }

        .form-control::placeholder {
            color: var(--text-secondary) !important;
        }

        .form-label {
            color: var(--text-primary) !important;
        }

        .form-text {
            color: var(--text-secondary) !important;
        }

        /* Movie info card styles */
        .movie-info {
            background-color: var(--bg-tertiary) !important;
            border: 1px solid var(--border-color) !important;
        }

        .movie-info h5,
        .movie-info p {
            color: var(--text-primary) !important;
        }

        .movie-info .text-muted,
        .movie-info small {
            color: var(--text-secondary) !important;
        }

        /* Fix hover effects - ngăn chặn hover màu đỏ không mong muốn */
        /* Reset tất cả hover effects cho text elements */
        p, h1, h2, h3, h4, h5, h6, span, div, small, .text-muted, 
        .card-text, .card-body, .container,
        strong, em, i, b {
            color: inherit !important;
        }

        p:hover, h1:hover, h2:hover, h3:hover, h4:hover, h5:hover, h6:hover, 
        span:hover, div:hover, small:hover, .text-muted:hover,
        .card-text:hover, .card-body:hover, .container:hover,
        strong:hover, em:hover, i:hover, b:hover {
            color: inherit !important;
        }

        /* Chỉ áp dụng hover effect cho các elements cần thiết */
        .nav-link, .navbar-brand, .dropdown-item, .btn {
            transition: all 0.3s ease !important;
        }

        /* Navbar link hover effects */
        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
            background-color: var(--hover-bg);
            border-radius: 6px;
        }

        /* Button hover effects */
        .btn:hover {
            transform: translateY(-1px) !important;
        }

        /* Card hover effects - chỉ cho movie cards */
        .movie-card:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo URLHelper::home(); ?>">
                <i class="bi bi-film"></i> MovieReview
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo URLHelper::isActive('') ? 'active' : ''; ?>" href="<?php echo URLHelper::home(); ?>">
                            <i class="bi bi-house"></i> Trang Chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo URLHelper::isActive('movie') ? 'active' : ''; ?>" href="<?php echo URLHelper::movies(); ?>">
                            <i class="bi bi-collection-play"></i> Phim
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tags"></i> Thể Loại
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?php echo URLHelper::movies(); ?>">
                                <i class="bi bi-collection"></i> Tất cả thể loại
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                            // Lấy danh sách thể loại
                            $movieModel = new Movie();
                            $genres = $movieModel->getAllGenres();
                            foreach ($genres as $genre):
                            ?>
                                <li><a class="dropdown-item" href="<?php echo URLHelper::movies(); ?>?genre=<?= $genre['id'] ?>">
                                    <?= htmlspecialchars($genre['name']) ?>
                                </a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo URLHelper::isActive('discussion') ? 'active' : ''; ?>" href="<?php echo URLHelper::discussions(); ?>">
                            <i class="bi bi-chat-dots"></i> Thảo Luận
                        </a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex search-form me-3" method="GET" action="<?php echo URLHelper::movies(); ?>">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm phim..." aria-label="Search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                <!-- User Menu -->
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['full_name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="<?php echo URLHelper::userProfile(); ?>">
                                    <i class="bi bi-person"></i> Hồ Sơ
                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo URLHelper::userReviews(); ?>">
                                    <i class="bi bi-star"></i> Reviews Của Tôi
                                </a></li>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo URLHelper::adminDashboard(); ?>">
                                        <i class="bi bi-gear"></i> Admin Panel
                                    </a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo URLHelper::logout(); ?>">
                                    <i class="bi bi-box-arrow-right"></i> Đăng Xuất
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLHelper::login(); ?>">
                                <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLHelper::register(); ?>">
                                <i class="bi bi-person-plus"></i> Đăng Ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="container mt-3">
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?php echo $type == 'error' ? 'danger' : $type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['flash'][$type]); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="container mt-4">
