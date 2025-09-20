<?php
require_once __DIR__ . '/../../lib.php';

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $status = $_POST['status'];
    $owner_id = $_SESSION['user_id'] ?? null;

    $upload_ok = true;
    $file_name = null;
    $file_path = null;

    // Xử lý file đính kèm nếu có
    if (!empty($_FILES['attachment']['name'])) {
        $file = $_FILES['attachment'];
        $max_size = 3 * 1024 * 1024; // 3MB

        if ($file['size'] > $max_size) {
            $error = "Tệp vượt quá giới hạn 3MB.";
            $upload_ok = false;
        } else {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = basename($file["name"]);
            $file_path = $target_dir . time() . "_" . $file_name;

            if (!move_uploaded_file($file["tmp_name"], $file_path)) {
                $error = "Tải tệp lên không thành công.";
                $upload_ok = false;
            }
        }
    }

    if ($upload_ok && !$error && $owner_id && $title && $content) {
        $stmt = $conn->prepare("INSERT INTO post (title, content, status, owner_id, file_name, file_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $title, $content, $status, $owner_id, $file_name, $file_path);

        if ($stmt->execute()) {
            $success = "Bài viết đã được đăng.";
            echo "<script>alert('Đăng bài thành công!'); window.location.href = './home';</script>";
        } else {
            $error = "Lỗi khi đăng bài: " . $stmt->error;
        }
    } elseif (!$owner_id) {
        $error = "Bạn cần đăng nhập để đăng bài.";
    }
}
?>





<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Tạo bài viết</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active">Tạo bài viết</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="card p-4">
        <div class="mb-3">
          <label class="form-label">Tiêu đề</label>
          <input type="text" name="title" class="form-control" required value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Nội dung</label>
          <textarea name="content" class="form-control" rows="6" required><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Trạng thái</label>
          <select name="status" class="form-select" required>
            <option value="private" <?= (isset($_POST['status']) && $_POST['status'] === 'private') ? 'selected' : '' ?>>Riêng tư</option>
            <option value="public" <?= (isset($_POST['status']) && $_POST['status'] === 'puclic') ? 'selected' : '' ?>>Công khai</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Đính kèm tệp (tối đa 3MB)</label>
          <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
        </div>

        <button type="submit" class="btn btn-primary">Đăng bài</button>
        <a href="home.php?page=posts" class="btn btn-secondary">Hủy</a>
      </form>
    </div>
  </div>
</main>