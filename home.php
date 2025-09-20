<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}


include 'libs/lib.php';
include 'libs/head.php';
?>



<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <?php include 'libs/header.php' ?>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <?php include 'libs/slidebar.php' ?>
      <!--end::Sidebar-->
            
      <!--begin::App Main-->
      <?php
        $page = $_GET['page'] ?? 'home';
        switch ($page) {
            case 'myinfo':
                include 'libs/ui/myin4.php';
                break;
            case 'list_usr':
                include 'libs/ui/user/list.php';
                break;
            case 'edit':
                include 'libs/ui/edit.php';
                break;

            case 'create_post':
                include 'libs/ui/post/create.php';
                break;
            case 'list_post':
                include 'libs/ui/post/list.php';
                break;
            case 'edit_post':
                include 'libs/ui/post/edit.php';
                break;
            case 'featured_post':
                include 'libs/ui/post/featured.php';
                break;
            case 'view_post':
                include 'libs/ui/post/post.php';
                break;
            
            
            case 'home':
            default:
                include 'libs/ui/home.php';
                break;
        }
      ?>

      <!--end::App Main
      -->
      <!--begin::Footer-->
      <?php include 'libs/footer.php'; ?>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>
    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
fetch("chart-data.php")
  .then(res => res.json())
  .then(data => {
    const options = {
      series: [
        {
          name: 'Lượt xem',
          data: data.views
        },
        {
          name: 'Lượt quan tâm',
          data: data.interests
        }
      ],
      chart: {
        height: 300,
        type: 'area',
        toolbar: { show: false }
      },
      legend: { show: false },
      colors: ['#0d6efd', '#20c997'],
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth' },
      xaxis: {
        type: 'datetime',
        categories: data.categories
      },
      tooltip: {
        x: { format: 'MMMM yyyy' }
      }
    };

    const chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
    chart.render();
  });
</script>
   
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
