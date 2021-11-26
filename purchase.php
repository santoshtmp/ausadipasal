<?php 
include "db/sesson.php"; 
include "db/database.php";

$obj = new query();
$insert=false;
$update=false;
$delete=false;
if (isset($_GET['delete'])) {
  $sno=$_GET['delete'];
  $result=$obj->deletePhData($sno);
  if ($result) {
    $delete=true;
  }else {
    echo "!!!!The record has not been deleted id :".$sno."  <br>";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['callFunc1'])) {
    $val=$_POST['callFunc1'];
    $invItemNm = new SalesItem();
    $obj_itemName=$invItemNm->getInvCodeNo($val);
    if ($obj_itemName) {
      echo $obj_itemName;
    }
  }
  elseif (isset($_POST['callFunc2'])) {
    $itemNameBatchNum=$_POST['callFunc2'];
    $invItemNm = new SalesItem();
    $obj_expMrp=$invItemNm->getExpMrp($itemNameBatchNum);
    $exp=$mrp=0;
    if ($obj_expMrp) {
      $exp=$obj_expMrp['expire_date'];
      $mrp=$obj_expMrp['mrp'];
    }
    echo $exp.','.$mrp;
  }
  elseif (isset($_POST['idEdit'])) {
    $id = $_POST['idEdit'];
    $editBillNo = $_POST["editBillNo"];
    $editItem = $_POST["editItem"];
    $editBatchNum = $_POST['editBatchNum'];
    $editQYT = $_POST["editQYT"];
    $date=date("Y-m-d");
    $arr=array(
      "id"=>$id,
      "date"=>$date,
      'bill_no'=>$editBillNo,
      "item_name"=>$editItem,
      "batch_no"=>$editBatchNum,
      "qyt"=>$editQYT,
      "qyt_purch"=>$editQYT
    );
    if (isset($_POST["editCodeNo"])) {
      $arr["code"]=$_POST["editCodeNo"];
    }
    if (isset($_POST["editMRP"])) {
      $arr["mrp"]=$_POST["editMRP"];
    }
    if (isset($_POST["editExpDate"])) {
      $arr["expire_date"]=$_POST["editExpDate"];
    }
    $result=$obj->insertEditInvPurchData($arr);
    if ($result) {
      $update=true;
    }else {
      echo "<script> alert(' !!!!!!  sorry edit sales data is not save......');</script>";
    }
  }
  else{
    $inputBillNo = $_POST["inputBillNo"];
    $inputItem = $_POST["inputItem"];
    $inputCodeNo=$_POST["inputCodeNo"];
    $inputBatchNum = $_POST['inputBatchNum'];
    $inputExpDate = $_POST["inputExpDate"];
    $inputMRP = $_POST["inputMRP"];
    $inputQYT = $_POST["inputQYT"];
    $date=date("Y-m-d");
    $arr_inv=array(
      "date"=>$date,
      'bill_no'=>$inputBillNo,
      "item_name"=>$inputItem,
      "code"=>$inputCodeNo,
      "batch_no"=>$inputBatchNum,
      "expire_date"=>$inputExpDate,
      "mrp"=>$inputMRP,
      "qyt"=>$inputQYT,
      "qyt_purch"=>$inputQYT
    );
    $result_inv=$obj->insertEditInvPurchData($arr_inv);
    if ($result_inv) {
      $insert=true;
    }else {
      echo "<script> alert(' !!!!!!  sorry record is not entered......');</script>";
    }
  }
}

