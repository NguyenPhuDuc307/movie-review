<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-danger">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h1 class="display-1 fw-bold text-danger">404</h1>
                    <h3 class="mb-3">Trang Không Tồn Tại</h3>
                    <p class="lead text-muted mb-4">
                        Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                            <i class="bi bi-house"></i> Về Trang Chủ
                        </a>
                        <a href="<?php echo BASE_URL; ?>/movies" class="btn btn-outline-light">
                            <i class="bi bi-collection-play"></i> Xem Phim
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Quay Lại
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Suggestions -->
            <div class="mt-4">
                <h5 class="mb-3">Có thể bạn quan tâm:</h5>
                <div class="list-group list-group-flush">
                    <a href="<?php echo BASE_URL; ?>" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                        <i class="bi bi-house me-2"></i> Trang chủ
                    </a>
                    <a href="<?php echo BASE_URL; ?>/movies" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                        <i class="bi bi-collection-play me-2"></i> Danh sách phim
                    </a>
                    <a href="<?php echo BASE_URL; ?>/discussions" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                        <i class="bi bi-chat-dots me-2"></i> Thảo luận
                    </a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>/register" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="bi bi-person-plus me-2"></i> Đăng ký tài khoản
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
