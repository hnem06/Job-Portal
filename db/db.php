<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "job_portal_ofc";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


?>