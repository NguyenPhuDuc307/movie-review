<?php 
$current_page = 'dashboard';
include BASE_PATH . '/views/layouts/admin_header.php'; 
?>

<div class="container-fluid mt-4">
    <h1 class="mb-4">Dashboard Admin</h1>
                
                <!-- Thống kê tổng quan -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_movies ?></h4>
                                        <p class="mb-0">Tổng Phim</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-film fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_users ?></h4>
                                        <p class="mb-0">Tổng Users</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_reviews ?></h4>
                                        <p class="mb-0">Tổng Reviews</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-star fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?= $total_discussions ?></h4>
                                        <p class="mb-0">Tổng Thảo Luận</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-comments fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Phim mới nhất -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-film"></i> Phim Mới Nhất</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_movies)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_movies as $movie): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong><?= htmlspecialchars($movie['title']) ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= $movie['release_year'] ?> | <?= htmlspecialchars($movie['genre_name'] ?? 'Chưa phân loại') ?></small>
                                                </div>
                                                <a href="<?= URLHelper::adminEditMovie($movie['id']) ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có phim nào</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-star"></i> Reviews Mới Nhất</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_reviews)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_reviews as $review): ?>
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong><?= htmlspecialchars($review['movie_title']) ?></strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            Bởi: <?= htmlspecialchars($review['user_name']) ?> | 
                                                            Rating: <?= $review['rating'] ?>/5
                                                        </small>
                                                    </div>
                                                    <a href="<?= URLHelper::adminReviews() ?>" class="btn btn-sm btn-outline-primary">
                                                        Xem
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có review nào</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thảo luận mới nhất -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-comments"></i> Thảo Luận Mới Nhất</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_discussions)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tiêu đề</th>
                                                    <th>Tác giả</th>
                                                    <th>Phim</th>
                                                    <th>Lượt xem</th>
                                                    <th>Bình luận</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recent_discussions as $discussion): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= htmlspecialchars($discussion['title']) ?></strong>
                                                        </td>
                                                        <td><?= htmlspecialchars($discussion['full_name']) ?></td>
                                                        <td>
                                                            <?php if ($discussion['movie_title']): ?>
                                                                <span class="badge bg-info">
                                                                    <?= htmlspecialchars($discussion['movie_title']) ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-muted">Chung</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <i class="fas fa-eye text-info"></i>
                                                            <?= number_format($discussion['views']) ?>
                                                        </td>
                                                        <td>
                                                            <i class="fas fa-comment text-success"></i>
                                                            <?= number_format($discussion['comment_count']) ?>
                                                        </td>
                                                        <td>
                                                            <small><?= date('d/m/Y H:i', strtotime($discussion['created_at'])) ?></small>
                                                        </td>
                                                        <td>
                                                            <a href="<?= URLHelper::discussionDetail($discussion['id']) ?>" 
                                                               class="btn btn-sm btn-outline-info" target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="<?= URLHelper::adminDiscussions() ?>" class="btn btn-primary">
                                            <i class="fas fa-comments"></i> Xem Tất Cả Thảo Luận
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có thảo luận nào</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<?php include BASE_PATH . '/views/layouts/admin_footer.php'; ?>
