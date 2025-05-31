<?php
// Kiểm tra quyền admin đã được thực hiện trong AdminController
// Không cần kiểm tra lại ở đây

$title = "Chỉnh sửa phim - Admin Panel";
include BASE_PATH . '/views/layouts/header.php';
?>

<div class="container mt-4">
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
                <div class="card-body">
                    <form action="<?= URLHelper::adminUpdateMovie($movie['id']) ?>" method="POST">
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
                                            <label for="release_date" class="form-label">Ngày phát hành</label>
                                            <input type="date" class="form-control" id="release_date" name="release_date" 
                                                   value="<?= $movie['release_date'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="genre" class="form-label">Thể loại</label>
                                            <input type="text" class="form-control" id="genre" name="genre" 
                                                   value="<?= htmlspecialchars($movie['genre']) ?>">
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
                                    <label for="poster_url" class="form-label">URL poster</label>
                                    <input type="url" class="form-control" id="poster_url" name="poster_url" 
                                           value="<?= htmlspecialchars($movie['poster_url']) ?>">
                                    <?php if ($movie['poster_url']): ?>
                                        <div class="mt-2">
                                            <img src="<?= URLHelper::poster($movie['poster_url']) ?>" 
                                                 alt="Current poster" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="trailer_url" class="form-label">URL trailer</label>
                                    <input type="url" class="form-control" id="trailer_url" name="trailer_url" 
                                           value="<?= htmlspecialchars($movie['trailer_url']) ?>">
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

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
