<?php 

include "dcdb.php";

$obj = new queryDC();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>DC AusadiPasal</title>
  <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="../assets/css/footer.css">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">  

</head>
<body>
	<nav class="navbar navbar-expand-sm navbar-dark bg-primary" aria-label="Third navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="../home.php">Ausadi Pasal</a>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0">
          <li class="nav-item">
            <a class="nav-link" href="../inventory.php"><strong>Inventory</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../stock.php"><strong>Stock</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../sales.php"><strong>Sales</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../Card.php"><strong>Card</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../purchase.php" ><strong>Purchase</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"><strong>DC</strong></a>
          </li>
        </ul>
      </div>
      <a class="navbar-brand active" href="../user/index.php">  <img  class="profile-img" src="../assets/img/avatar_2x.png" alt="user"> </a>
      <a class="navbar-brand" href="../db/logout.php"> Log out </a>
    </div>
  </nav>
  <div id="main">
  	<!--  ----------------  section ------------------ -->
  <section>
  </section>

  	 <!--  ----------------  footer ------------------ -->
  <footer>
    <p>Copyright © <?php echo date("Y"); ?>  by ausadipasal</p>
  </footer>
  </div>	
  <!--------------------------------- js link ------------------------->
  <script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js" ></script>
  <script src="../assets/js/jquery-3.6.0.js" ></script>

</body>
</html>