<?php 
$current_page = 'genres';
$title = "Quản lý thể loại - Admin Panel";
include BASE_PATH . '/views/layouts/admin_header.php'; 
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-tags"></i> Quản Lý Thể Loại</h2>
                <a href="<?= URLHelper::adminCreateGenre() ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm Thể Loại Mới
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
                    <form method="GET" action="<?= URLHelper::adminGenres() ?>">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Tìm kiếm thể loại..." value="<?= htmlspecialchars($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                
            <!-- Bảng thể loại -->
            <?php if (!empty($genres)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Danh sách thể loại (<?= $total_records ?> thể loại)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên thể loại</th>
                                        <th>Mô tả</th>
                                        <th>Số phim</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($genres as $genre): ?>
                                        <tr>
                                            <td><?= $genre['id'] ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($genre['name']) ?></strong>
                                            </td>
                                            <td>
                                                <?php if (!empty($genre['description'])): ?>
                                                    <?= htmlspecialchars(mb_substr($genre['description'], 0, 100)) ?>
                                                    <?= mb_strlen($genre['description']) > 100 ? '...' : '' ?>
                                                <?php else: ?>
                                                    <em class="text-muted">Chưa có mô tả</em>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= $genre['movie_count'] ?> phim</span>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($genre['created_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= URLHelper::adminEditGenre($genre['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($genre['movie_count'] == 0): ?>
                                                        <a href="<?= URLHelper::adminDeleteGenre($genre['id']) ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')"
                                                           title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-outline-secondary" 
                                                                disabled title="Không thể xóa thể loại đang có phim">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Phân trang -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Phân trang thể loại" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= URLHelper::adminGenres($search, 1) ?>">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?= URLHelper::adminGenres($search, $current_page - 1) ?>">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($total_pages, $current_page + 2);
                            
                            for ($i = $start_page; $i <= $end_page; $i++):
                            ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= URLHelper::adminGenres($search, $i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= URLHelper::adminGenres($search, $current_page + 1) ?>">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?= URLHelper::adminGenres($search, $total_pages) ?>">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5>Chưa có thể loại nào</h5>
                        <p class="text-muted">Hiện tại chưa có thể loại nào trong hệ thống.</p>
                        <a href="<?= URLHelper::adminCreateGenre() ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Thêm Thể Loại Đầu Tiên
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>
