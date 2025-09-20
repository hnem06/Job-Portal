<?php
require_once __DIR__ . '/../lib.php';

$user_id = $_SESSION['user_id'];


if (!$row_in4) {
    $row_in4 = [
        'url_avt' => '',
        'url_cv' => '',
        'fullname' => '',
        'sdt' => '',
        'cur_location' => '',
        'hometown' => '',
        'status' => '',
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = __DIR__ . '/../../uploads/avatars/';
    $webPathPrefix = 'uploads/avatars/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['url_avt']) && $_FILES['url_avt']['error'] === UPLOAD_ERR_OK) {
        $avtName = 'avt_' . $user_id . '_' . time() . '.' . pathinfo($_FILES['url_avt']['name'], PATHINFO_EXTENSION);
        $avtPath = $uploadDir . $avtName;
        move_uploaded_file($_FILES['url_avt']['tmp_name'], $avtPath);
        $avtUrl = 'uploads/avatars/' . $avtName;
    } else {
        $avtUrl = $row_in4['url_avt'];
    }

    if (isset($_FILES['url_cv']) && $_FILES['url_cv']['error'] === UPLOAD_ERR_OK) {
        $cvName = 'cv_' . $user_id . '_' . time() . '.pdf';
        $cvPath = $uploadDir . $cvName;
        move_uploaded_file($_FILES['url_cv']['tmp_name'], $cvPath);
        $cvUrl = 'uploads/avatars/' . $cvName;
    } else {
        $cvUrl = $row_in4['url_cv'];
    }

    $fullname = $_POST['fullname'];
    $sdt = $_POST['sdt'];
    $cur_location = $_POST['cur_location'];
    $hometown = $_POST['hometown'];

    $updateStmt = $conn->prepare("UPDATE information SET fullname=?, sdt=?, cur_location=?, hometown=?, url_avt=?, url_cv=?, status='pending' WHERE id=?");
    $updateStmt->bind_param("ssssssi", $fullname, $sdt, $cur_location, $hometown, $avtUrl, $cvUrl, $user_id);
    $updateStmt->execute();

    echo "<script>alert('Update thành công, vui lòng chờ admin phê duyệt.'); window.location.href = './home?page=account';</script>";
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Thông tin tài khoản</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active">Account</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Ảnh đại diện:</label><br>
            <?php if ($row_in4['url_avt']): ?>
              <img src="<?= htmlspecialchars($row_in4['url_avt']) ?>" width="150" class="mb-2 rounded">
            <?php else: ?>
              <p class="text-muted">Chưa có ảnh</p>
            <?php endif; ?>
            <input type="file" name="url_avt" accept="image/*" class="form-control mt-2">
            <br>
            <label class="">CV (PDF):</label>
            <?php if ($row_in4['url_cv']): ?>
              <a href="<?= htmlspecialchars($row_in4['url_cv']) ?>" target="_blank" class="d-block mb-2">Xem CV hiện tại</a>
            <?php endif; ?>
            <input type="file" name="url_cv" accept=".pdf" class="form-control">
          </div>

          <div class="col-md-8">
            <label>Họ và tên:</label>
            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($row_in4['fullname']) ?>" required>

            <label class="mt-3">Số điện thoại:</label>
            <input type="text" name="sdt" class="form-control" value="<?= htmlspecialchars($row_in4['sdt']) ?>">

            <label class="mt-3">Nơi ở hiện tại:</label>
            <input type="text" name="cur_location" class="form-control" value="<?= htmlspecialchars($row_in4['cur_location']) ?>">

            <label class="mt-3">Quê quán:</label>
            <input type="text" name="hometown" class="form-control" value="<?= htmlspecialchars($row_in4['hometown']) ?>">
          </div>
        </div>

        <?php
        $statuses = [
            'pending' => [
                'label' => 'Chờ duyệt',
                'class' => 'text-warning',
                'icon'  => '<i class="bi bi-exclamation-circle-fill"></i>'
            ],
            'approved' => [
                'label' => 'Đã duyệt',
                'class' => 'text-success',
                'icon'  => '<i class="bi bi-check-circle-fill"></i>'
            ],
            'rejected' => [
                'label' => 'Bị từ chối',
                'class' => 'text-danger',
                'icon'  => '<i class="bi bi-x-circle-fill"></i>'
            ]
        ];

        $statusData = $statuses[$row_in4['status']] ?? [
            'label' => 'Không rõ',
            'class' => 'text-secondary',
            'icon'  => '<i class="bi bi-question-circle-fill"></i>'
        ];
        ?>

        <label class="mt-3">Trạng thái:</label>
        <span class="<?= $statusData['class'] ?>">
            <?= $statusData['icon'] ?> <?= $statusData['label'] ?>
        </span>
        <br><br>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
      </form>
    </div>
  </div>
</main>
