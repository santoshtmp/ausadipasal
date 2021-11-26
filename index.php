 <?php

 session_start();
  if (isset($_SESSION['uname'])) {
    echo "
      <script>
      location.href='home.php'
      </script>
  ";
 }

  require "db/db-table-check-create.php";
  $obj=new tableCheck();

  // POST method
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
     $tableNam = $_POST['create'];
     $result=$obj->createTable();
     if ($result==6) {
        echo "<script> alert(' sucessfully created.');</script>";
     }else{
      echo "<script> alert(' sorry !!!!!.');</script>";
     }
    }
  }

  // check db connection for first time.
  $formAction="db/login.php";
  $nouser=0;
  $result_checkUserPresent=$obj->checkUserPresent();
  if ($result_checkUserPresent=='no-user') {
    $nouser=1;
    $tableName='user';
    $formAction='#';
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ausadipasal</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="assets/img/favicon.ico" type="image/x-icon"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
<link rel="stylesheet" type="text/css" href="assets/css/footer.css">
<body id="login-page">
<!--  ----------------  nav-bar ------------------ -->

  <nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Ausadi Pasal</a>
    </div>
  </nav>
<div id="main">
  <?php 
    if ($nouser==1){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <form action='index.php' method='POST' class='create-db-tb'>
        <label> Database table is not defined; Create default database  </label>
        <input type='submit' name='cancel' class='btn-secondary' value='cancel' data-bs-dismiss='alert' aria-label='Close'>
        <button type='submit' name='create' class='btn-primary' value='create-table'> create </button>
      </form>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
  ?>
  
<!--  ----------------  section ------------------ -->
<section>
<!-- section contents -->
  <div class="welcome">
    <h4>Welcome to ausadipasal</h4>
  </div>
<!--  ---------------- section login form ------------------ -->
  <div class="login-box">
      <div class="login-center">
        <div  align="center">
      <strong><u>Sign in</u></strong>
    </div>
    <img  class="profile-img" src="assets/img/avatar_2x.png" alt="user">
    <form class="myform" action="<?php echo $formAction; ?>" method="POST">
        <input class="form-control" placeholder="Username" name="username" type="text" autofocus   required>

        <input class="form-control" placeholder="Password" name="password" type="password" value="" required>

        <div id="remember" style="margin:10px;">
          <label  >
            <input type="checkbox" value="remember-me" class='check-box'> Remember me
          </label>
        </div>

        <input type="submit" name="login" class="submitbtn" value="Sign in">
    </form>
      </div>
  </div>


</section>

<!--  ----------------  footer ------------------ -->
<footer>
  <p>Copyright © <?php echo date("Y"); ?>  by ausadipasal</p>
</footer>
</div>

<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js" ></script>
<script src="assets/js/jquery-3.6.0.js" ></script>

</body>
</html>

