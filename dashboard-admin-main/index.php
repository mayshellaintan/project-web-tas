<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard | Tas Wanita</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/fonts/tabler-icons.min.css">
</head>

<body>
  <!-- [ Sidebar Menu ] start -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="index.php?page=dashboard" class="b-brand text-primary">
          <img src="./assets/images/logo-icon.svg" class="img-fluid logo-lg" alt="logo">
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">

          <li class="pc-item">
            <a href="index.php?page=dashboard" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="index.php?page=produk" class="pc-link">
              <span class="pc-micon"><i class="ti ti-shopping-bag"></i></span>
              <span class="pc-mtext">Produk</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="index.php?page=kategori" class="pc-link">
              <span class="pc-micon"><i class="ti ti-category"></i></span>
              <span class="pc-mtext">Kategori</span>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <?php
      // switch case untuk memanggil halaman
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch ($page) {
          case 'produk':
            include './admin-page/produk.php';
            break;

          case 'kategori':
            include './admin-page/kategori.php';
            break;

          default:
            include './admin-page/dashboard.php';
            break;
        }
      } else {
        include './admin-page/dashboard.php';
      }
      ?>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <p class="m-0">© 2025 Tas Wanita | All Rights Reserved</p>
    </div>
  </footer>

  <script src="./assets/js/plugins/bootstrap.min.js"></script>
  <script src="./assets/js/pcoded.js"></script>
</body>
</html>
