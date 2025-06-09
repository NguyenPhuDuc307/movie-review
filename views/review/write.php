<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><?= $existingReview ? 'Chỉnh Sửa Review' : 'Viết Review' ?></h4>
                </div>
                <div class="card-body">
                    <!-- Thông tin phim -->
                    <div class="movie-info mb-3 p-3 rounded" style="background-color: var(--bg-tertiary); border: 1px solid var(--border-color);">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php if (!empty($movie['poster']) && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])): ?>
                                    <img src="<?= URLHelper::poster($movie['poster']) ?>"
                                        class="rounded" alt="<?= htmlspecialchars($movie['title']) ?>"
                                        style="width: 100px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded"
                                        style="width: 100px; height: 120px;">
                                        <div class="text-center">
                                            <i class="fas fa-film fa-lg"></i>
                                            <br><small>No poster</small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <h5 class="mb-1" style="color: var(--text-primary);"><?= htmlspecialchars($movie['title'] ?? 'Không có tiêu đề') ?></h5>
                                <p class="mb-1" style="color: var(--text-secondary);"><small>Năm: <?= $movie['release_year'] ?? 'Không rõ' ?></small></p>
                                <?php if (!empty($movie['description'])): ?>
                                    <p class="mb-0" style="color: var(--text-secondary);"><small><?= substr(htmlspecialchars($movie['description']), 0, 100) ?>...</small></p>
                                <?php else: ?>
                                    <p class="mb-0" style="color: var(--text-secondary);"><small>Chưa có mô tả</small></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Form review -->
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Đánh giá <span class="text-danger">*</span></label>
                            <div class="rating-input mb-2">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>"
                                        <?= ($existingReview && $existingReview['rating'] == $i) ? 'checked' : '' ?> required>
                                    <label for="star<?= $i ?>" class="star-label">★</label>
                                <?php endfor; ?>
                            </div>
                            <small class="form-text text-muted">Chọn từ 1 đến 5 sao</small>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề review <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?= htmlspecialchars($existingReview['title'] ?? '') ?>"
                                placeholder="Nhập tiêu đề cho Đánh giá của bạn" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung review <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="5"
                                placeholder="Chia sẻ cảm nhận của bạn về bộ phim này (tối thiểu 50 ký tự)" required><?= htmlspecialchars($existingReview['content'] ?? '') ?></textarea>
                            <small class="form-text text-muted">Tối thiểu 50 ký tự</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= URLHelper::movieDetail($movie['id']) ?>" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $existingReview ? 'Cập Nhật Review' : 'Gửi Review' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>