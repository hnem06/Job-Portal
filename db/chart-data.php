<?php
$conn = new mysqli("localhost", "root", "", "job_portal_ofc");
$conn->set_charset("utf8");

// get view and interest in month
$sql = "
    SELECT 
        DATE_FORMAT(viewed_at, '%Y-%m') AS month,
        COUNT(*) AS views, 
        COUNT(DISTINCT user_id) AS interests
    FROM post_views
    GROUP BY DATE_FORMAT(viewed_at, '%Y-%m')
    ORDER BY month ASC
";

$result = $conn->query($sql);

$categories = [];
$views = [];
$interests = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row["month"] . "-01"; 
    $views[] = (int)$row["views"];
    $interests[] = (int)$row["interests"];
}

$data = [
    "categories" => $categories,
    "views" => $views,
    "interests" => $interests
];

echo json_encode($data);
