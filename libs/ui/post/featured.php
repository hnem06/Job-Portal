<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../lib.php';

// -----------------
// 1. BÀI VIẾT NỔI BẬT (top 5 lượt xem)
// -----------------
$sql_featured = "SELECT post.*, users.username
        FROM post
        JOIN users ON post.owner_id = users.id
        WHERE post.status = 'public'
        ORDER BY post.view DESC
        LIMIT 5";
$result_featured = $conn->query($sql_featured);

// -----------------
// 2. BÀI VIẾT GẦN ĐÂY (có phân trang)
// -----------------
$limit = 8; // số bài viết trên 1 trang
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// tổng số bài viết (chỉ tính bài public)
$total_sql = "SELECT COUNT(*) as total FROM post WHERE status = 'public'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_posts = $total_row['total'];
$total_pages = ceil($total_posts / $limit);

// truy vấn bài viết gần đây
$sql_recent = "SELECT post.*, users.username
        FROM post
        JOIN users ON post.owner_id = users.id
        WHERE post.status = 'public'
        ORDER BY post.id DESC
        LIMIT $limit OFFSET $offset";
$result_recent = $conn->query($sql_recent);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài viết nổi bật</title>
  <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
<main class="app-main">
  <div class="container my-4">
    <!-- BÀI VIẾT NỔI BẬT -->
    <h3 class="mb-3">🔥 Bài viết nổi bật</h3>
    <div class="row">
      <?php while($row = $result_featured->fetch_assoc()): ?>
        <div class="col-md-6 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5> <br>
              <p class="card-text"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 120))) ?>...</p>
              <p><small class="text-muted">👤 <?= htmlspecialchars($row['username']) ?> | 👁 <?= $row['view'] ?> lượt xem</small></p>
              <a href="home.php?page=view_post&id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- BÀI VIẾT GẦN ĐÂY -->
    <h3 class="mt-5 mb-3">🆕 Bài viết gần đây</h3>
    <div class="row">
      <?php while($row = $result_recent->fetch_assoc()): ?>
        <div class="col-md-6 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5> <br>
              <p class="card-text"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</p>
              <p><small class="text-muted">👤 <?= htmlspecialchars($row['username']) ?> | 👁 <?= $row['view'] ?> lượt xem</small></p>
              <a href="home.php?page=view_post&id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- PHÂN TRANG -->
    <nav>
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?page=<?= $page-1 ?>">« Trước</a></li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
          <li class="page-item"><a class="page-link" href="?page=<?= $page+1 ?>">Sau »</a></li>
        <?php endif; ?>
      </ul>
    </nav>

  </div>
</main>
</body>
</html>
