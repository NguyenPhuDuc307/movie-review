<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="row">
    <!-- Sidebar Profile Info -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <!-- Avatar -->
                <div class="mb-3">
                    <?php if ($user['avatar']): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/avatars/<?php echo $user['avatar']; ?>" 
                             class="rounded-circle mb-3" 
                             width="120" height="120" 
                             style="object-fit: cover; border: 3px solid var(--accent-color);"
                             alt="Avatar">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 120px; height: 120px; border: 3px solid var(--accent-color);">
                            <i class="bi bi-person-fill" style="font-size: 3rem; color: var(--text-secondary);"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h4 class="text-primary"><?php echo htmlspecialchars($user['full_name']); ?></h4>
                <p class="text-muted">@<?php echo htmlspecialchars($user['username']); ?></p>
                
                <?php if ($user['role'] === 'admin'): ?>
                    <span class="badge bg-danger mb-3">
                        <i class="bi bi-shield-check"></i> Quản Trị Viên
                    </span>
                <?php else: ?>
                    <span class="badge bg-primary mb-3">
                        <i class="bi bi-person"></i> Thành Viên
                    </span>
                <?php endif; ?>
                
                <p class="text-muted">
                    <small>
                        <i class="bi bi-calendar"></i>
                        Tham gia: <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                    </small>
                </p>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-graph-up"></i> Thống Kê Hoạt Động
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h5 class="text-primary mb-1"><?php echo $userStats['reviews']; ?></h5>
                            <small class="text-muted">Reviews</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h5 class="text-success mb-1"><?php echo $userStats['discussions']; ?></h5>
                        <small class="text-muted">Thảo luận</small>
                    </div>
                    <div class="col-6">
                        <div class="border-end">
                            <h5 class="text-info mb-1"><?php echo $userStats['comments']; ?></h5>
                            <small class="text-muted">Bình luận</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="text-warning mb-1"><?php echo $userStats['likes_received']; ?></h5>
                        <small class="text-muted">Lượt thích</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" 
                        type="button" role="tab" aria-controls="overview" aria-selected="true">
                    <i class="bi bi-grid"></i> Tổng Quan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" 
                        type="button" role="tab" aria-controls="reviews" aria-selected="false">
                    <i class="bi bi-star"></i> Reviews của tôi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="discussions-tab" data-bs-toggle="tab" data-bs-target="#discussions" 
                        type="button" role="tab" aria-controls="discussions" aria-selected="false">
                    <i class="bi bi-chat-dots"></i> Thảo luận
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" 
                        type="button" role="tab" aria-controls="settings" aria-selected="false">
                    <i class="bi bi-gear"></i> Cài đặt
                </button>
            </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content" id="profileTabsContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <!-- Recent Reviews -->
                <?php if (!empty($recentReviews)): ?>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi bi-star"></i> Reviews Gần Đây
                        </h6>
                        <a href="#" onclick="showTab('reviews-tab')" class="btn btn-sm btn-outline-primary">
                            Xem Tất Cả
                        </a>
                    </div>
                    <div class="card-body">
                        <?php foreach ($recentReviews as $review): ?>
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0 me-3">
                                <?php if ($review['movie_poster']): ?>
                                    <img src="<?php echo BASE_URL; ?>/uploads/posters/<?php echo $review['movie_poster']; ?>" 
                                         class="rounded" width="60" height="90" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 90px;">
                                        <i class="bi bi-film text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="<?php echo BASE_URL; ?>/movie?id=<?php echo $review['movie_id']; ?>" 
                                       class="text-decoration-none text-primary">
                                        <?php echo htmlspecialchars($review['movie_title']); ?>
                                    </a>
                                </h6>
                                <div class="rating-stars mb-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?php echo $i <= $review['rating'] ? '-fill' : ''; ?> text-warning"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-muted mb-1"><?php echo htmlspecialchars($review['title']); ?></p>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> 
                                    <?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Recent Discussions -->
                <?php if (!empty($recentDiscussions)): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi bi-chat-dots"></i> Thảo Luận Gần Đây
                        </h6>
                        <a href="#" onclick="showTab('discussions-tab')" class="btn btn-sm btn-outline-primary">
                            Xem Tất Cả
                        </a>
                    </div>
                    <div class="card-body">
                        <?php foreach ($recentDiscussions as $discussion): ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <h6 class="mb-1">
                                <a href="<?php echo BASE_URL; ?>/discussion?id=<?php echo $discussion['id']; ?>" 
                                   class="text-decoration-none text-primary">
                                    <?php echo htmlspecialchars($discussion['title']); ?>
                                </a>
                            </h6>
                            <?php if ($discussion['movie_title']): ?>
                                <p class="text-muted mb-1">
                                    <i class="bi bi-film"></i> 
                                    <?php echo htmlspecialchars($discussion['movie_title']); ?>
                                </p>
                            <?php endif; ?>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> 
                                <?php echo date('d/m/Y H:i', strtotime($discussion['created_at'])); ?>
                                <span class="ms-2">
                                    <i class="bi bi-eye"></i> <?php echo $discussion['views']; ?> lượt xem
                                </span>
                            </small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-star"></i> Tất Cả Reviews (<?php echo $userStats['reviews']; ?>)
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentReviews)): ?>
                            <?php foreach ($recentReviews as $review): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <?php if ($review['movie_poster']): ?>
                                                <img src="<?php echo BASE_URL; ?>/uploads/posters/<?php echo $review['movie_poster']; ?>" 
                                                     class="rounded" width="80" height="120" style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 120px;">
                                                    <i class="bi bi-film text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-2">
                                                <a href="<?php echo BASE_URL; ?>/movie?id=<?php echo $review['movie_id']; ?>" 
                                                   class="text-decoration-none text-primary">
                                                    <?php echo htmlspecialchars($review['movie_title']); ?>
                                                </a>
                                            </h5>
                                            <div class="rating-stars mb-2">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="bi bi-star<?php echo $i <= $review['rating'] ? '-fill' : ''; ?> text-warning"></i>
                                                <?php endfor; ?>
                                                <span class="ms-2 text-muted"><?php echo $review['rating']; ?>/5</span>
                                            </div>
                                            <h6 class="mb-2"><?php echo htmlspecialchars($review['title']); ?></h6>
                                            <p class="text-muted mb-2">
                                                <?php echo htmlspecialchars(substr($review['content'], 0, 200)) . '...'; ?>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-clock"></i> 
                                                    <?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?>
                                                </small>
                                                <span class="badge bg-<?php echo $review['status'] === 'approved' ? 'success' : ($review['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                                                    <?php echo $review['status'] === 'approved' ? 'Đã duyệt' : ($review['status'] === 'pending' ? 'Chờ duyệt' : 'Bị từ chối'); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-star text-muted" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-muted">Chưa có review nào</h5>
                                <p class="text-muted">Hãy bắt đầu viết review cho phim yêu thích của bạn!</p>
                                <a href="<?php echo BASE_URL; ?>/movies" class="btn btn-primary">
                                    <i class="bi bi-collection-play"></i> Khám Phá Phim
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Discussions Tab -->
            <div class="tab-pane fade" id="discussions" role="tabpanel" aria-labelledby="discussions-tab">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-chat-dots"></i> Thảo Luận Của Tôi (<?php echo $userStats['discussions']; ?>)
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentDiscussions)): ?>
                            <?php foreach ($recentDiscussions as $discussion): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="mb-2">
                                        <a href="<?php echo BASE_URL; ?>/discussion?id=<?php echo $discussion['id']; ?>" 
                                           class="text-decoration-none text-primary">
                                            <?php echo htmlspecialchars($discussion['title']); ?>
                                        </a>
                                    </h5>
                                    <?php if ($discussion['movie_title']): ?>
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-film"></i> 
                                            Về phim: <strong><?php echo htmlspecialchars($discussion['movie_title']); ?></strong>
                                        </p>
                                    <?php endif; ?>
                                    <p class="mb-2">
                                        <?php echo htmlspecialchars(substr($discussion['content'], 0, 200)) . '...'; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> 
                                            <?php echo date('d/m/Y H:i', strtotime($discussion['created_at'])); ?>
                                        </small>
                                        <div>
                                            <span class="badge bg-info me-2">
                                                <i class="bi bi-eye"></i> <?php echo $discussion['views']; ?> lượt xem
                                            </span>
                                            <span class="badge bg-<?php echo $discussion['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                <?php echo $discussion['status'] === 'active' ? 'Đang hoạt động' : 'Đã đóng'; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-muted">Chưa có thảo luận nào</h5>
                                <p class="text-muted">Hãy bắt đầu tạo topic thảo luận về phim!</p>
                                <a href="<?php echo BASE_URL; ?>/discussions" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tạo Thảo Luận
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Settings Tab -->
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-gear"></i> Cài Đặt Tài Khoản
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <!-- Basic Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" 
                                           value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                            </div>
                            
                            <!-- Avatar Upload -->
                            <div class="mb-4">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                <div class="form-text">Chấp nhận JPG, PNG, GIF. Tối đa 2MB.</div>
                            </div>
                            
                            <hr>
                            
                            <!-- Change Password -->
                            <h6 class="mb-3">Thay Đổi Mật Khẩu</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" minlength="6">
                                </div>
                                <div class="col-md-4">
                                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Cập Nhật Thông Tin
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-danger" onclick="confirmDeleteAccount()">
                                        <i class="bi bi-trash"></i> Xóa Tài Khoản
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabId) {
    var triggerEl = document.getElementById(tabId);
    var tab = new bootstrap.Tab(triggerEl);
    tab.show();
}

function confirmDeleteAccount() {
    if (confirm('Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác!')) {
        // Redirect to delete account action
        window.location.href = '<?php echo BASE_URL; ?>/delete-account';
    }
}

// Form validation for password change
document.querySelector('form').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword && newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
    }
});
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
