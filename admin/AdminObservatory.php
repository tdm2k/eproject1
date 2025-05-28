<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Xử lý form bài viết nếu được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['post_title'] ?? '';
    $content = $_POST['post_content'] ?? '';
    $imageUrl = $_POST['image_url'] ?? '';

    $newPost = [
        'title' => $title,
        'content' => $content,
        'image_url' => $imageUrl,
        'created_at' => date('Y-m-d H:i')
    ];

    $_SESSION['observatory_posts'][] = $newPost;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Observatory</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .main-page-content {
            margin-left: 280px;
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <main class="flex-grow-1 p-4">
            <h1 class="mb-4">Observatory Dashboard</h1>
            <p>Giám sát và quản lý các thiết bị và hoạt động tại đài quan sát vũ trụ Space Dot Com.</p>

            <!-- Nút thêm bài viết -->
            <div class="mb-4">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addPostForm" aria-expanded="false" aria-controls="addPostForm">
                    <i class="bi bi-plus-circle"></i> Thêm bài viết
                </button>

                <div class="collapse mt-3" id="addPostForm">
                    <div class="card card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Tiêu đề bài viết</label>
                                <input type="text" class="form-control" id="postTitle" name="post_title" required>
                            </div>

                            <div class="mb-3">
                                <label for="postContent" class="form-label">Nội dung</label>
                                <textarea class="form-control" id="postContent" name="post_content" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="imageUrl" class="form-label">URL ảnh</label>
                                <input type="url" class="form-control" id="imageUrl" name="image_url" required>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-send"></i> Gửi bài viết
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hiển thị bài viết đã thêm -->
            <?php if (!empty($_SESSION['observatory_posts'])): ?>
                <div class="mb-4">
                    <h4 class="mb-3">Bài viết đã đăng</h4>
                    <?php foreach (array_reverse($_SESSION['observatory_posts']) as $post): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong><?= htmlspecialchars($post['title']) ?></strong> - <?= $post['created_at'] ?>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($post['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="Hình ảnh bài viết" class="img-fluid mb-3" style="max-height: 300px;">
                                <?php endif; ?>
                                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Thiết bị quan sát -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-binoculars"></i> Thiết bị quan sát
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Kính thiên văn Alpha:</strong> Hoạt động</li>
                        <li><strong>Kính thiên văn Beta:</strong> Đang bảo trì</li>
                        <li><strong>Máy đo quang phổ:</strong> Hoạt động</li>
                        <li><strong>Thiết bị ghi nhận sóng vô tuyến:</strong> Đang cập nhật dữ liệu</li>
                    </ul>
                </div>
            </div>

            <!-- Lịch sử quan sát -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-clock-history"></i> Lịch sử quan sát gần đây
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Ngày</th>
                                <th>Thiết bị</th>
                                <th>Vật thể quan sát</th>
                                <th>Thời lượng</th>
                                <th>Kết quả sơ bộ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025-05-20</td>
                                <td>Kính thiên văn Alpha</td>
                                <td>Jupiter</td>
                                <td>3 giờ</td>
                                <td>Ảnh rõ ràng, nhiều vệt khí</td>
                            </tr>
                            <tr>
                                <td>2025-05-18</td>
                                <td>Máy đo quang phổ</td>
                                <td>Sao Betelgeuse</td>
                                <td>2 giờ</td>
                                <td>Dữ liệu phổ thu thập đầy đủ</td>
                            </tr>
                            <tr>
                                <td>2025-05-15</td>
                                <td>Kính thiên văn Beta</td>
                                <td>Sao Hỏa</td>
                                <td>1.5 giờ</td>
                                <td>Một phần mờ do mây</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-line"></i> Thống kê tổng quan
                </div>
                <div class="card-body">
                    <p><strong>Số lần quan sát trong tháng:</strong> 12</p>
                    <p><strong>Thiết bị hoạt động:</strong> 3/4</p>
                    <p><strong>Thời gian quan sát trung bình:</strong> 2.2 giờ/lần</p>
                </div>
            </div>
        </main>
    </div>

    <div>
        <?php include('../admin/includes/AdminFooter.php'); ?>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
