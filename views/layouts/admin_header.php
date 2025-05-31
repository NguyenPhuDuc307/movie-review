<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Panel - Movie Review' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #212529;
            color: #fff;
        }
        
        .admin-sidebar {
            background-color: #1a1d20;
            min-height: 100vh;
            border-right: 1px solid #495057;
        }
        
        .admin-sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-radius: 6px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        
        .admin-sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        
        .admin-sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }
        
        .admin-content {
            background-color: #212529;
            min-height: 100vh;
        }
        
        .card {
            background-color: #2d3236;
            border: 1px solid #495057;
        }
        
        .card-header {
            background-color: #343a40;
            border-bottom: 1px solid #495057;
        }
        
        .table-dark {
            --bs-table-bg: #2d3236;
        }
        
        .btn-outline-info:hover {
            background-color: #0dcaf0;
            border-color: #0dcaf0;
        }
        
        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <div class="col-md-2 admin-sidebar px-0">
                <div class="p-3">
                    <h4 class="mb-4 text-center">
                        <i class="fas fa-cog"></i> Admin Panel
                    </h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin') !== false && strpos($_SERVER['REQUEST_URI'], '/admin/') === false ? 'active' : '' ?>" 
                               href="<?= URLHelper::adminDashboard() ?>">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/movies') !== false ? 'active' : '' ?>" 
                               href="<?= URLHelper::adminMovies() ?>">
                                <i class="fas fa-film"></i> Quản lý Phim
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/genres') !== false ? 'active' : '' ?>" 
                               href="<?= URLHelper::adminGenres() ?>">
                                <i class="fas fa-tags"></i> Quản lý Thể Loại
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : '' ?>" 
                               href="<?= URLHelper::adminUsers() ?>">
                                <i class="fas fa-users"></i> Quản lý Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/reviews') !== false ? 'active' : '' ?>" 
                               href="<?= URLHelper::adminReviews() ?>">
                                <i class="fas fa-star"></i> Quản lý Reviews
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <hr class="border-secondary">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>">
                                <i class="fas fa-arrow-left"></i> Về trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= URLHelper::logout() ?>">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Admin Content -->
            <div class="col-md-10 admin-content">
