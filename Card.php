<?php 
include "db/sesson.php";
include "db/database.php";
$obj = new query();
$obj2 = new SalesItem();
$obj_card_proc_upd = new CardProcessInvUpd();
$result_cardProcess_return=0;
$result_salesDone_return=0;
$result_updateInv_return=0;
$result_cancelProcess=0;
$result_editSalesProcess=0;
if (isset($_GET['delete'])) {
  $sno=$_GET['delete'];
  $arr=array(
      'id'=>$sno
  );
  $result=$obj->deleteData('sales',$arr);
  if ($result) {
    $delete=true;
  }else {
    echo "!!!!The record has not been deleted id :".$sno."  <br>";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit_sales'])) {
    if ($_POST['cardProcess']=='1') {
      $all_sales_item_id = $_POST["all_sales_item_id"];
      $total_amo = $_POST["total_amo"];
      $disount_percent = $_POST["disount_percent"];
      $total_net_amo = $_POST["total_net_amo"];
      $arr=array(
        "all_sales_item_id"=>$all_sales_item_id,
        'total_amo'=>$total_amo,
        "disount_percent"=>$disount_percent,
        "total_net_amo"=>$total_net_amo
      );
      if (isset($_POST['customer_name'])) {
        $arr["customer_name"]=$_POST['customer_name'];
      } 
      $result_cardProcess=$obj->insertData('card_processed_sale',$arr);
      $result_salesDone=$obj->salesDoneAddTocard_processed_sale($all_sales_item_id);
      $result_updateInv=$obj_card_proc_upd->updateInvPhQWhenCardProc($all_sales_item_id);
      if($result_cardProcess){ $result_cardProcess_return=1; }else{$result_cardProcess_return=2; }
      if($result_salesDone){ $result_salesDone_return=1;}else{$result_salesDone_return=2;}
      if($result_updateInv){ $result_updateInv_return=1; }else{$result_updateInv_return=2;}
    }else{
      echo "<script> alert(' No data to process.');</script>";
    }
  }

  if (isset($_POST['cancel_sales'])) {
    if ($_POST['cardProcess']=='1') {
        $all_sales_item_id = $_POST["all_sales_item_id"];
        $result_cancelProcess=$obj_card_proc_upd->cancelSalesProcess($all_sales_item_id);
        if($result_cancelProcess){ $result_cancelProcess=1; }else{$result_cancelProcess=2; }
    }else{
      echo "<script> alert(' No data to process.');</script>";
    }
  } 

  if (isset($_POST['edit_sales'])) {
    if ($_POST['cardProcess']=='1') {
        $all_sales_item_id = $_POST["all_sales_item_id"];
        $all_sales_qyt = $_POST["all_sales_qyt"];
        $all_total_p = $_POST["all_total_p"];
        $result_editSalesProcess=$obj_card_proc_upd->editSalesProcess($all_sales_item_id,$all_sales_qyt,$all_total_p);
        if($result_editSalesProcess){ $result_editSalesProcess=1; }else{$result_editSalesProcess=2; }
    }else{
      echo "<script> alert(' No data to process.');</script>";
    }
  } 

}

