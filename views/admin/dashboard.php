<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <!-- Sidebar Admin -->
            <div class="bg-dark text-white" style="min-height: 100vh; margin-left: -15px; margin-right: -15px; padding: 20px;">
                <h4 class="mb-4">
                    <i class="fas fa-cog"></i> Admin Panel
                </h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white <?= URLHelper::isActive('admin') ? 'bg-primary' : '' ?>" 
                           href="<?= URLHelper::adminDashboard() ?>">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= URLHelper::isActive('admin/movies') ? 'bg-primary' : '' ?>" 
                           href="<?= URLHelper::adminMovies() ?>">
                            <i class="fas fa-film"></i> Quản lý Phim
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= URLHelper::isActive('admin/users') ? 'bg-primary' : '' ?>" 
                           href="<?= URLHelper::adminUsers() ?>">
                            <i class="fas fa-users"></i> Quản lý Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= URLHelper::isActive('admin/reviews') ? 'bg-primary' : '' ?>" 
                           href="<?= URLHelper::adminReviews() ?>">
                            <i class="fas fa-star"></i> Quản lý Reviews
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-white" href="<?= URLHelper::home() ?>">
                            <i class="fas fa-arrow-left"></i> Về trang chủ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-md-10">
            <div class="container">
                <h1 class="mb-4">Dashboard Admin</h1>
                
                <!-- Thống kê tổng quan -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_movies ?></h4>
                                        <p class="mb-0">Tổng Phim</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-film fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_users ?></h4>
                                        <p class="mb-0">Tổng Users</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_reviews ?></h4>
                                        <p class="mb-0">Tổng Reviews</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-star fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Phim mới nhất -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-film"></i> Phim Mới Nhất</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_movies)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_movies as $movie): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong><?= htmlspecialchars($movie['title']) ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= $movie['release_year'] ?> | <?= htmlspecialchars($movie['genre_name'] ?? 'Chưa phân loại') ?></small>
                                                </div>
                                                <a href="<?= URLHelper::adminEditMovie($movie['id']) ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có phim nào</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-star"></i> Reviews Mới Nhất</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_reviews)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_reviews as $review): ?>
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong><?= htmlspecialchars($review['movie_title']) ?></strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            Bởi: <?= htmlspecialchars($review['user_name']) ?> | 
                                                            Rating: <?= $review['rating'] ?>/5
                                                        </small>
                                                    </div>
                                                    <a href="<?= URLHelper::adminReviews() ?>" class="btn btn-sm btn-outline-primary">
                                                        Xem
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có review nào</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
