
<?php
require_once __DIR__ . '/../../lib.php';

?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Danh sách tài khoản</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active">Account List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Chức vụ</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT id, username, email, role, status FROM users"; 
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

              $statuses = [
                'pending' => [
                'label' => 'Chờ duyệt',
                'class' => 'text-warning',
                'icon'  => '<i class="bi bi-exclamation-circle-fill"></i>'
                ],
                'active' => [
                    'label' => 'Hoạt động',
                    'class' => 'text-success',
                    'icon'  => '<i class="bi bi-check-circle-fill"></i>'
                ],
                'banned' => [
                    'label' => 'Bị cấm',
                    'class' => 'text-danger',
                    'icon'  => '<i class="bi bi-x-circle-fill"></i>'
                ]

              ];

              $statusData = $statuses[$row['status']] ?? [
                  'label' => 'Không rõ',
                  'class' => 'text-secondary',
                  'icon'  => '<i class="bi bi-question-circle-fill"></i>'
              ];
          ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <?php
                switch ((int)$row['role']) {
                    case 1:
                    $roleText = 'Người tìm';
                    break;
                    case 2:
                    $roleText = 'Người thuê';
                    break;
                    case 999:
                    $roleText = 'Admin';
                    break;
                    default:
                    $roleText = 'Không rõ';
                }
            ?>
            <td><?= $roleText ?></td>

            
            <td class="<?= $statusData['class'] ?>">
              <?= $statusData['icon'] ?> <?= $statusData['label'] ?>
            </td>
            <td>
              <a href="home.php?page=edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
              <a href="db/delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">Xóa</a>
            </td>
          </tr>
          <?php
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>Không có tài khoản nào.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
