<?php

include(__DIR__ . '/../db/db.php');



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$id = $_SESSION['user_id'];

$collect_user = "SELECT * FROM users WHERE id = '$id'";
$collect_in4 = "SELECT * FROM information WHERE id = '$id'";

$result_collect_user = mysqli_query($conn, $collect_user);
$result_collect_inf = mysqli_query($conn, $collect_in4);


$data = mysqli_fetch_array($result_collect_user);
$data_usr = mysqli_fetch_array($result_collect_inf);

$chucvu = $data['role'];
$usrname = $data['username'];

$date_created = $data_usr["created_at"];


$sql_count = "SELECT COUNT(*) AS tong_users FROM users";
$result_cnt = $conn->query($sql_count);
$row = $result_cnt->fetch_assoc();

$cnt_user = $row['tong_users'];

$stmt_call_information = $conn->prepare("SELECT * FROM information WHERE id = ?");
$stmt_call_information->bind_param("i", $id);
$stmt_call_information->execute();
$result_in4 = $stmt_call_information->get_result();
$row_in4 = $result_in4->fetch_assoc();

if ($row_in4['fullname'] === null) {
    $ten_hien_thi = $usrname;
} else {
    $ten_hien_thi = $row_in4['fullname'];
}

?>