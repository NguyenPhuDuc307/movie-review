<?php 
$current_page = 'movies';
$title = "Quản lý phim - Admin Panel";
include BASE_PATH . '/views/layouts/admin_header.php'; 
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-film"></i> Quản Lý Phim</h2>
                <a href="<?= URLHelper::adminCreateMovie() ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm Phim Mới
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
                
            <!-- Tìm kiếm -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="<?= URLHelper::adminMovies() ?>">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Tìm kiếm phim..." value="<?= htmlspecialchars($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                
            <!-- Bảng phim -->
            <?php if (!empty($movies)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Danh sách phim</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="10%">Poster</th>
                                        <th width="25%">Tên Phim</th>
                                        <th width="15%">Thể Loại</th>
                                        <th width="10%">Năm</th>
                                        <th width="10%">Reviews</th>
                                        <th width="10%">Rating TB</th>
                                        <th width="15%">Thao Tác</th>
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
                                                         class="img-thumbnail"
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
                                            <td><?= htmlspecialchars($movie['genre'] ?? 'Chưa phân loại') ?></td>
                                            <td><?= date('Y', strtotime($movie['release_date'] ?? '')) ?: 'N/A' ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $movie['review_count'] ?? 0 ?></span>
                                            </td>
                                            <td>
                                                <?php if (isset($movie['avg_rating']) && $movie['avg_rating']): ?>
                                                    <div class="text-warning">
                                                        <?= number_format($movie['avg_rating'], 1) ?>/5
                                                        <br><small>(<?= $movie['review_count'] ?? 0 ?> đánh giá)</small>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Chưa có</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?= URLHelper::movieDetail($movie['id']) ?>" 
                                                       class="btn btn-outline-info" target="_blank" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= URLHelper::adminEditMovie($movie['id']) ?>" 
                                                       class="btn btn-outline-warning" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= URLHelper::adminDeleteMovie($movie['id']) ?>" 
                                                       class="btn btn-outline-danger" title="Xóa"
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
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <nav class="mt-3">
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == ($currentPage ?? 1) ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= URLHelper::adminMovies($search ?? '', $i) ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <?= !empty($search) ? 'Không tìm thấy phim nào với từ khóa này.' : 'Chưa có phim nào trong hệ thống.' ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>