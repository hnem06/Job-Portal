<div class="row">

<?php 

include(__DIR__ . '/../lib.php');


$count_posts = 0;

// count post uploaded
if ($_SESSION['role'] == 999) {
    $sql = "SELECT COUNT(*) as total FROM post";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count_posts = $row['total'];
} else {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM post WHERE owner_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $count_posts = $row['total'];
}

if ($chucvu == 999 || $chucvu == 2):
?>
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                  <div class="inner">
                    <h3><?= $count_posts ?></h3>
                    <p>Bài viết đã đăng</p>
                  </div>
                  <a
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Xem thêm <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 1-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3>0<sup class="fs-5">%</sup></h3>
                    <p>Tỉ lệ tương tác</p>
                  </div>
  
                  <a
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Xem thêm <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
<?php endif ?>

<?php 
if ($chucvu == 999):
?>
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                  <div class="inner">
                    <h3><?php echo $cnt_user; ?></h3>
                    <p>Tổng số tài khoản trên hệ thống</p>
                  </div>
                  
                  <a
                    href="#"
                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Xem thêm <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 3-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 4-->
                <div class="small-box text-bg-danger">
                  <div class="inner">
                    <h3><?php include(__DIR__ . '/../../db/cnt.php'); ?></h3>
                    <p>Số lượng người dùng ghé thăm website hôm nay</p>
                  </div>
                  
                  <a
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Xem thêm <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 4-->
              </div>
<?php endif ?>

</div>



<?php 

if ($chucvu == 999 || $chucvu == 2):
?>
<div class="row">
              <!-- Start col -->
              <div class="col-lg-7 connectedSortable">
                <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">Biểu đồ chi tiết</h3></div>
                  <div class="card-body"><div id="revenue-chart"></div></div>
                </div>
              </div>
              
              <!-- /.Start col -->
            </div>

<?php endif ?>