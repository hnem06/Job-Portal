<?php
include 'db.php';

$sql = "SELECT COUNT(*) as cnt 
        FROM visits 
        WHERE DATE(visited_at) = CURDATE()";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo $row['cnt'];
?>
