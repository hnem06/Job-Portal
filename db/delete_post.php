<?php
session_start();
require_once __DIR__ . '/../libs/lib.php';

// Login checkk
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$post_id = (int) ($_GET['id'] ?? 0);
if ($post_id <= 0) {
    die("ID không hợp lệ!");
}

// Lấy thông tin bài viết
$stmt = $conn->prepare("SELECT owner_id, file_path FROM post WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bài viết không tồn tại!");
}

$post = $result->fetch_assoc();

// Check permission
if ($_SESSION['role'] != 999 && $_SESSION['user_id'] != $post['owner_id']) {
    die("Bạn không có quyền xoá bài viết này!");
}


// Delete
if (!empty($post['file_path']) && file_exists($post['file_path'])) {
    unlink($post['file_path']);
}
$stmt = $conn->prepare("DELETE FROM post WHERE id = ?");
$stmt->bind_param("i", $post_id);

if ($stmt->execute()) {
    header("Location: ../home.php?page=list_post");
    exit;
} else {
    die("Lỗi khi xoá bài viết: " . $conn->error);
}