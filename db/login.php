<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // sql inject
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>
                alert('Tên đăng nhập hoặc mật khẩu không đúng.');
                window.history.back();
            </script>";
        exit();
    }

    $user = $result->fetch_assoc();

    // Check password
    if (!password_verify($password, $user['password'])) {
        echo "<script>
                alert('Tên đăng nhập hoặc mật khẩu không đúng.');
                window.history.back();
            </script>";
        exit();
    }


    $id = $user['id'];

    $collect = "SELECT * FROM users WHERE id = '$id'";
    $result_collect = mysqli_query($conn, $collect);

    $data = mysqli_fetch_array($result_collect);
    $status = $data['status'];


    // KT Xác thực người dùng
    if ($status == 'pending') {
        echo "<script>
                alert('Tài khoản chưa được xác nhận, vui lòng kiểm tra email ( có thể trong phần thư rác )');
                window.history.back();
            </script>";
        exit();
    } else if ($status == 'banned') {
        echo "<script>
                alert('Tài khoản của bạn bị khoá do có hành vi bất thường. Vui lòng liên hệ cho quản trị viên dể giải quyết.');
                window.history.back();
            </script>";
        exit();
    } else if ($status == 'active') {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }

    
    // Record ip 
    $ip = $_SERVER['REMOTE_ADDR'];

    // Kiểm tra xem ip đã tồn tại trong bảng visits chưa
    $checkSql = "SELECT id FROM visits WHERE ip_address = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $ip);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        // Chưa có -> insert
        $insertSql = "INSERT INTO visits (ip_address, visited_at) VALUES (?, NOW())";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("s", $ip);
        $insertStmt->execute();
        $insertStmt->close();
    } else {
        // Đã có -> update thời gian truy cập gần nhất
        $updateSql = "UPDATE visits SET visited_at = NOW() WHERE ip_address = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("s", $ip);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $checkStmt->close();

    header("Location: ../home");
    exit();


} else {
    echo "Mày vào đây rình ai tắm ???";
}