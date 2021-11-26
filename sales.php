<?php 
include "db/sesson.php"; 
include "db/database.php";
$obj = new query();
$obj2 = new SalesItem();
$detail_all=array();
$result_itemName=0;
$update=false;
$SalesList='Sales List';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['idEditph']) AND isset($_POST['idEditinv'])) {  
    $id_ph = $_POST['idEditph'];
    $id_inv = $_POST['idEditinv'];
    $editQYT = $_POST["editQYT"];
    $editMRP = $_POST["editMRP"]; 
    $editItemNam = $_POST["editItemNam"];
    $arr_inv=array(
      "inv_id"=>$id_inv,
      "ph_id"=>$id_ph,
      "item_name"=>$editItemNam,
      "card"=>'1',
      "mrp"=>$editMRP,
      "qyt"=>$editQYT,
      "total_mrp"=>$editMRP*$editQYT
    );
    $result=$obj->insertData('sales',$arr_inv);
    if ($result) {
      echo "<script> alert('Record added to card');</script>";
    }else {
      echo "<script> alert(' !!!!!!  sorry record is not entered......');</script>";
    }
  }
  elseif(isset($_POST['itemName'])){
    $inputItem = $_POST["itemName"];
    $result_itemName=$obj2->getInvItemData($inputItem);
    if ($result_itemName) {
      $SalesList='Add Sales List';
    }else{
      $SalesList='Record Cannot be found';
    }
    
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sales AusadiPasal</title>
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="assets/css/sales.css">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
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
            <a class="nav-link active" href="sales.php"><strong>Sales</strong></a>
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
    <!-- ----------- Add To Card   modal ----------------------- -->
    <div class="modal fade" id="addSalesModal" tabindex="-1" aria-labelledby="addSalesModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addSalesModal">Add To Card</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="sales.php" method="POST">
              <input type="hidden" name="idEditph" id="idEditph">
              <input type="hidden" name="idEditinv" id="idEditinv">
              <input type="hidden" name="editItemNam" id="editItemNam">
              <input type="hidden" name="editMRP" id="editMRP">
              <div id="inputField">
                <label> QYT <p style="color:red;margin-top: 1rem;">MAX-QYT : <spam id="maxqytval"></spam></p></label> 
                <input type="number" class="form-control" id="editQYT" name="editQYT" min="0" required>
              </div>
              <div style="margin-top:10px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Add To Card</button>
              </div>
            </form>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>
    <!--  ----------------  section ------------------ -->
    <section>
      <div class="container">
        <div class="flex-container">
          <div class="itemflex">
            <h4><?php
                if ($SalesList=='Record Cannot be found') {
                 echo "<spam style='color:red;font-weight:bold'>".$SalesList."</spam>"; 
              }else{
                 echo $SalesList; 
              }
             ?></h4>
          </div>
          <div class="itemflex">
            <form action="sales.php" method="POST"  autocomplete="off">
              <label>Enter Item Name</label>
              <input list="itemNameList" name="itemName" id="itemName" type='text' required> 
              <datalist id="itemNameList" >
                <?php 
                $obj_itemName=$obj2->getInvItemName();
                if ($obj_itemName) {
                  foreach($obj_itemName as $key=>$val){
                    echo"<option value='";?><?php echo $val; ?><?php echo "'>".$val."</option>";
                  }
                }
                ?>
              </datalist>
              <button type="submit" class='btn btn-sm btn-primary'>
                <strong>+ Add Sales Item</strong>
              </button>
            </form>
          </div>
        </div>
        <hr style="height: 2px;">
        <div>
         <?php
         $sno=0;
         if ($result_itemName){ 
          echo " 
          <table class='table' id='myTable'>
          <thead>
          <tr>
          <th>S.No</th>
          <th>Entry Date</th>
          <th>Bill No</th>
          <th>Code</th>
          <th>Items</th>
          <th>Batch No</th>
          <th>Exp Date</th>
          <th>MRP</th>
          <th>QYT</th>
          <th>Action</th>
          </tr>
          </thead>
          <tbody>";
          foreach($result_itemName as $rows=>$row){
            $sno=$sno+1;
            $iddd=$row['id'].'/'.$row['inv_id'];
             $cardQYTarr=$obj2->getCardQyt($row['id']);
             $cardQYT=0;
            if($cardQYTarr){
              foreach ($cardQYTarr as $key => $value) {
                $cardQYT=$cardQYT+$value;
              }
              $iddd=$iddd.'-'.$cardQYT;
            }
            echo "<tr>
            <td>".$sno."</td>
            <td>".$row['date']."</td>
            <td>".$row['bill_no']."</td>
            <td>".$row['code']."</td>
            <td>".$row['item_name']."</td>
            <td>".$row['batch_no']."</td>
            <td>".$row['expire_date']."</td>
            <td>".$row['mrp']."</td>
            <td>".$row['qyt']."</td>
            <td>
            <button class='sales btn btn-sm btn-primary' id=".$iddd.">Select </button> 
            </td>
            </tr>";
          }
          echo"</tbody>
          </table>
          ";
        }else{
          echo "
          <table class='table' id='myTable'>
          <thead>
          <tr>
          <th>S.No</th>
          <th>Sales Date</th>
          <th>Customer Name</th>
          <th>Item Name</th>
          <th>Total Amount</th>
          <th>Disount Percent</th>
          <th>Net Amount</th>
          <th>More Detail</th>
          </tr>
          </thead>
          <tbody>
          ";
          $result=$obj->getData('card_processed_sale');
          $sno=0;
          if ($result) {
            foreach($result as $rows=>$row){
              $sno=$sno+1;
              $arr_sales_id = explode(",",$row['all_sales_item_id']);
              $sales_item_name='';
              
              $detail_each=array();
              $detail_each_card=array();
              foreach($arr_sales_id as $key=>$value){
                $sales_data=$obj2->getSalesDataCard0($value);
                if ($sales_data) {
                  if ($sales_item_name=='') {
                    $sales_item_name=$sales_data['item_name'];
                  }else{
                    $sales_item_name=$sales_item_name.",   ";
                    $sales_item_name=$sales_item_name.$sales_data['item_name'];
                  }
                }
                $detail=array();
                $detail['item_name']=$sales_data['item_name'];
                $detail['qyt']=$sales_data['qyt'];
                $detail['mrp']=$sales_data['mrp'];
                $detail['total_mrp']=$sales_data['total_mrp'];

                $detail_each[]=$detail;
              }
              $detail_each_card['detail_each']=$detail_each;
              $detail_each_card['customer_name']=$row["customer_name"];
              $detail_each_card['total_amo']=$row["total_amo"];
              $detail_each_card['disount_percent']=$row["disount_percent"];
              $detail_each_card['total_net_amo']=$row["total_net_amo"];

              $detail_all[]=$detail_each_card;

              echo "<tr>
              <td id='sno'>".$sno."</td>
              <td>".explode(" ",$row['process_date'])[0]."</td>
              <td>".$row['customer_name']."</td>
              <td>".$sales_item_name."</td>
              <td>".$row['total_amo']."</td>
              <td>".$row['disount_percent']."</td>
              <td>".$row['total_net_amo']."</td>
              <td>
              <button class='btn btn-sm btn-primary' id='details'> <strong value='".$sno."'> Detail <strong></button>
              </td>
              </tr>";

            }
          }
          echo"
          </tbody>
          </table>
          ";
        }  
        ?>
      </div>
      <div class="detail-card">
        <?php
        $num=0;
        foreach ($detail_all as $key => $detail_each_card) {
          $num=$num+1;
          echo'
          <!-- ----------- each item detail modal ----------------------- -->
          <div class="modal fade" id="detailsModal'.$num.'" tabindex="-1" aria-labelledby="detailsModal" aria-hidden="true">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="detailsModal">Detail</h5>
          <button class="btn btn-primary" style="margin-left:auto;" onClick="printContent('.$num.')" >Print</button>
          <button type="button" style="margin-left: 2rem;"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="table-'.$num.'">
          <table class="modal-table">
          <thead>
          <tr>
          <th colspan="3">MEDISMART PHARAM</th>
          <th colspan="2">PAN NO : 612483510</th>
          </tr>
          <tr>
          <th>S.No</th>
          <th>Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Total Price</th>
          </tr>
          </thead>
          <tbody>';
          $sno=0;
          foreach ($detail_each_card['detail_each'] as $key => $detail_each) {
           $sno=$sno+1;
           echo"
           <tr>
           <td>".$sno."</td>
           <td>".$detail_each['item_name']."</td>
           <td>".$detail_each['qyt']."</td>
           <td>".$detail_each['mrp']."</td>
           <td>".$detail_each['total_mrp']."</td>
           <tr>
           ";
         }

         echo'
         <tr>
         <td colspan="4" style="text-align: center;">Total Amount</td>
         <td id="grand_total">'.$detail_each_card["total_amo"].'</td>
         </tr>
         <tr>
         <td colspan="4" style="text-align: center;">Discount %</td>
         <td style="text-align: center;">'.$detail_each_card["disount_percent"].' </td>
         </tr>
         <tr>
         <td colspan="4" style="text-align: center;">Total Net Amount</td>
         <td id="net_total">'.$detail_each_card["total_net_amo"].'</td>
         </tr>
         </tbody>
         </table>
         <div>
             <P style="margin-top:10px; text-align:center;">Customer Name : '.$detail_each_card["customer_name"].'</p>
         </div>
         </div>
         </div>
         </div>
         </div>
         ';
       }
       ?>
     </div>
   </div>

 </section>

 <!--  ----------------  footer ------------------ -->
 <footer>
  <p>Copyright © <?php echo date("Y"); ?>  by ausadipasal</p>
</footer>

</div>
<!--------------------------------- js link ------------------------->
<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js" ></script>
<script src="assets/js/jquery-3.6.0.js" ></script>
<script src="assets/js/dataTables.min.js"></script>
<script type="text/javascript" src="assets/js/add_edit_data_table.js"></script>
<script type="text/javascript" src="assets/js/sales.js"></script>
</body>
</html>