$invItemNm = new SalesItem();                  
$obj_itemName=$invItemNm->getInvItemName();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Purchase AusadiPasal</title>
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" >
  <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">

  <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js" ></script>
  <script src="assets/js/jquery-3.6.0.js" ></script>
  <script src="assets/js/dataTables.min.js"></script>
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
            <a class="nav-link " href="sales.php"><strong>Sales</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="Card.php"><strong>Card</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="purchase.php" ><strong>Purchase</strong></a>
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
   if ($insert) {
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>+</strong> The result has been inserted sucessfully.....
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
  if ($update) {
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>+</strong> The result has been update sucessfully.....
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
  if ($delete) {
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>+</strong> The result has been delete sucessfully.....
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }

  ?>
  <!-- ----------- add     modal ----------------------- -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModal">Add Sales Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="purchase.php" method="POST">
            <div class="row-form">
              <div class="date-field">
                <label> Bill No.</label>
                <input type="number" class="form-control" id="inputBillNo" name="inputBillNo" required>
              </div>
              <div class="date-field">
                <label>Item Name</label>
                <input list="itemName" name="inputItem" class="form-control" onfocusout="changeCodeNo();changeExpMrp()" id="inputItem" autocomplete="off" required>
                <datalist id="itemName" >
                  <?php 
                  if ($obj_itemName) {
                    foreach($obj_itemName as $key=>$val){
                      echo"<option value='";?><?php echo $val; ?><?php echo "'>".$val."</option>";
                    }
                  }
                  ?>
                </datalist>
              </div>
            </div>
            <div class="row-form">
              <div class="date-field">
                <label> Batch Number</label>
                <input type="text" class="form-control" id="inputBatchNum" name="inputBatchNum" onfocusout="changeExpMrp();changeCodeNo()" required>
              </div>
              <div class="date-field">
               <label> Code No.</label>
               <input type="text" class="form-control" id="inputCodeNo" name="inputCodeNo" required>
             </div>
           </div>
           <div class="row-form">
            <div class="date-field">
              <label> MRP </label>
              <input type="number" step="any"  class="form-control" id="inputMRP" name="inputMRP"  required>
            </div>
            <div class="date-field">
              <label> QYT </label>
              <input type="number" class="form-control" id="inputQYT" name="inputQYT" required>
            </div>
          </div>
          <div class="row-form">
              <div class="date-field">
                <label> Expire Date </label>
                <input type="date" class="form-control" id="inputExpDate" name="inputExpDate" required>
              </div>
            </div>
          <div class='flex-container'>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<!-- ----------- edit     modal ----------------------- -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal">Edit Purchase Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="purchase.php?update=true" method="POST">
          <input type="hidden" name="idEdit" id="idEdit">
            <div class="row-form">
              <div class="date-field">
                <label> Bill No.</label>
                <input type="number" class="form-control" id="editBillNo" name="editBillNo" required>
              </div>
              <div class="date-field">
                <label>Item Name</label>
                <input list="itemName" name="editItem" class="form-control" onfocusout="changeCodeNo();changeExpMrp()" id="editItem" autocomplete="off" required>
                <datalist id="itemName" >
                  <?php 
                  if ($obj_itemName) {
                    foreach($obj_itemName as $key=>$val){
                      echo"<option value='";?><?php echo $val; ?><?php echo "'>".$val."</option>";
                    }
                  }
                  ?>
                </datalist>
              </div>
            </div>
            <div class="row-form">
              <div class="date-field">
                <label> Batch Number</label>
                <input type="text" class="form-control" id="editBatchNum" name="editBatchNum" onfocusout="changeExpMrp();changeCodeNo()" required>
              </div>
              <div class="date-field">
               <label> Code No.</label>
               <input type="text" class="form-control" id="editCodeNo" name="editCodeNo" required>
             </div>
           </div>
           <div class="row-form">
            <div class="date-field">
              <label> MRP </label>
              <input type="number" step="any"  class="form-control" id="editMRP" name="editMRP" required>
            </div>
            <div class="date-field">
              <label> QYT </label>
              <input type="number" class="form-control" id="editQYT" name="editQYT" required>
            </div>
          </div>
          <div class="row-form">
              <div class="date-field">
                <label> Expire Date </label>
                <input type="date" class="form-control" id="editExpDate" name="editExpDate" required>
              </div>
            </div>
          <div class='flex-container'>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary">Save Edit changes</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- ----------- warning editQytEqualPuchModal  modal ----------------------- -->
<div class="modal fade" id="editQytEqualPuchModal" tabindex="-1" aria-labelledby="editQytEqualPuchModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 45%;">
      <div class="modal-header">
        <h5 class="modal-title" id="editQytEqualPuchModal" style="color:red;">You cannot <b>Edit</b> this item. As sales process is alrady done</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

<!-- ----------- warning qytEqualPuchModal  modal ----------------------- -->
<div class="modal fade" id="qytEqualPuchModal" tabindex="-1" aria-labelledby="qytEqualPuchModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 45%;">
      <div class="modal-header">
        <h5 class="modal-title" id="qytEqualPuchModal" style="color:red;">You cannot <b>Delete</b> this item. As sales process is alrady done</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

<!-- ----------- Conform delConformModal  modal ----------------------- -->
<div class="modal fade" id="delConformModal" tabindex="-1" aria-labelledby="delConformModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 45%;">
      <div class="modal-header">
        <h5 class="modal-title" id="delConformModal" style="color:red;">Conform Delete Process</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button  type="button" class='btn btn-sm btn-primary' id="cancelDelete"  data-bs-dismiss="modal" aria-label="Close">Cancel </button> 
        <button  type="button" class='btn btn-sm btn-primary' id='confDelete' onclick="confDel()">Delete </button> 
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<!--  ----------------  section area ------------------ -->
<section>
  <div class="container">
    <div class="flex-container">
      <div class="itemflex">
        <h4>Purchase List</h4>
      </div>
      <div class="itemflex">
        <button class='add btn btn-sm btn-primary'>+ Add Purchase Item </button> 
      </div>
    </div>
    <hr style="height: 2px;">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Entry Date</th>
          <th scope="col">Bill No</th>
          <th scope="col">Code</th>
          <th scope="col">Items</th>
          <th>Batch No</th>
          <th>Exp Date</th>
          <th>MRP</th>
          <th>QYT</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php

        $obj = new query();
        $result=$obj->getPurchData();

        $sno=0;
        if ($result) {
          foreach($result as $rows=>$row){
            $sno=$sno+1;
             $delEditId=$row['id'].'-'.$row['qyt']."-".$row['qyt_purch'];
            echo "<tr>
            <td>".$sno."</td>
            <td>".$row['date']."</td>
            <td>".$row['bill_no']."</td>
            <td>".$row['code']."</td>
            <td>".$row['item_name']."</td>
            <td>".$row['batch_no']."</td>
            <td>".$row['expire_date']."</td>
            <td>".$row['mrp']."</td>
            <td>".$row['qyt_purch']."</td>
            <td>
                <button class='btn btn-sm btn-primary editProcess' id=".$delEditId." onclick='editProcess(this)' >Edit </button> 
                <button class='btn btn-sm btn-primary deletePurchase' id=".$delEditId." onclick='deletePurchase(this)' >Delete </button>
                
            </td>
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
  <p>Copyright © <?php echo date("Y"); ?>  by ausadipasal</p>
</footer>
</div>


<!--------------------------------- js link ------------------------->
<!-- <script type="text/javascript" src="assets/jsbootstrap.bundle.min.js" ></script> -->
<script src="assets/js/jquery-3.6.0.js" ></script>
<script src="assets/js/dataTables.min.js"></script>
<script type="text/javascript" src="assets/js/add_edit_data_table.js"></script>
<script type="text/javascript" src="assets/js/allCommon.js"></script>

</body>
</html>
