    </main>
    
    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-light">
                        <i class="bi bi-film text-danger"></i> MovieReview
                    </h5>
                    <p class="mb-0">Nền tảng chia sẻ và thảo luận về phim hàng đầu Việt Nam.</p>
                    <p>Khám phá, đánh giá và thảo luận về những bộ phim yêu thích của bạn.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-light">Liên Kết</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo URLHelper::home(); ?>" class="text-decoration-none text-secondary">Trang Chủ</a></li>
                        <li><a href="<?php echo URLHelper::movies(); ?>" class="text-decoration-none text-secondary">Phim</a></li>
                        <li><a href="<?php echo URLHelper::discussions(); ?>" class="text-decoration-none text-secondary">Thảo Luận</a></li>
                        <li><a href="<?php echo URLHelper::about(); ?>" class="text-decoration-none text-secondary">Giới Thiệu</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-light">Hỗ Trợ</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo URLHelper::help(); ?>" class="text-decoration-none text-secondary">Trợ Giúp</a></li>
                        <li><a href="<?php echo URLHelper::contact(); ?>" class="text-decoration-none text-secondary">Liên Hệ</a></li>
                        <li><a href="<?php echo URLHelper::privacy(); ?>" class="text-decoration-none text-secondary">Chính Sách</a></li>
                        <li><a href="<?php echo URLHelper::terms(); ?>" class="text-decoration-none text-secondary">Điều Khoản</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: var(--border-color);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 MovieReview. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small>Được phát triển với ❤️ bằng PHP & MySQL</small>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