$obj2 = new SalesItem();                
$obj_itemName=$obj2->getInvItemName();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory AusadiPasal</title>
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon"/>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" content-type="text/css" href="assets/css/jquery-confirm-3-3-2.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="assets/css/card.css">
</head>
<body>

  <nav class="navbar navbar-expand-sm navbar-dark bg-primary" aria-label="Third navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="home.php">Ausadi Pasal</a>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0">
          <li class="nav-item">
            <a class="nav-link" href="inventory.php"><strong>Inventory</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="stock.php"><strong>Stock</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="sales.php"><strong>Sales</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Card.php"><strong>Card</strong></a>
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
    <!-- ----------------------  infoooo   ----------------------- -->
    <?php 
    if (($result_cardProcess_return==1)&&($result_salesDone_return==1)&&($result_updateInv_return==1)){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong> The Sales Process has been sucessfully .....
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else if (($result_cardProcess_return==1)&&($result_salesDone_return==2)&&($result_updateInv_return==1)) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong> cardProcess, updateInv sucessfully.....<spam style='color:red'>but updateSalesCard fail.....</spam>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    } else if(($result_cardProcess_return==2)||($result_salesDone_return==2)||($result_updateInv_return==2)) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong>------------   process fail   ------------
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    
    if ($result_editSalesProcess==1) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong>  <spam style='color:green'> Edit Sales Process sucessfully.....</spam>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }elseif ($result_editSalesProcess==2) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong>  <spam style='color:red'> !!!!   Edit Sales Process Fail.....</spam>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($result_cancelProcess==1) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong>  <spam style='color:green'> Cancel Sales Process sucessfully.....</spam>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($result_cancelProcess==2) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>+</strong> <spam style='color:red'>Cancel Sales Process Fail.....</spam>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    ?>
    <!--  ----------------  section ------------------ -->
    <section>
      <div class="container">
        <form action="Card.php" method="POST" class='card-form' id='card-form'>
          <table>
            <thead>
              <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Quantity[QYT]</th>
                <th>Price[MRP]</th>
                <th>Total Price</th>
              </tr>
            </thead>
            <tbody class="card-tbody">
              <?php
              $result=$obj->getSalesCardData();
              $sno=0;
              if ($result) {
                foreach($result as $rows=>$row){
                  $max_val=$obj_card_proc_upd->getQytSale($row['id']);
                  $sno=$sno+1;
                  echo "<tr>
                  <td> ".$sno."<spam class='sales_item_id' style='display:none'>".$row['id']."</spam></td>
                  <td> ".$row['item_name']."</td>
                  <td> <input type='number' max='".$max_val."' min='0' style='width:70px' name='qyt' id='qyt-".$row['id']."' class='sales_qyt' value='".$row['qyt']."' oninput='changeQyt(this)'>
                  </td>
                  <td id='mrp-".$row['id']."'> ".$row['mrp']."</td>
                  <td id='total_mrp-".$row['id']."' class='total_mrp' >".$row['total_mrp']."</td>
                  <td>
                    <button type='button'  id='delcarditem' value='".$row['id']."'  style='background-color: #f44336;border: #f44336;color:white;' class='btn'> Delete </button>
                  </td>
                  </tr>";
                }
              }
              ?>

              <tr>
                <td colspan="4" style="text-align: center;">Total Amount</td>
                <td id="grand_total"></td>
              </tr>
              <tr>
                <td colspan="4" style="text-align: center;">Discount %</td>
                <td style="text-align: center;">
                  <input type="number" min='0' max='100' name="dis_percent" id="dis_percent" style="width: 70px;" oninput="getDisAmo()">
                </td>
              </tr>
              <tr>
                <td colspan="4" style="text-align: center;">Total Net Amount</td>
                <td id="net_total"></td>
              </tr>

            </tbody>
          </table>
          <div style="margin: 10px;margin-left: 20%;">
            <label>Customer Name</label>
            <input type="text" class="form-control" style="display: unset;width: 50%;margin-left: 20px;" name="customer_name" id="customer_name" >
          </div>
          <div class="flex-container">
            <input type="hidden" name="cardProcess" id="cardProcess" value="0">
            <input type="hidden" name="all_sales_item_id" id="all_sales_item_id" >
            <input type="hidden" name="all_sales_qyt" id="all_sales_qyt" value="0">
            <input type="hidden" name="all_total_p" id="all_total_p" value="0">
            <input type="hidden" name="total_amo" id="total_amo" >
            <input type="hidden" name="disount_percent" id="disount_percent" value="0">
            <input type="hidden" name="total_net_amo" id="total_net_amo" >  
            <button type='button' class="btn btn-secondary" id='cancel-sales-btn' >Cancel Sales Process </button>
            <button type="button" class="btn  btn-primary " id='submit-sales-btn' >Sales Process</button>
            <button type="button" class="btn btn-secondary hide" id='cancel-edit-btn'> Cancel Edit Sales Process </button> 
            <button type="submit" class="btn btn-warning hide" id='edit-sales-btn'> Edit Sales Process</button>
          </div>
        </form>
      </div>
    </section>
    
    <!--  ----------------  footer ------------------ -->
    <footer>
      <p>Copyright ©  <?php echo date("Y"); ?> by ausadipasal</p>
    </footer>
  </div>
  <!--------------------------------- js link ------------------------->
  <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js" ></script>
  <script src="assets/js/jquery-3.6.0.js" ></script>
  <script type="text/javascript" src="assets/js/jquery-conform-3-3-2-min.js"></script>
  <script src="assets/js/dataTables.min.js"></script>
  <script type="text/javascript" src="assets/js/add_edit_data_table.js"></script>
  <script type="text/javascript" src="assets/js/card.js"></script>

</body>
</html>
