<div class="col-md-3">
    <div class="card bg-dark">
        <div class="card-header bg-dark text-light">
            <h5 class="mb-0"><i class="fas fa-cog"></i> Admin Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="<?= URLHelper::adminDashboard() ?>" 
               class="list-group-item list-group-item-action list-group-item-dark <?= $current_page == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="<?= URLHelper::adminMovies() ?>" 
               class="list-group-item list-group-item-action list-group-item-dark <?= $current_page == 'movies' ? 'active' : '' ?>">
                <i class="fas fa-film"></i> Quản lý Phim
            </a>
            <a href="<?= URLHelper::adminUsers() ?>" 
               class="list-group-item list-group-item-action list-group-item-dark <?= $current_page == 'users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Quản lý Users
            </a>
            <a href="<?= URLHelper::adminReviews() ?>" 
               class="list-group-item list-group-item-action list-group-item-dark <?= $current_page == 'reviews' ? 'active' : '' ?>">
                <i class="fas fa-star"></i> Quản lý Reviews
            </a>
            <div class="dropdown-divider bg-secondary"></div>
            <a href="<?= BASE_URL ?>" class="list-group-item list-group-item-action list-group-item-dark">
                <i class="fas fa-arrow-left"></i> Về trang chủ
            </a>
        </div>
    </div>
</div>
