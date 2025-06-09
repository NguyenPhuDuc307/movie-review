<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tạo Thảo Luận Mới</h4>
                </div>
                <div class="card-body">
                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="<?php echo BASE_URL; ?>/discussion" class="btn btn-outline-secondary">
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

                    <!-- Create Discussion Form -->
                    <form method="POST" action="<?php echo BASE_URL; ?>/discussion/create">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Tiêu đề thảo luận <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Nhập tiêu đề thảo luận..."
                                value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                                required maxlength="200">
                            <div class="form-text">Tối đa 200 ký tự</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="movie_id" class="form-label">Phim liên quan (tùy chọn)</label>
                            <select name="movie_id" id="movie_id" class="form-control">
                                <option value="">-- Chọn phim (nếu có) --</option>
                                <?php if (isset($movies) && !empty($movies)): ?>
                                    <?php foreach ($movies as $movie): ?>
                                        <option value="<?= $movie['id'] ?>"
                                            <?= ($_POST['movie_id'] ?? '') == $movie['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($movie['title']) ?> (<?= $movie['release_year'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Chọn phim nếu thảo luận của bạn liên quan đến một bộ phim cụ thể</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Nội dung thảo luận <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="8"
                                placeholder="Viết nội dung thảo luận của bạn..."
                                required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                            <div class="form-text">
                                Hãy viết chi tiết về chủ đề bạn muốn thảo luận.
                                Có thể bao gồm cảm nhận, phân tích, câu hỏi...
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Lưu ý:</h6>
                                <ul class="mb-0">
                                    <li>Hãy đảm bảo nội dung thảo luận phù hợp và không vi phạm quy định</li>
                                    <li>Sử dụng ngôn ngữ lịch sự và tôn trọng người khác</li>
                                    <li>Tránh spoiler mà không có cảnh báo trước</li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="discussion" class="btn btn-secondary me-md-2">Hủy</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tạo Thảo Luận
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Guidelines Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6><i class="fas fa-lightbulb"></i> Gợi ý tạo thảo luận hay</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Chủ đề thú vị:</h6>
                            <ul>
                                <li>Phân tích nhân vật trong phim</li>
                                <li>So sánh phim gốc và remake</li>
                                <li>Thảo luận về kết thúc phim</li>
                                <li>Chia sẻ easter egg đã phát hiện</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Cách viết hiệu quả:</h6>
                            <ul>
                                <li>Đặt câu hỏi mở để khuyến khích thảo luận</li>
                                <li>Chia sẻ quan điểm cá nhân</li>
                                <li>Cung cấp bối cảnh cần thiết</li>
                                <li>Sử dụng spoiler tag khi cần</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Create discussion page specific fixes */
    .container * {
        color: #f0f6fc !important;
    }

    .text-muted,
    .small.text-muted {
        color: #8b949e !important;
    }

    h2,
    h3,
    h4,
    h5,
    h6 {
        color: #f0f6fc !important;
    }

    .form-label {
        color: #f0f6fc !important;
    }

    .form-text {
        color: #8b949e !important;
    }

    .form-control {
        background-color: #21262d !important;
        border: 1px solid #30363d !important;
        color: #f0f6fc !important;
    }

    .form-control::placeholder {
        color: #8b949e !important;
    }

    .btn {
        color: white !important;
    }

    .btn-primary {
        background-color: #238636 !important;
        border-color: #238636 !important;
        color: #ffffff !important;
    }

    .btn-primary:hover {
        background-color: #2ea043 !important;
        border-color: #2ea043 !important;
        color: #ffffff !important;
    }

    .btn-outline-secondary {
        color: #8b949e !important;
        border-color: #30363d !important;
        background-color: transparent !important;
    }

    .btn-outline-secondary:hover {
        color: #ffffff !important;
        background-color: #30363d !important;
        border-color: #30363d !important;
    }

    .alert-info {
        background-color: #1e3a5f !important;
        color: #58a6ff !important;
        border-left: 4px solid #58a6ff !important;
    }

    .card {
        background-color: #161b22 !important;
        border: 1px solid #30363d !important;
    }

    .card-header {
        background-color: #161b22 !important;
        border-bottom: 1px solid #30363d !important;
        color: #f0f6fc !important;
    }

    .card-body {
        background-color: #161b22 !important;
        color: #f0f6fc !important;
    }
</style>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>