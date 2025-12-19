<div class="card menu menu-card" style="flex: 0 0 20%;">
    <div class="card-body p-3">
        <h5 class="card-title mb-3">Quản lý</h5>
        <ul class="menu-list">
            <li class="menu-item mb-1 <?= $currentPage === 'tour' ? 'active' : '' ?>">
                <i class="fa-solid fa-map"></i>
                <a href="<?= route('tour.index'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý tour</a>
            </li>
            <li class="menu-item mb-1 <?= $currentPage === 'destination' ? 'active' : '' ?>">
                <i class="fa-solid fa-location-dot"></i>
                <a href="<?= route('destination.index'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý điểm đến</a>
            </li>
            <li class="menu-item mb-1 <?= $currentPage === 'itinerary' ? 'active' : '' ?>">
                <i class="fa-solid fa-route"></i>
                <a href="<?= route('itinerary.index'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý lịch trình</a>
            </li>
            <li class="menu-item mb-1 <?= $currentPage === 'booking' ? 'active' : '' ?>">
                <i class="fa-solid fa-calendar-check"></i>
                <a href="<?= route('booking.index'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý booking</a>
            </li>
            <li class="menu-item mb-1 <?= $currentPage === 'service' ? 'active' : '' ?>">
                <i class="fa-solid fa-concierge-bell"></i>
                <a href="<?= route('service.index'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý dịch vụ</a>
            </li>
            <li class="menu-item <?= $currentPage === 'user' ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i>
                <a href="<?= route('user.index'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý user</a>
            </li>
        </ul>
    </div>
</div>