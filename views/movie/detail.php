<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($movie['poster']) && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])): ?>
                <img src="<?= URLHelper::poster($movie['poster']) ?>" 
                     class="img-fluid" alt="<?= htmlspecialchars($movie['title']) ?>" 
                     style="max-height: 400px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                     style="height: 400px;">
                    <div class="text-center">
                        <i class="fas fa-film fa-4x mb-3"></i>
                        <p class="mb-0">Không có poster</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <h1><?= htmlspecialchars($movie['title']) ?></h1>
            <p><strong>Năm phát hành:</strong> <?= $movie['release_year'] ?></p>
            <p><strong>Thể loại:</strong> <?= htmlspecialchars($movie['genre_name'] ?? 'Chưa phân loại') ?></p>
            <p><strong>Đạo diễn:</strong> <?= htmlspecialchars($movie['director'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Diễn viên:</strong> <?= htmlspecialchars($movie['cast'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Thời lượng:</strong> <?= $movie['duration'] ? $movie['duration'] . ' phút' : 'Chưa cập nhật' ?></p>
            
            <?php if (isset($movie['avg_rating']) && $movie['review_count'] > 0): ?>
                <div class="rating-summary mb-3">
                    <h5>Đánh giá trung bình: 
                        <div class="rating-display d-inline-block">
                            <?php 
                            $avgRating = round($movie['avg_rating']);
                            for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= $i <= $avgRating ? 'fas fa-star' : 'far fa-star' ?> star"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-warning ms-2"><?= number_format($movie['avg_rating'], 1) ?>/5</span>
                        <small class="text-muted">(<?= $movie['review_count'] ?> đánh giá)</small>
                    </h5>
                </div>
            <?php endif; ?>
            
            <p><strong>Mô tả:</strong></p>
            <p><?= nl2br(htmlspecialchars($movie['description'] ?? 'Chưa có mô tả')) ?></p>
        </div>
    </div>
    
    <hr>
    
    <!-- Nút viết review -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="review-actions mb-4">
            <?php if ($userReview): ?>
                <a href="<?= URLHelper::writeReview($movie['id']) ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh Sửa Review Của Bạn
                </a>
                <span class="text-muted ms-2">Bạn đã review phim này</span>
            <?php else: ?>
                <a href="<?= URLHelper::writeReview($movie['id']) ?>" class="btn btn-success">
                    <i class="fas fa-edit"></i> Viết Review
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <a href="<?= URLHelper::login() ?>">Đăng nhập</a> để viết review cho phim này.
        </div>
    <?php endif; ?>
    
    <h3>Đánh Giá</h3>
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($review['full_name']) ?></h5>
                    <div class="rating mb-2">
                        <div class="rating-display d-inline-block">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= $i <= $review['rating'] ? 'fas fa-star' : 'far fa-star' ?> star"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="ms-2"><?= $review['rating'] ?>/5</span>
                    </div>
                    <p><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                    <small class="text-muted">
                        Đăng lúc: <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có đánh giá nào cho phim này.</p>
    <?php endif; ?>

    <hr class="my-5">

    <!-- Phần Thảo Luận -->
    <div class="discussions-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-comments"></i> Thảo Luận về phim</h3>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= URLHelper::createDiscussion() ?>?movie_id=<?= $movie['id'] ?>" 
                   class="btn btn-success">
                    <i class="fas fa-plus"></i> Tạo thảo luận mới
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($discussions)): ?>
            <div class="row">
                <?php foreach ($discussions as $discussion): ?>
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <!-- Avatar chữ cái đầu -->
                                    <div class="me-3">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                             style="width: 40px; height: 40px; font-size: 16px;">
                                            <?= strtoupper(substr($discussion['full_name'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Nội dung thảo luận -->
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">
                                            <a href="<?= URLHelper::discussionDetail($discussion['id']) ?>" 
                                               class="text-decoration-none">
                                                <?= htmlspecialchars($discussion['title']) ?>
                                            </a>
                                        </h5>
                                        <p class="text-muted mb-2">
                                            Bởi <strong><?= htmlspecialchars($discussion['full_name']) ?></strong>
                                            • <?= date('d/m/Y H:i', strtotime($discussion['created_at'])) ?>
                                            • <i class="fas fa-comment"></i> <?= $discussion['comment_count'] ?> bình luận
                                        </p>
                                        <p class="card-text">
                                            <?= nl2br(htmlspecialchars(substr($discussion['content'], 0, 200))) ?>
                                            <?php if (strlen($discussion['content']) > 200): ?>
                                                <span class="text-muted">... </span>
                                                <a href="<?= URLHelper::discussionDetail($discussion['id']) ?>" 
                                                   class="text-primary">đọc tiếp</a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Link xem tất cả thảo luận -->
            <div class="text-center mt-4">
                <a href="<?= URLHelper::discussion() ?>?movie_id=<?= $movie['id'] ?>" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-list"></i> Xem tất cả thảo luận về phim này
                </a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                Chưa có thảo luận nào về phim này. 
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= URLHelper::createDiscussion() ?>?movie_id=<?= $movie['id'] ?>" 
                       class="alert-link">Hãy là người đầu tiên tạo thảo luận!</a>
                <?php else: ?>
                    <a href="<?= URLHelper::login() ?>" class="alert-link">Đăng nhập</a> để tạo thảo luận.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
