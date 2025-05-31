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
                        <a class="nav-link text-white" href="<?= URLHelper::adminDashboard() ?>">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white bg-primary" href="<?= URLHelper::adminMovies() ?>">
                            <i class="fas fa-film"></i> Quản lý Phim
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= URLHelper::adminUsers() ?>">
                            <i class="fas fa-users"></i> Quản lý Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= URLHelper::adminReviews() ?>">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Quản Lý Phim</h1>
                    <a href="<?= URLHelper::adminCreateMovie() ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Thêm Phim Mới
                    </a>
                </div>
                
                <!-- Tìm kiếm -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="<?= URLHelper::adminMovies() ?>">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Tìm kiếm phim..." value="<?= htmlspecialchars($search) ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Bảng phim -->
                <?php if (!empty($movies)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Poster</th>
                                    <th>Tên Phim</th>
                                    <th>Thể Loại</th>
                                    <th>Năm</th>
                                    <th>Reviews</th>
                                    <th>Rating TB</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($movies as $movie): ?>
                                    <tr>
                                        <td><?= $movie['id'] ?></td>
                                        <td>
                                            <?php if (!empty($movie['poster'])): ?>
                                                <img src="<?= URLHelper::poster($movie['poster']) ?>" 
                                                     alt="<?= htmlspecialchars($movie['title']) ?>" 
                                                     style="width: 50px; height: 60px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 60px; font-size: 12px;">
                                                    No Image
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($movie['title']) ?></strong><br>
                                            <small class="text-muted">
                                                Đạo diễn: <?= htmlspecialchars($movie['director'] ?? 'Chưa cập nhật') ?>
                                            </small>
                                        </td>
                                        <td><?= htmlspecialchars($movie['genre_name'] ?? 'Chưa phân loại') ?></td>
                                        <td><?= $movie['release_year'] ?></td>
                                        <td><?= $movie['review_count'] ?? 0 ?></td>
                                        <td>
                                            <?php if ($movie['avg_rating']): ?>
                                                <?= number_format($movie['avg_rating'], 1) ?>/5
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= URLHelper::movieDetail($movie['id']) ?>" 
                                                   class="btn btn-info" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= URLHelper::adminEditMovie($movie['id']) ?>" 
                                                   class="btn btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= URLHelper::adminDeleteMovie($movie['id']) ?>" 
                                                   class="btn btn-danger"
                                                   onclick="return confirm('Bạn có chắc muốn xóa phim này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Phân trang -->
                    <?php if ($totalPages > 1): ?>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= URLHelper::adminMovies($search, $i) ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <?= !empty($search) ? 'Không tìm thấy phim nào với từ khóa này.' : 'Chưa có phim nào trong hệ thống.' ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
