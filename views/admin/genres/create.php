<?php 
$current_page = 'genres';
$title = 'Thêm thể loại mới - Admin Panel';
include BASE_PATH . '/views/layouts/admin_header.php'; 
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tags"></i> Thêm Thể Loại Mới</h1>
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

                    <form method="POST" action="<?= URLHelper::adminCreateGenre() ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Tên Thể Loại <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" 
                                   placeholder="Ví dụ: Hành động, Kinh dị, Lãng mạn..." required>
                            <div class="form-text">Tên thể loại phải là duy nhất trong hệ thống</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" placeholder="Mô tả chi tiết về thể loại này..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                            <div class="form-text">Mô tả giúp người dùng hiểu rõ hơn về thể loại này</div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= URLHelper::adminGenres() ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Lưu Thể Loại
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>
