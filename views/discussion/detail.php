<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="discussion" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
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

            <!-- Discussion Detail -->
            <?php if ($discussion): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><?= htmlspecialchars($discussion['title']) ?></h3>
                            <div class="text-muted small">
                                <i class="fas fa-eye"></i> <?= number_format($discussion['views']) ?> lượt xem
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($discussion['full_name']) ?>
                                    <i class="fas fa-calendar ms-3"></i> <?= date('d/m/Y H:i', strtotime($discussion['created_at'])) ?>
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <?php if ($discussion['movie_title']): ?>
                                    <small class="text-muted">
                                        <i class="fas fa-film"></i> Về phim: 
                                        <strong><?= htmlspecialchars($discussion['movie_title']) ?></strong>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="discussion-content">
                            <?= nl2br(htmlspecialchars($discussion['content'])) ?>
                        </div>
                        
                        <hr>
                        
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Lượt xem</small><br>
                                <strong><?= number_format($discussion['views']) ?></strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Bình luận</small><br>
                                <strong><?= number_format($discussion['comment_count']) ?></strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Thích</small><br>
                                <strong><?= number_format($discussion['like_count']) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="card">
                    <div class="card-header">
                        <h5>Bình luận (<?= count($comments) ?>)</h5>
                    </div>
                    <div class="card-body">
                        <!-- Add Comment Form -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="" class="mb-4">
                                <div class="form-group mb-3">
                                    <label for="comment">Thêm bình luận:</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3" 
                                              placeholder="Nhập bình luận của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi Bình Luận</button>
                            </form>
                            <hr>
                        <?php else: ?>                        <div class="alert alert-info mb-4">
                            <a href="login">Đăng nhập</a> để có thể bình luận trong thảo luận này.
                        </div>
                        <?php endif; ?>

                        <!-- Comments List -->
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong><?= htmlspecialchars($comment['full_name']) ?></strong>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted me-2">
                                                <?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?>
                                            </small>
                                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                                <a href="discussion/deleteComment/<?= $comment['id'] ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <h4>Không tìm thấy thảo luận</h4>
                    <p>Thảo luận bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
                    <a href="discussion" class="btn btn-primary">Quay lại danh sách thảo luận</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
