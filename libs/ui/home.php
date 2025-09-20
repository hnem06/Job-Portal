<!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            
<?php

include(__DIR__ . '/../lib.php');

if ($chucvu == 999 || $chucvu == 2):
?>


            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Home</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                  <!-- <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                  -->
                </ol>
              </div>
              </div>
            <!--end::Row-->
            </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            
            <?php include __DIR__ . '/dashboard.php'; ?>

            <!--begin::Row-->
            
              <!--begin::Col-->

              <!--end::Col-->
              <!--end::Col-->
            
            <!--end::Row-->
            <!--begin::Row-->
            
            
<?php endif
?>

            <div class="row">
             <!-- <div class="col-sm-6"><h3 class="mb-0">Bài viết nổi bật</h3></div>

             
              
              </div>
               end::Row--> <?php include 'libs/ui/post/featured.php'; ?>
            </div>

<!-- /.row (main row) -->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->