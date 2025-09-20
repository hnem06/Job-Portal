<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../lib.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'];

// Nếu admin (999) -> lấy tất cả, ngược lại chỉ lấy bài viết của chính mình
if ($role == 999) {
    $sql = "SELECT post.*, users.username
            FROM post
            JOIN users ON post.owner_id = users.id
            ORDER BY post.id DESC";
} else {
    $sql = "SELECT post.*, users.username
            FROM post
            JOIN users ON post.owner_id = users.id
            WHERE post.owner_id = ?
            ORDER BY post.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($role == 999) {
    $result = $conn->query($sql);
}

if (!$result) {
    die("Query error: " . $conn->error);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Quản lý bài viết</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Quản lý bài viết</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active">Bài viết</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Tiêu đề</th>
            <th>Tác giả</th>
            <th>Lượt xem</th>
            <th>Trạng thái</th>
            <th>File đính kèm</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          
          <?php if (!$result) {
                    die("Query error: " . $conn->error);
                } while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= $row['view'] ?></td>
              <td><?= ($row['status'] === 'public') ? 'Công khai' : 'Riêng tư' ?></td>
              <td>
                <?php if (!empty($row['file_path'])): ?>
                  <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">Xem file</a>
                <?php else: ?>
                  Không có
                <?php endif; ?>
              </td>
              <td>
                <a href="home.php?page=edit_post&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a href="db/delete_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này?')">Xoá</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
</body>
</html>
