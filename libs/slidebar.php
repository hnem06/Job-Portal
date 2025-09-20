


<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./home.php" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="assets/img/logo.png"
              alt="Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">JobPortal</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="home.php" class="nav-link <?php if (!isset($_GET['page']) || $_GET['page'] === 'home') echo 'active'; ?>">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Trang chủ</p>
                </a>
              </li>
              <?php

              include(__DIR__ . './lib.php');

              if ($chucvu == 999 || $chucvu == 2):
              ?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-pencil-square"></i>
                  <p>
                    Bài viết
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="home.php?page=list_post" class="nav-link">
                      <p>Quản lí các bài viết</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="home.php?page=create_post" class="nav-link">
                      <p>Tạo mới bài viết</p>
                    </a>
                  </li>
                </ul>
              </li>
              <?php endif ?>
              
              <?php
                if ($chucvu == 999):
              ?>
              <li class="nav-header">Quản trị viên</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-person-circle"></i>
                  <p>
                    Hệ thống
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="home.php?page=list_usr" class="nav-link">
                      <p>Quản lí tài khoản</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="home.php?page=list_post" class="nav-link">
                      <p>Quản lí bài viết</p>
                    </a>
                  </li>
                </ul>
              </li>

              <?php endif ?>

              
              <li class="nav-header">Tài Khoản</li>
              <li class="nav-item">
                <a href="home.php?page=myinfo" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'info') echo 'active'; ?>">
                  <i class="nav-icon bi bi-person-circle"></i>
                  <p>Thông tin tài khoản</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./db/logout.php" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-in-right"></i>
                  <p>
                    Đăng xuất
                  </p>
                </a>
              </li>

              <li class="nav-header">Tài liệu</li>
              <li class="nav-item">
                <a href="./docs/how-to-contribute.html" class="nav-link">
                  <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                  <p>Đóng góp</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/faq.html" class="nav-link">
                  <i class="nav-icon bi bi-question-circle-fill"></i>
                  <p>FAQ</p>
                </a>
              </li>
              
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>