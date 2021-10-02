<?php 
include "db/sesson.php";
include "db/database.php";
$obj = new query();
$result_expList=0;
$today_date=0;
$return_exp=0;
$result_expListReturn=0;
$page_name="Inventory List";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['exp_list'])) {
    $result_expList=$obj->getExpiredList();
    if (!$result_expList) {
      echo "<script> alert(' !!!!!!  No Data in Expired date list');</script>";
    }else{
      $page_name="Inventory : Expired List";
      $today_date=date("Y-m-d");
    }
  }
  if (isset($_POST['return_exp_list'])) {
      $result_expListReturn=$obj->getExpListReturn();
      if(!$result_expListReturn){
        echo "<script> alert(' !!!!!!  No Data in Return Expired date list OR Error....');</script>";
      }else{
        $page_name="Return Expired List";
        $return_exp="1";
      }
  }

  if (isset($_POST['return'])) { 
      $id=$_POST['return'];
      $arr=array();
      $date=date("Y-m-d");
      $arr['return_exp']='1';
      $arr['return_date']=$date;
      $result_return=$obj->updateData('inventory',$arr,'id',$id);
      if($result_return){
        $page_name="Inventory : Expired List";
        $today_date=date("Y-m-d");
        echo "<script> alert(' Sucessfully return Expired Data..');</script>";
      }else{
          $page_name="Inventory : Expired List";
          $today_date=date("Y-m-d");
          echo "<script> alert(' !!!!!!  sorry Expired Data is not return..... ');</script>";
      }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory AusadiPasal</title>
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
            <a class="nav-link active" aria-current="page" href="inventory.php"><strong>Inventory</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="stock.php"><strong>Stock</strong></a>
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
            <h4><?php echo $page_name; ?></h4>
          </div>
          <?php 
            if ($page_name=='Inventory : Expired List'){
              echo"<div class='inv-pag-info'> Today Date : ".$today_date."</div>";
            }
          ?>
          <div class="itemflex exp-stock">
          <form action="inventory.php" method="POST">
            <?php
            if ($page_name=='Inventory : Expired List'){
              echo '<button type="submit" name="return_exp_list" value="return_exp_list" style="color:white;background-color: #f44336;border: #f44336;" class="btn deletePurchase">Return Exp List</button>';
            }else{
                echo ' <button type="submit" name="exp_list" value="exp_list" class="btn btn-primary">Expired List</button>';
            }
             ?>
        </form> 
      </div>
    </div>
    <hr style="height: 2px;">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Code</th>
          <th scope="col">Items Name</th>
          <th>Batch No</th>
          <th>Exp Date</th>
          <th>MRP</th>
          <th>QYT</th>
          <?php 
            if ($page_name=='Inventory : Expired List'){
                echo '<th>Action</th>';
            }
            if ($page_name=='Return Expired List') {
               echo"<th>Return Date</th>";
            }
          ?>
        </tr>
      </thead>
      <tbody>
       
        <?php
        $result=0;
         $class_tr='';
        if ($result_expList) {
          $result=$result_expList;
          $class_tr='expired_list';
        }
        elseif ($result_expListReturn) {
          $result=$result_expListReturn;
        }
        else{
          $result=$obj->getInvData();
        }
        
        $sno=0;

        if ($result) {
            
            foreach($result as $rows=>$row){
                $sno=$sno+1;
                echo "<tr class=".$class_tr.">
                    <td>".$sno."</td>
                    <td>".$row['code']."</td>
                    <td>".$row['item_name']."</td>
                    <td>".$row['batch_no']."</td>
                    <td>".$row['expire_date']."</td>
                    <td>".$row['mrp']."</td>
                    <td>".$row['qyt']."</td>";
                if ($page_name=='Inventory : Expired List'){
                    echo '<td>
                             <form action="inventory.php" method="POST"">
                            <button type="submit" style="color:white;background-color: #f44336;border: #f44336;" class="btn deletePurchase" id='.$row['id'].' name="return" value='.$row['id'].'>Return</button>
                             </form>
                        </td>';
                }
                if ($page_name=='Return Expired List') {
                    echo"<td>".$row['return_date']."</td>";
                }
                echo "</tr>";
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
<script type="text/javascript" src="assets/js/add_edit_data_table.js"></script>

</body>
</html>

