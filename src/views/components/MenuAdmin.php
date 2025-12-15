<?php
include __DIR__ . '/../partials/menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin</title>
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
     <link rel="stylesheet" href="css/AppStyle.css">
     <link rel="stylesheet" href="css/SettingAccount.css">
</head>
<body>
     <div class="container-fluid my-4">
          <div class="d-flex gap-4 px-5">
               <div class="card menu menu-card" style="flex: 0 0 20%;">
                    <div class="card-body p-3">
                         <ul class="menu-list">
                              <li class="menu-item mb-1 active">
                                   <i class="fa-solid fa-map"></i>
                                   <a href="#" class="text-decoration-none flex-grow-1 menu-link" data-section="tour" style="color: inherit;">Admin</a>
                              </li>
                              <li class="menu-item mb-1">
                                   <i class="fa-solid fa-map"></i>
                                   <a href="#" class="text-decoration-none flex-grow-1 menu-link" data-section="tour" style="color: inherit;">Quản Lý Tour</a>
                              </li>
                              <li class="menu-item mb-1">
                                   <i class="fa-solid fa-route"></i>
                                   <a href="#" class="text-decoration-none flex-grow-1 menu-link" data-section="itinerary" style="color: inherit;">Quản Lý Lịch Trình</a>
                              </li>
                              <li class="menu-item mb-1">
                                   <i class="fa-solid fa-calendar-check"></i>
                                   <a href="#" class="text-decoration-none flex-grow-1 menu-link" data-section="booking" style="color: inherit;">Quản Lý Booking</a>
                              </li>
                              <li class="menu-item mb-1">
                                   <i class="fa-solid fa-users"></i>
                                   <a href="#" class="text-decoration-none flex-grow-1 menu-link" data-section="user" style="color: inherit;">Quản Lý Người Dùng</a>
                              </li>
                              <li class="menu-item mb-1">
                                   <i class="fa-solid fa-concierge-bell"></i>
                                   <a href="#" class="text-decoration-none flex-grow-1 menu-link" data-section="service" style="color: inherit;">Quản Lý Dịch Vụ</a>
                              </li>
                         </ul>
                    </div>
               </div>

               <div class="card" style="flex: 0 0 calc(80% - 1rem);">
                    <div class="card-body">
                         <div id="admin-content">
                         <!-- Nội dung sẽ được load ở đây -->
                         <h2>Chào mừng đến trang Admin</h2>
                         <p>Chọn một chức năng từ menu bên trái.</p>
                         </div>
                    </div>
               </div>
          </div>
     </div>

</body>

<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
     document.addEventListener('DOMContentLoaded', function() {
          const menuItems = document.querySelectorAll('.menu-link');
          const contentDiv = document.getElementById('admin-content');

          menuItems.forEach(item => {
               item.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Remove active class from all li
                    document.querySelectorAll('.menu-item').forEach(li => li.classList.remove('active'));
                    // Add active to parent li
                    this.closest('.menu-item').classList.add('active');
                    const section = this.getAttribute('data-section');
                    loadContent(section);
               });
          });

          function loadContent(section) {
               const routeMap = {
                    'index': 'admin.index',
                    'tour': 'admin.tour',
                    'itinerary': 'admin.itinerary',
                    'booking': 'admin.booking',
                    'user': 'admin.user',
                    'service': 'admin.service'
               };
               const routeName = routeMap[section];
               if (routeName) {
                    fetch(`<?= route('admin.tour') ?>`.replace('admin.tour', routeName))
                         .then(response => response.text())
                         .then(html => {
                              contentDiv.innerHTML = html;
                         })
                         .catch(error => {
                              contentDiv.innerHTML = '<p>Lỗi khi tải nội dung.</p>';
                         });
               } else {
                    contentDiv.innerHTML = '<h2>Chào mừng đến trang Admin</h2><p>Chọn một chức năng từ menu bên trái.</p>';
               }
          }
     });
</script>

</html>