<?php
include __DIR__ . '/../partials/menu.php';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/DetailTourStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>
    <main class="container my-4 d-flex gap-4">
        <div class="content card">
            <div id="carouselExample" class="carousel slide mx-auto my-3 custom-carousel">
                <div class="carousel-inner h-100">
                    <?php if (!empty($tourImages) && is_array($tourImages)): ?>
                        <?php foreach ($tourImages as $idx => $img): ?>
                            <?php
                            if (!empty($img['image'])) {
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mime = $finfo->buffer($img['image']);
                                if (strpos($mime, 'image/') === 0) {
                                    $imgData = base64_encode($img['image']);
                                    $src = 'data:' . $mime . ';base64,' . $imgData;
                                } else {
                                    $src = '';
                                }
                            } else {
                                $src = '';
                            }
                            ?>
                            <div class="carousel-item<?php echo $idx === 0 ? ' active' : ''; ?>">
                                <?php if ($src): ?>
                                    <img src="<?php echo $src; ?>" class="d-block w-100 h-100 custom-carousel-img" alt="Tour Image">
                                <?php else: ?>
                                    <div class="text-center text-danger">Không có ảnh hợp lệ</div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <div class="text-center text-warning">Chưa có ảnh cho tour này.</div>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="book-info w-100 d-flex flex-column align-items-center">
            <div class="card p-3 w-100 mb-2 d-flex">
                <p class="mb-0">Giá chỉ từ</p>
                <span class="d-flex align-items-baseline" style="gap: 4px;">
                    <span class="fw-bold text-primary self-align-center" style="font-size: 1.4rem;">
                        <?php echo number_format($tour['price_default'], 0, ',', '.') . 'đ'; ?>
                    </span>
                    <span style="color: #888; font-size: 1rem; opacity: 0.8;">/Người</span>
                </span>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Đặt Tour</button>
                    <button class="btn btn-secondary"><i class="fa-solid fa-heart"
                            style="color: #f40808ff;"></i></button>
                </div>
            </div>

            <div class="card p-3 w-100 text-center">
                <h6>Cần hỗ trợ?</h6>
                <p class="mb-0">Gọi ngay cho chúng tôi để được tư vấn miễn phí</p>
                <p class="fw-bold text-primary self-align-center m-0" style="font-size: 1.4rem;">1900 1234</p>
            </div>
        </div>
    </main>
</body>

<?php
include __DIR__ . '/../partials/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>