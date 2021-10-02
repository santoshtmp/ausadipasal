<?php 
include "db/sesson.php";
include "db/database.php";
$obj = new query();
$page_name='Stock List';
$result_stockList=$obj->getStockList();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stock AusadiPasal</title>
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
</head>
<body>

  <nav class="navbar navbar-expand-sm navbar-dark bg-primary" aria-label="Third navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="home.php">Ausadi Pasal</a>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="inventory.php"><strong>Inventory</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="stock.php"><strong>Stock</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="sales.php"><strong>Sales</strong></a>
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
      <div class="container">
        <div class="flex-container">
          <div class="itemflex">
            <h4 id='page_name'><?php echo $page_name; ?></h4>
          </div>
          <?php 
            if ($page_name=='Stock List') {
               echo"<div class='inv-pag-info'  id='page-info'> Item Quantity-QYT less then 30</div>";
            }
          ?>
        </div>
    <hr>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Code</th>
          <th scope="col">Items Name</th>
          <th>QYT</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $sno=0;

        if ($result_stockList) {
          foreach($result_stockList as $rows=>$row){
            $sno=$sno+1;
            echo "<tr class='stock_list'>
            <td>".$sno."</th>
            <td>".$row['code']."</td>
            <td>".$row['item_name']."</td>
            <td id='qyt'>".$row['qyt']."</td>
            </tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</section>

<!--  ----------------  footer ------------------ -->
<footer>
  <p>Copyright © 2021 by ausadipasal</p>
</footer>
</div>
<!--------------------------------- js link ------------------------->
<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js" ></script>
<script src="assets/js/jquery-3.6.0.js" ></script>
<script src="assets/js/dataTables.min.js"></script>
<script type="text/javascript" src="assets/js/stock.js"></script>

</body>
</html>

