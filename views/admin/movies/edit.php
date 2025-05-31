<?php
// Kiểm tra quyền admin đã được thực hiện trong AdminController
// Không cần kiểm tra lại ở đây

$current_page = 'movies';
$title = "Chỉnh sửa phim - Admin Panel";
include BASE_PATH . '/views/layouts/admin_header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-edit"></i> Chỉnh sửa phim</h2>
                <a href="<?= URLHelper::adminMovies() ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
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
                    <h5 class="mb-0">Thông tin phim</h5>
                </div>
                <div class="card-body">
                    <form action="<?= URLHelper::adminUpdateMovie($movie['id']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tên phim <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= htmlspecialchars($movie['title']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="4"><?= htmlspecialchars($movie['description']) ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="director" class="form-label">Đạo diễn</label>
                                            <input type="text" class="form-control" id="director" name="director" 
                                                   value="<?= htmlspecialchars($movie['director']) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="release_year" class="form-label">Năm phát hành</label>
                                            <input type="number" class="form-control" id="release_year" name="release_year" 
                                                   value="<?= $movie['release_year'] ?>" min="1900" max="<?= date('Y') + 5 ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="genre_id" class="form-label">Thể loại</label>
                                            <select class="form-select" id="genre_id" name="genre_id">
                                                <option value="">-- Chọn thể loại --</option>
                                                <?php foreach ($genres as $genre): ?>
                                                    <option value="<?= $genre['id'] ?>" 
                                                            <?= ($movie['genre_id'] == $genre['id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($genre['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Thời lượng (phút)</label>
                                            <input type="number" class="form-control" id="duration" name="duration" 
                                                   value="<?= $movie['duration'] ?>" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="poster" class="form-label">Poster phim</label>
                                    <input type="file" class="form-control" id="poster" name="poster" 
                                           accept="image/jpeg,image/jpg,image/png">
                                    <div class="form-text">Chấp nhận file JPG, JPEG, PNG. Tối đa 5MB.</div>
                                    
                                    <?php if (!empty($movie['poster'])): ?>
                                        <div class="mt-2">
                                            <label class="form-label">Poster hiện tại:</label>
                                            <div>
                                                <img src="<?= URLHelper::poster($movie['poster']) ?>" 
                                                     alt="Current poster" class="img-thumbnail" style="max-height: 200px;">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="trailer_url" class="form-label">URL trailer (YouTube)</label>
                                    <input type="url" class="form-control" id="trailer_url" name="trailer_url" 
                                           value="<?= htmlspecialchars($movie['trailer_url'] ?? '') ?>"
                                           placeholder="https://www.youtube.com/watch?v=...">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= URLHelper::adminMovies() ?>" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật phim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>
