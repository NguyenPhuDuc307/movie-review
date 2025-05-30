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
                    <div class="movie-info mb-3 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php if (!empty($movie['poster']) && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])): ?>
                                    <img src="<?= BASE_URL ?>/uploads/posters/<?= $movie['poster'] ?>" 
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
                                <h5 class="mb-1"><?= htmlspecialchars($movie['title'] ?? 'Không có tiêu đề') ?></h5>
                                <p class="text-muted mb-1"><small>Năm: <?= $movie['release_year'] ?? 'Không rõ' ?></small></p>
                                <?php if (!empty($movie['description'])): ?>
                                    <p class="mb-0 text-muted"><small><?= substr(htmlspecialchars($movie['description']), 0, 100) ?>...</small></p>
                                <?php else: ?>
                                    <p class="mb-0 text-muted"><small>Chưa có mô tả</small></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form review -->
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Đánh giá <span class="text-danger">*</span></label>
                            <div class="rating-input mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
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
                                   placeholder="Nhập tiêu đề cho review của bạn" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung review <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="5" 
                                      placeholder="Chia sẻ cảm nhận của bạn về bộ phim này (tối thiểu 50 ký tự)" required><?= htmlspecialchars($existingReview['content'] ?? '') ?></textarea>
                            <small class="form-text text-muted">Tối thiểu 50 ký tự</small>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/movie/detail/<?= $movie['id'] ?>" class="btn btn-secondary">Hủy</a>
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

<style>
.rating-input {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
}

.rating-input input[type="radio"] {
    display: none;
}

.star-label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
    margin-right: 5px;
}

.rating-input input[type="radio"]:checked ~ .star-label {
    color: #ffc107;
}

.rating-input input[type="radio"]:checked + .star-label {
    color: #ffc107;
}

.star-label:hover,
.star-label:hover ~ .star-label {
    color: #ffc107;
}

/* Hiệu ứng hover từ trái sang phải */
.rating-input:hover .star-label {
    color: #ddd;
}

.rating-input .star-label:hover,
.rating-input .star-label:hover ~ .star-label {
    color: #ffc107;
}
</style>

<?php include 'views/layouts/footer.php'; ?>
