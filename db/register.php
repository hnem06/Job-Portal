<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $role = intval($_POST['role']); // 1: người tìm việc, 2: người thuê, 999: admin

    if (empty($username) || empty($password) || empty($email)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.'); window.history.back();</script>";
        exit();
    }

    // sql inject
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);

    // enc pass
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        echo "<script>
                alert('Tên đăng nhập hoặc email đã tồn tại. Vui lòng thử lại.');
                window.history.back();
            </script>";
        
    } else {
        $stmt->close();
        
        
        $insert_sql = "INSERT INTO users (username, password, email, role) 
                    VALUES ('$username', '$hashed_password', '$email', $role)";

        
        
        if ($conn->query($insert_sql) === TRUE) {
            $created_at = date('Y-m-d H:i:s'); 
            $user_id = $conn->insert_id;

            $url_avt = 'uploads/avatars/default.jpg';

            $insert_sql2 = "INSERT INTO information (id, created_at)
                                VALUES ('$user_id', '$created_at')";
                      
            $conn->query($insert_sql2);

            echo "<script>alert('Đăng ký thành công! Hãy đăng nhập.'); window.location.href = '../home';</script>";
        } else {
            echo "<script>alert('Lỗi khi đăng ký: " . $conn->error . "'); window.history.back();</script>";
        }

    }

    $conn->close();

} else {
    echo "Mày vào đây rình ai tắm ???";
}

?>