<?php
    require_once __DIR__ . '/../../lib.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    die("Thiếu ID bài viết.");
}

$stmt = $conn->prepare("SELECT * FROM post WHERE id = ? AND owner_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Không tìm thấy bài viết.");
}

$post = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE post SET title = ?, content = ?, status = ? WHERE id = ? AND owner_id = ?");
    $stmt->bind_param("sssii", $title, $content, $status, $post_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công'); window.location.href='home.php?page=my_posts';</script>";
        exit;
    } else {
        $error = "Lỗi cập nhật.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa bài viết</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Sửa bài viết</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($post['title']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="public" <?= $post['status'] === 'public' ? 'selected' : '' ?>>Công khai</option>
                <option value="private" <?= $post['status'] === 'private' ? 'selected' : '' ?>>Riêng tư</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="home.php?page=list_post" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>
