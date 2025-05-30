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
        
        .card:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
            transition: all 0.3s ease;
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
        
        .movie-card .card-title a {
            color: var(--text-primary) !important;
            text-decoration: none;
        }
        
        .movie-card .card-title a:hover {
            color: var(--accent-color) !important;
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="bi bi-film"></i> MovieReview
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">
                            <i class="bi bi-house"></i> Trang Chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/movie">
                            <i class="bi bi-collection-play"></i> Phim
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/discussion">
                            <i class="bi bi-chat-dots"></i> Thảo Luận
                        </a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex search-form me-3" method="GET" action="<?php echo BASE_URL; ?>/movie">
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
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/profile">
                                    <i class="bi bi-person"></i> Hồ Sơ
                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/reviews">
                                    <i class="bi bi-star"></i> Reviews Của Tôi
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/auth/logout">
                                    <i class="bi bi-box-arrow-right"></i> Đăng Xuất
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/login">
                                <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/register">
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
