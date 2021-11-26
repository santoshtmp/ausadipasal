<?php include "db/sesson.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon"/>
  <title>Home AusadiPasal</title>
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="assets/css/home.css">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


  <nav class="navbar navbar-expand-sm navbar-dark bg-primary" aria-label="Third navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="home.php">Ausadi Pasal</a>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0">
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="inventory.php"><strong>Inventory</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="stock.php"><strong>Stock</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sales.php"><strong>Sales </strong> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="Card.php"><strong>Card</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="purchase.php" ><strong>Purchase</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dc/index.php"><strong>DC</strong></a>
          </li>
        </ul>
      </div>
       <a class="navbar-brand" href="user/index.php">  <img  class="profile-img" src="assets/img/avatar_2x.png" alt="user"> </a>
      <a class="navbar-brand" href="db/logout.php"> Log out </a>
    </div>
  </nav>
  <div id="main">
    <!--  ----------------  section ------------------ -->
    <section>
      <!-- section contents -->
      <div class="welcome">
        <h4>Welcome to ausadipasal</h4>
      </div>

      <div class="container">
        <img src="assets/img/gamesha-walpaper.jpg" alt="image-medicine" width="100%" height="600px">
      </div>
    </section>

    <!--  ----------------  footer ------------------ -->
    <footer>
      <p>Copyright © <?php echo date("Y"); ?> by ausadipasal</p>
    </footer>
  </div>

  <script type="text/javascript" src="assets/js/allCommon.js"></script>

</body>
</html>
