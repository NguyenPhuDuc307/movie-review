<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h1>Danh Sách Phim</h1>
    
    <!-- Hiển thị kết quả tìm kiếm -->
    <?php if (!empty($currentSearch) || !empty($currentGenre)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            Tìm thấy <strong><?= count($movies) ?></strong> phim
            <?php if (!empty($currentSearch)): ?>
                với từ khóa "<strong><?= htmlspecialchars($currentSearch) ?></strong>"
            <?php endif; ?>
            <?php if (!empty($currentGenre)): ?>
                <?php 
                $selectedGenre = '';
                foreach ($genres as $genre) {
                    if ($genre['id'] == $currentGenre) {
                        $selectedGenre = $genre['name'];
                        break;
                    }
                }
                ?>
                thuộc thể loại "<strong><?= htmlspecialchars($selectedGenre) ?></strong>"
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <?php if (!empty($movies)): ?>
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <?php if (!empty($movie['poster']) && file_exists(BASE_PATH . '/uploads/posters/' . $movie['poster'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/posters/<?= $movie['poster'] ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?>" 
                                 style="height: 300px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" 
                                 style="height: 300px;">
                                <div class="text-center">
                                    <i class="fas fa-film fa-3x mb-2"></i>
                                    <p class="mb-0">Không có poster</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                            <p class="card-text"><?= substr(htmlspecialchars($movie['description'] ?? ''), 0, 100) ?>...</p>
                            <p class="text-muted">
                                <small>
                                    Năm: <?= $movie['release_year'] ?> | 
                                    Thể loại: <?= htmlspecialchars($movie['genre_name'] ?? 'Chưa phân loại') ?>
                                </small>
                            </p>
                            <a href="<?= BASE_URL ?>/movie?id=<?= $movie['id'] ?>" class="btn btn-primary">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có phim nào trong hệ thống.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
