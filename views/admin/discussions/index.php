<?php 
$current_page = 'discussions';
$title = "Quản lý thảo luận - Admin Panel";
include BASE_PATH . '/views/layouts/admin_header.php'; 
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-comments"></i> Quản Lý Thảo Luận</h2>
                <div class="text-muted">
                    Tổng: <?= number_format($total) ?> thảo luận
                </div>
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

            <!-- Search Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="<?= URLHelper::adminDiscussions() ?>">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Tìm kiếm theo tiêu đề, nội dung, tác giả, phim..." 
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Discussions List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách thảo luận</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($discussions)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có thảo luận nào</h5>
                            <p class="text-muted">
                                <?= !empty($search) ? 'Không tìm thấy thảo luận phù hợp với từ khóa tìm kiếm.' : 'Chưa có thảo luận nào được tạo.' ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Tác giả</th>
                                        <th>Phim</th>
                                        <th>Lượt xem</th>
                                        <th>Bình luận</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($discussions as $discussion): ?>
                                        <tr>
                                            <td><?= $discussion['id'] ?></td>
                                            <td>
                                                <div class="discussion-title">
                                                    <strong><?= htmlspecialchars($discussion['title']) ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars(substr($discussion['content'], 0, 100)) ?>
                                                        <?= strlen($discussion['content']) > 100 ? '...' : '' ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-2"
                                                         style="width: 30px; height: 30px; font-size: 12px;">
                                                        <?= strtoupper(substr($discussion['username'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div><?= htmlspecialchars($discussion['username']) ?></div>
                                                        <small class="text-muted"><?= htmlspecialchars($discussion['email']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($discussion['movie_title']): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-film"></i>
                                                        <?= htmlspecialchars($discussion['movie_title']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="fas fa-comments"></i> Chung
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-eye text-info"></i>
                                                <?= number_format($discussion['views']) ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-comment text-success"></i>
                                                <?= number_format($discussion['comment_count']) ?>
                                            </td>
                                            <td>
                                                <span class="badge <?= $discussion['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $discussion['status'] === 'active' ? 'Hoạt động' : 'Đã ẩn' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($discussion['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= URLHelper::discussionDetail($discussion['id']) ?>" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       target="_blank"
                                                       title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete(<?= $discussion['id'] ?>, '<?= htmlspecialchars(addslashes($discussion['title'])) ?>')"
                                                            title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Page -->
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?= URLHelper::adminDiscussions($search, $currentPage - 1) ?>">
                                                <i class="fas fa-chevron-left"></i> Trước
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- Page Numbers -->
                                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= URLHelper::adminDiscussions($search, $i) ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Next Page -->
                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?= URLHelper::adminDiscussions($search, $currentPage + 1) ?>">
                                                Sau <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa thảo luận này không?</p>
                <p><strong>Tiêu đề:</strong> <span id="delete-title"></span></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Lưu ý:</strong> Việc này sẽ xóa thảo luận và tất cả bình luận liên quan. Không thể hoàn tác!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.discussion-title {
    max-width: 300px;
}

.discussion-title strong {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table th, .table td {
    vertical-align: middle;
}

.btn-group .btn {
    border: none;
}

.page-link {
    background-color: #2d3236;
    border-color: #495057;
    color: #adb5bd;
}

.page-link:hover {
    background-color: #495057;
    border-color: #6c757d;
    color: #fff;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}
</style>

<script>
function confirmDelete(discussionId, title) {
    document.getElementById('delete-title').textContent = title;
    document.getElementById('delete-form').action = '<?= URLHelper::adminDeleteDiscussion('') ?>' + discussionId;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>
