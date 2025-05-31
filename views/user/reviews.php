<?php $this->view('layouts/header', ['pageTitle' => $data['pageTitle']]); ?>

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-light">
            <i class="fas fa-star"></i> Reviews Của Tôi
        </h2>
        <div class="text-muted">
            Tổng cộng: <span class="badge bg-primary"><?= $data['totalReviews'] ?></span> reviews
        </div>
    </div>

    <?php if (empty($data['reviews'])): ?>
        <!-- Empty state -->
        <div class="card bg-dark border-secondary">
            <div class="card-body text-center py-5">
                <i class="fas fa-star-half-alt text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-light mt-3">Chưa có review nào</h4>
                <p class="text-muted">Bạn chưa viết review cho phim nào. Hãy bắt đầu review phim yêu thích của bạn!</p>
                <a href="<?= URLHelper::movies() ?>" class="btn btn-primary">
                    <i class="fas fa-film"></i> Khám phá phim
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Reviews List -->
        <div class="row">
            <?php foreach ($data['reviews'] as $review): ?>
                <div class="col-12 mb-4">
                    <div class="card bg-dark border-secondary">
                        <div class="card-body">
                            <div class="row">
                                <!-- Movie Poster -->
                                <div class="col-md-2">
                                    <a href="<?= URLHelper::movieDetail($review['movie_id']) ?>">
                                        <img src="<?= $review['movie_poster'] ? BASE_URL . '/uploads/posters/' . $review['movie_poster'] : BASE_URL . '/assets/images/no-poster.jpg' ?>" 
                                             class="img-fluid rounded" 
                                             alt="<?= htmlspecialchars($review['movie_title']) ?>"
                                             style="height: 120px; object-fit: cover;">
                                    </a>
                                </div>
                                
                                <!-- Review Content -->
                                <div class="col-md-10">
                                    <!-- Movie Title and Rating -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">
                                            <a href="<?= URLHelper::movieDetail($review['movie_id']) ?>" 
                                               class="text-light text-decoration-none">
                                                <?= htmlspecialchars($review['movie_title']) ?>
                                            </a>
                                        </h5>
                                        <div class="text-end">
                                            <div class="rating-stars mb-1">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star <?= $i <= $review['rating'] ? 'text-warning' : 'text-muted' ?>"></i>
                                                <?php endfor; ?>
                                                <span class="text-light ms-1"><?= $review['rating'] ?>/5</span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i>
                                                <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <!-- Review Content -->
                                    <div class="text-light mb-3">
                                        <?= nl2br(htmlspecialchars($review['content'])) ?>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="<?= URLHelper::movieDetail($review['movie_id']) ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> Xem phim
                                            </a>
                                        </div>
                                        <div>
                                            <a href="<?= URLHelper::movieDetail($review['movie_id']) ?>#review-<?= $review['id'] ?>" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-link"></i> Xem review
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($data['totalPages'] > 1): ?>
            <nav aria-label="Reviews pagination">
                <ul class="pagination justify-content-center">
                    <!-- Previous -->
                    <?php if ($data['currentPage'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link bg-dark border-secondary text-light" 
                               href="<?= URLHelper::userReviews() ?>?page=<?= $data['currentPage'] - 1 ?>">
                                <i class="fas fa-chevron-left"></i> Trước
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link bg-dark border-secondary text-muted">
                                <i class="fas fa-chevron-left"></i> Trước
                            </span>
                        </li>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php 
                    $startPage = max(1, $data['currentPage'] - 2);
                    $endPage = min($data['totalPages'], $data['currentPage'] + 2);
                    ?>
                    
                    <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                        <li class="page-item <?= $page == $data['currentPage'] ? 'active' : '' ?>">
                            <a class="page-link bg-dark border-secondary <?= $page == $data['currentPage'] ? 'bg-primary border-primary' : 'text-light' ?>" 
                               href="<?= URLHelper::userReviews() ?>?page=<?= $page ?>">
                                <?= $page ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next -->
                    <?php if ($data['currentPage'] < $data['totalPages']): ?>
                        <li class="page-item">
                            <a class="page-link bg-dark border-secondary text-light" 
                               href="<?= URLHelper::userReviews() ?>?page=<?= $data['currentPage'] + 1 ?>">
                                Sau <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link bg-dark border-secondary text-muted">
                                Sau <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php $this->view('layouts/footer'); ?>
