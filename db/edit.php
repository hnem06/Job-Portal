<?php
require_once __DIR__ . '/../libs/lib.php'; 

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Tài khoản không tồn tại.');
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
        header("Location: account_list.php?updated=1");
        exit();
    } else {
        $error = "Cập nhật thất bại: " . $conn->error;
    }
}
?>