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
                    <h1>Thêm Phim Mới</h1>
                    <a href="<?= URLHelper::adminMovies() ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">
                                                    Tên Phim <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="title" name="title" 
                                                       value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="release_year" class="form-label">
                                                    Năm Phát Hành <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="release_year" 
                                                       name="release_year" min="1900" max="<?= date('Y') + 5 ?>"
                                                       value="<?= htmlspecialchars($_POST['release_year'] ?? '') ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="director" class="form-label">Đạo Diễn</label>
                                                <input type="text" class="form-control" id="director" name="director" 
                                                       value="<?= htmlspecialchars($_POST['director'] ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="duration" class="form-label">Thời Lượng (phút)</label>
                                                <input type="number" class="form-control" id="duration" name="duration" 
                                                       min="1" value="<?= htmlspecialchars($_POST['duration'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="genre_id" class="form-label">Thể Loại</label>
                                                <select class="form-select" id="genre_id" name="genre_id">
                                                    <option value="">-- Chọn thể loại --</option>
                                                    <?php foreach ($genres as $genre): ?>
                                                        <option value="<?= $genre['id'] ?>" 
                                                                <?= (($_POST['genre_id'] ?? '') == $genre['id']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($genre['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="poster" class="form-label">Poster</label>
                                                <input type="file" class="form-control" id="poster" name="poster" 
                                                       accept="image/jpeg,image/jpg,image/png">
                                                <small class="form-text text-muted">
                                                    Chấp nhận: JPG, JPEG, PNG. Tối đa 5MB.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="cast" class="form-label">Diễn Viên</label>
                                        <textarea class="form-control" id="cast" name="cast" rows="2" 
                                                  placeholder="Tên các diễn viên chính..."><?= htmlspecialchars($_POST['cast'] ?? '') ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            Mô Tả <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="5" 
                                                  placeholder="Nhập mô tả về phim..." required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="<?= URLHelper::adminMovies() ?>" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Hủy
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Lưu Phim
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
