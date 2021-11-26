<?php 
session_start();
if (!isset($_SESSION['uname'])) {
  echo "<script>alert('please login..');location.href='../index.php'</script>";
}
include "../db/database.php";
$obj = new query();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST["uname"])) {
    $uname = $_POST["uname"];
    $password = $_POST["password"];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $arr_inv=array(
      "username"=>$uname,
      "password"=>$hash_password,
      "email"=>$email,
      "last_login"=>'0000-00-00 ',
      "count_login"=>'0'
    );
    $result=$obj->insertData('user',$arr_inv);
    if ($result) {
      echo "<script> alert('New User Created');</script>";
    }else {
      echo "<script> alert(' !!!!!! Fail to Created New User ......');</script>";
    }
  }elseif (isset($_POST["new_uname"]) ){
    $new_uname = $_POST["new_uname"];
    $arr=array(
      "username"=>$new_uname,
    );
    $result=$obj->updateData('user',$arr,'username',$_SESSION['uname']);
    if ($result) {
      $_SESSION['uname']=$new_uname;
      echo "<script> alert('Username Changed Sucessfully');</script>";
    }else {
      echo "<script> alert(' !!!!!! Fail to Changed Username ......');</script>";
    }
  }elseif (isset($_POST["new_password"]) ){
    $password = $_POST["new_password"];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $arr=array(
      "password"=>$hash_password,
    );
    $result=$obj->updateData('user',$arr,'username',$_SESSION['uname']);
    if ($result) {
      echo "<script> alert('Password Changed Sucessfully');</script>";
    }else {
      echo "<script> alert(' !!!!!! Fail to Changed Password ......');</script>";
    }
  }
  
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>User AusadiPasal</title>
  <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="../assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/user_index.css">
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
            <a class="nav-link" href="../dc/index.php"><strong>DC</strong></a>
          </li>
        </ul>
      </div>
      <a class="navbar-brand active" href="index.php">  <img  class="profile-img" src="../assets/img/avatar_2x.png" alt="user"> </a>
      <a class="navbar-brand" href="../db/logout.php"> Log out </a>
    </div>
  </nav>
  <div id="main">
    <!-- ----------- Change Password modal ----------------------- -->
    <div class="modal fade" id="changePassWordMod" tabindex="-1" aria-labelledby="changePassWordMod" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top: 45%;">
          <div class="modal-header">
            <h5 class="modal-title" id="changePassWordMod" >Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           <form action="index.php" method="POST" autocomplete="off">
             <div>
              <input type="password" placeholder="Enter New Password" name="new_password" id="passInput" class="form-control" autocomplete="off" required>
              <input type="checkbox" onclick="showPassword()" style="margin-bottom: 22px;margin-left: 30px;"> show password
            </div>
            <div class="flex-container">
              <button  type="button" class='btn btn-secondary' data-bs-dismiss="modal" aria-label="Close">Cancel </button> 
              <button  type="submit" class='btn btn-primary' >Change Passwword </button> 
            </div>
          </form>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
  <!-- ----------- Change username modal ----------------------- -->
    <div class="modal fade" id="changeUnameMod" tabindex="-1" aria-labelledby="changeUnameMod" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top: 45%;">
          <div class="modal-header">
            <h5 class="modal-title" id="changeUnameMod" >Change Username</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           <form action="index.php" method="POST" autocomplete="off">
             <div>
              <input type="text" placeholder="Enter New Username" name="new_uname" class="form-control"  required>
            </div>
            <div class="flex-container">
              <button  type="button" class='btn btn-secondary' data-bs-dismiss="modal" aria-label="Close">Cancel </button> 
              <button  type="submit" class='btn btn-primary' >Change Username </button> 
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
          <h4> User Details </h4>
         <!--  <h4> username : <?php echo $_SESSION['uname']; ?> </h4> -->
        </div>
        <div class="itemflex" style="display: flex;">
          <!-- <button onclick="addUser()" class="addUserBtn">Add User</button> -->
        </div>
      </div>
      <hr>
      <div class="flex-container">
        <div class="user-info">
          <div>
            <?php 
            $result_userInfo=$obj->getUserInfo($_SESSION['uname']);
            foreach ($result_userInfo as $key => $userInfo) {
              $last_login = new DateTime($userInfo['last_login']);
              $last_login=$last_login->format('Y-m-d h:i:sa');
              echo "
              <p> User Name : ".$userInfo['username']."</p>
              <p> Email : ".$userInfo['email']."</p>
              <p> Last Login Time : ".$last_login."</p>
              ";
            }
            ?>
            <p><button id='changeUname' class="addUserBtn" onclick="changeUname()" >Change Username</button> <span></span>
              <button id='changePass' class="addUserBtn" onclick="changePass()" >Change Password</button></p>
          </div>
        </div>

        <div id='addUser' class="hide" >
          <form action="index.php" method="POST" autocomplete="off">
            <fieldset>
              <legend> Add New User</legend>

              <div>
                <label ><b>user name</b></label>
                <input type="text" placeholder="Enter Username" name="uname" class="form-control" autocomplete="off" required>
              </div>

              <div>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="passInput" class="form-control" autocomplete="off" required>
                <input type="checkbox" onclick="showPassword()" style="margin-bottom: 22px;margin-left: 30px;"> show password
              </div>

              <div>
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" class="form-control" autocomplete="off" required>
              </div>

              <div>
                <button type="button" class="cancelbtn" onclick="cancelAddUser()">Cancel</button>
                <button type="submit" class="signupbtn">Create</button>
              </div>
            </fieldset>
          </form>
        </div>

      </div>

    </div>
  </section>
  <!--  ----------------  footer ------------------ -->
  <footer>
    <p>Copyright © <?php echo date("Y"); ?>  by ausadipasal</p>
  </footer>
</div>
<!--------------------------------- js link ------------------------->
<script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js" ></script>
<script src="../assets/js/jquery-3.6.0.js" ></script>
<script src="../assets/js/dataTables.min.js"></script>
<script type="text/javascript" src="../assets/js/user_index.js"></script>

</body>
</html>
