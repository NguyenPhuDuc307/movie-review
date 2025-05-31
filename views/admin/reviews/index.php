<?php
// Kiểm tra quyền admin đã được thực hiện trong AdminController
// Dữ liệu $reviews đã được truyền từ controller

$title = "Quản lý đánh giá - Admin Panel";
include BASE_PATH . '/views/layouts/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-star"></i> Quản lý đánh giá</h2>
                <a href="<?= URLHelper::adminDashboard() ?>" class="btn btn-secondary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
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

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách đánh giá</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($reviews)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-star-o fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có đánh giá nào</h5>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Phim</th>
                                        <th width="15%">Người dùng</th>
                                        <th width="10%">Đánh giá</th>
                                        <th width="25%">Nội dung</th>
                                        <th width="15%">Ngày tạo</th>
                                        <th width="10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reviews as $review): ?>
                                        <tr>
                                            <td><?= $review['id'] ?></td>
                                            <td>
                                                <a href="<?= URLHelper::movieDetail($review['movie_id']) ?>" 
                                                   class="text-decoration-none" target="_blank">
                                                    <?= htmlspecialchars($review['movie_title']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= htmlspecialchars($review['username']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <?php if ($i <= $review['rating']): ?>
                                                            <i class="fas fa-star"></i>
                                                        <?php else: ?>
                                                            <i class="far fa-star"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                    <small class="text-muted">(<?= $review['rating'] ?>/5)</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <?= htmlspecialchars($review['content']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="#" class="btn btn-sm btn-outline-info" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#reviewModal<?= $review['id'] ?>"
                                                       title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= URLHelper::adminDeleteReview($review['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')"
                                                       title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Detail Modals -->
<?php foreach ($reviews as $review): ?>
<div class="modal fade" id="reviewModal<?= $review['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Phim:</strong> <?= htmlspecialchars($review['movie_title']) ?></p>
                        <p><strong>Người dùng:</strong> <?= htmlspecialchars($review['username']) ?></p>
                        <p><strong>Đánh giá:</strong>
                            <span class="text-warning">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $review['rating']): ?>
                                        <i class="fas fa-star"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                (<?= $review['rating'] ?>/5)
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ngày tạo:</strong> <?= date('d/m/Y H:i:s', strtotime($review['created_at'])) ?></p>
                        <p><strong>Ngày cập nhật:</strong> <?= date('d/m/Y H:i:s', strtotime($review['updated_at'])) ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Nội dung đánh giá:</strong></p>
                        <div class="border p-3 bg-light rounded">
                            <?= nl2br(htmlspecialchars($review['content'])) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a href="<?= URLHelper::adminDeleteReview($review['id']) ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                    <i class="fas fa-trash"></i> Xóa đánh giá
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
