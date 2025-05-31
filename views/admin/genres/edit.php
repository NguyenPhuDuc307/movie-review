<?php 
$current_page = 'genres';
$title = 'Chỉnh sửa thể loại - Admin Panel';
include BASE_PATH . '/views/layouts/admin_header.php'; 
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> Chỉnh Sửa Thể Loại</h1>
        <a href="<?= URLHelper::adminGenres() ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin thể loại</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $_SESSION['error'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($genre)): ?>
                        <form method="POST" action="<?= URLHelper::adminEditGenre($genre['id']) ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Tên Thể Loại <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($_POST['name'] ?? $genre['name']) ?>" 
                                       placeholder="Ví dụ: Hành động, Kinh dị, Lãng mạn..." required>
                                <div class="form-text">Tên thể loại phải là duy nhất trong hệ thống</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô Tả</label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="4" placeholder="Mô tả chi tiết về thể loại này..."><?= htmlspecialchars($_POST['description'] ?? $genre['description']) ?></textarea>
                                <div class="form-text">Mô tả giúp người dùng hiểu rõ hơn về thể loại này</div>
                            </div>
                            
                            <!-- Thông tin thêm -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Thông tin thể loại</h6>
                                            <p class="card-text mb-1">
                                                <strong>ID:</strong> <?= $genre['id'] ?>
                                            </p>
                                            <p class="card-text mb-1">
                                                <strong>Số phim:</strong> 
                                                <span class="badge bg-info"><?= $genre['movie_count'] ?? 0 ?> phim</span>
                                            </p>
                                            <p class="card-text mb-0">
                                                <strong>Ngày tạo:</strong> 
                                                <?= date('d/m/Y H:i', strtotime($genre['created_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="<?= URLHelper::adminGenres() ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập Nhật Thể Loại
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Không tìm thấy thể loại cần chỉnh sửa.
                        </div>
                        <a href="<?= URLHelper::adminGenres() ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>
