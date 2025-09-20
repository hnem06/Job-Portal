<?php
require_once __DIR__ . '/../libs/lib.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; 

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Xoá thành công!'); window.location.href = '../home?page=list';</script>";
        exit();
    } else {
        echo "Xoá thất bại: " . $conn->error;
    }
} else {
    echo "";
}
