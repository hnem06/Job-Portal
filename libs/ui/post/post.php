<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../lib.php';

// Kiểm tra ID hợp lệ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID bài viết không hợp lệ.");
}
$post_id = (int)$_GET['id'];

// Nếu đã đăng nhập thì check xem đã view chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Kiểm tra user đã từng xem bài này chưa
    $stmt = $conn->prepare("SELECT id FROM post_views WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result_check = $stmt->get_result();

    if ($result_check->num_rows === 0) {
        // Chưa có -> thêm mới
        $stmt_insert = $conn->prepare("INSERT INTO post_views (post_id, user_id) VALUES (?, ?)");
        $stmt_insert->bind_param("ii", $post_id, $user_id);
        $stmt_insert->execute();

        // Cập nhật view +1
        $conn->query("UPDATE post SET view = view + 1 WHERE id = $post_id");
    }
}

// Lấy thông tin bài viết
$sql = "SELECT post.*, users.username, information.fullname
        FROM post
        JOIN users ON post.owner_id = users.id
        LEFT JOIN information ON users.id = information.id
        WHERE post.id = $post_id AND post.status = 'public'";

$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Bài viết không tồn tại hoặc không công khai.");
}

$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($post['title']) ?> - Chi tiết bài viết</title>
  <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
<main class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2> <br>
      <p class="text-muted">
        👤 Tác giả: <?= htmlspecialchars($post['fullname'] ?? $post['username']) ?> 
        | 👁 <?= $post['view'] ?> lượt xem
      </p>
      <hr>
      <p class="card-text" style="white-space: pre-line;">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
      </p>
      <?php if (!empty($post['file_path'])): ?>
        <p>📎 <a href="<?= htmlspecialchars($post['file_path']) ?>" target="_blank">Xem file đính kèm</a></p>
      <?php endif; ?>
      <a href="home.php?page=featured_post" class="btn btn-secondary mt-3">← Quay lại</a>
    </div>
  </div>
</main>
</body>
</html>
