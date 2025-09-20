<?php
require_once __DIR__ . '/../lib.php';

$id = $_GET['id'] ?? 0;
$id = intval($id); 

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Không tìm thấy tài khoản.');
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE users SET username = ?, email = ?, role = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $username, $email, $role, $status, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Chỉnh sửa thành công!'); window.location.href = './home?page=list';</script>";
    } else {
        $error = "Cập nhật thất bại: " . $conn->error;
    }
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Chỉnh sửa tài khoản</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="home.php?page=list">Account List</a></li>
            <li class="breadcrumb-item active">Edit Account</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" class="card p-4">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($user['username']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Người tìm</option>
            <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Người thuê</option>
            <option value="999" <?= $user['role'] == 999 ? 'selected' : '' ?>>Admin</option>
        </select>

        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="pending" <?= $user['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
            <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="banned" <?= $user['status'] === 'banned' ? 'selected' : '' ?>>Bị cấm</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="home.php?page=list_usr" class="btn btn-secondary">Hủy</a>
      </form>
    </div>
  </div>
</main>
