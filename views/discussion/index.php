<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Thảo Luận Phim</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>/discussion/create" class="btn btn-primary">Tạo Thảo Luận Mới</a>
                <?php endif; ?>
            </div>

            <!-- Search and Filter Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="<?php echo BASE_URL; ?>/discussion">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Tìm kiếm thảo luận..." 
                                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                            <div class="col-md-3">
                                <select name="sort" class="form-control">
                                    <option value="latest" <?= ($_GET['sort'] ?? '') == 'latest' ? 'selected' : '' ?>>Mới nhất</option>
                                    <option value="hot" <?= ($_GET['sort'] ?? '') == 'hot' ? 'selected' : '' ?>>Hot nhất</option>
                                    <option value="most_views" <?= ($_GET['sort'] ?? '') == 'most_views' ? 'selected' : '' ?>>Nhiều lượt xem</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-outline-primary w-100">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Discussion List -->
            <?php if (!empty($discussions)): ?>
                <div class="row">
                    <?php foreach ($discussions as $discussion): ?>
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="card-title">
                                <a href="<?php echo BASE_URL; ?>/discussion/detail/<?= $discussion['id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($discussion['title']) ?>
                                </a>
                            </h5>
                                            
                                            <p class="card-text text-muted">
                                                <?= htmlspecialchars(substr($discussion['content'], 0, 150)) ?>
                                                <?= strlen($discussion['content']) > 150 ? '...' : '' ?>
                                            </p>
                                            
                                            <div class="small text-muted">
                                                <i class="fas fa-user"></i> <?= htmlspecialchars($discussion['username']) ?>
                                                <i class="fas fa-calendar ms-3"></i> <?= date('d/m/Y H:i', strtotime($discussion['created_at'])) ?>
                                                <?php if ($discussion['movie_title']): ?>
                                                    <i class="fas fa-film ms-3"></i> <?= htmlspecialchars($discussion['movie_title']) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 text-end">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <small class="text-muted">Lượt xem</small><br>
                                                    <strong><?= number_format($discussion['views']) ?></strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Bình luận</small><br>
                                                    <strong><?= number_format($discussion['comment_count']) ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h4 class="text-muted">Chưa có thảo luận nào</h4>
                    <p class="text-muted">Hãy là người đầu tiên tạo thảo luận về phim!</p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>/discussion/create" class="btn btn-primary">Tạo Thảo Luận Đầu Tiên</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
