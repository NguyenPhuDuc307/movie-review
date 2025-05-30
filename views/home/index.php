<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">
            <i class="bi bi-film text-danger"></i> 
            Chào Mừng Đến Với MovieReview
        </h1>
        <p class="lead mb-4">
            Khám phá, đánh giá và thảo luận về những bộ phim tuyệt vời nhất
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?php echo BASE_URL; ?>/movies" class="btn btn-primary btn-lg">
                <i class="bi bi-collection-play"></i> Khám Phá Phim
            </a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="<?php echo BASE_URL; ?>/register" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-person-plus"></i> Tham Gia Ngay
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Latest Movies Section -->
<?php if (!empty($latestMovies)): ?>
<section class="mb-5">
    <h2 class="section-title">
        <i class="bi bi-clock-history"></i> Phim Mới Nhất
    </h2>
    <div class="row">
        <?php foreach ($latestMovies as $movie): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card movie-card h-100">
                    <?php if ($movie['poster']): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/posters/<?php echo $movie['poster']; ?>" 
                             class="card-img-top movie-poster" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <?php else: ?>
                        <div class="movie-poster d-flex align-items-center justify-content-center">
                            <i class="bi bi-film" style="font-size: 3rem; color: var(--text-secondary);"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="<?php echo BASE_URL; ?>/movie?id=<?php echo $movie['id']; ?>" 
                               class="text-decoration-none text-light">
                                <?php echo htmlspecialchars($movie['title']); ?>
                            </a>
                        </h5>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary">
                                <?php echo $movie['genre_name'] ?? 'Chưa phân loại'; ?>
                            </span>
                            <small class="text-muted">
                                <?php echo $movie['release_year']; ?>
                            </small>
                        </div>
                        
                        <p class="card-text text-muted flex-grow-1">
                            <?php echo htmlspecialchars(substr($movie['description'], 0, 120)) . '...'; ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> <?php echo $movie['duration']; ?> phút
                            </small>
                            <a href="<?php echo BASE_URL; ?>/movie?id=<?php echo $movie['id']; ?>" 
                               class="btn btn-primary btn-sm">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center">
        <a href="<?php echo BASE_URL; ?>/movies" class="btn btn-outline-light">
            Xem Tất Cả Phim <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>
<?php endif; ?>

<!-- Top Rated Movies Section -->
<?php if (!empty($topRatedMovies)): ?>
<section class="mb-5">
    <h2 class="section-title">
        <i class="bi bi-star-fill"></i> Phim Được Đánh Giá Cao
    </h2>
    <div class="row">
        <?php foreach ($topRatedMovies as $movie): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card movie-card h-100">
                    <?php if ($movie['poster']): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/posters/<?php echo $movie['poster']; ?>" 
                             class="card-img-top movie-poster" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <?php else: ?>
                        <div class="movie-poster d-flex align-items-center justify-content-center">
                            <i class="bi bi-film" style="font-size: 3rem; color: var(--text-secondary);"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="<?php echo BASE_URL; ?>/movie?id=<?php echo $movie['id']; ?>" 
                               class="text-decoration-none text-light">
                                <?php echo htmlspecialchars($movie['title']); ?>
                            </a>
                        </h5>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary">
                                <?php echo $movie['genre_name'] ?? 'Chưa phân loại'; ?>
                            </span>
                            <div class="rating-stars">
                                <?php 
                                $rating = round($movie['avg_rating']);
                                for ($i = 1; $i <= 5; $i++): 
                                ?>
                                    <i class="bi bi-star<?php echo $i <= $rating ? '-fill' : ''; ?>"></i>
                                <?php endfor; ?>
                                <small class="text-muted ms-1">
                                    (<?php echo $movie['review_count']; ?>)
                                </small>
                            </div>
                        </div>
                        
                        <p class="card-text text-muted flex-grow-1">
                            <?php echo htmlspecialchars(substr($movie['description'], 0, 120)) . '...'; ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> <?php echo $movie['duration']; ?> phút
                            </small>
                            <a href="<?php echo BASE_URL; ?>/movie?id=<?php echo $movie['id']; ?>" 
                               class="btn btn-primary btn-sm">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action Section -->
<section class="text-center py-5">
    <div class="card border-0" style="background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);">
        <div class="card-body py-5">
            <h3 class="mb-4">Tham Gia Cộng Đồng Yêu Phim</h3>
            <p class="lead mb-4">
                Chia sẻ cảm nhận, thảo luận và khám phá những bộ phim tuyệt vời cùng cộng đồng
            </p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="<?php echo BASE_URL; ?>/register" class="btn btn-primary btn-lg me-3">
                    <i class="bi bi-person-plus"></i> Đăng Ký Ngay
                </a>
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                </a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/movies" class="btn btn-primary btn-lg me-3">
                    <i class="bi bi-collection-play"></i> Khám Phá Phim
                </a>
                <a href="<?php echo BASE_URL; ?>/discussions" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-chat-dots"></i> Tham Gia Thảo Luận
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
