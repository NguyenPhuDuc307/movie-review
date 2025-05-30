<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($movie['poster']) && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])): ?>
                <img src="<?= BASE_URL ?>/uploads/posters/<?= $movie['poster'] ?>" 
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
                        <span class="text-warning"><?= number_format($movie['avg_rating'], 1) ?>/5</span>
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
                <a href="<?= BASE_URL ?>/review/write?movie_id=<?= $movie['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh Sửa Review Của Bạn
                </a>
                <span class="text-muted ms-2">Bạn đã review phim này</span>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/review/write?movie_id=<?= $movie['id'] ?>" class="btn btn-success">
                    <i class="fas fa-edit"></i> Viết Review
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <a href="<?= BASE_URL ?>/login">Đăng nhập</a> để viết review cho phim này.
        </div>
    <?php endif; ?>
    
    <h3>Đánh Giá</h3>
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($review['full_name']) ?></h5>
                    <div class="rating mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?= $i <= $review['rating'] ? 'text-warning' : 'text-muted' ?>">★</span>
                        <?php endfor; ?>
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
</div>

<?php include 'views/layouts/footer.php'; ?>
