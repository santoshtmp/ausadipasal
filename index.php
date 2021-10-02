 <?php
  session_start();
  if (isset($_SESSION['uname'])) {
    echo "
      <script>
      location.href='home.php'
      </script>
  ";
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
    <img  class="profile-img" src="assets/img/user.png" alt="user">
    <form class="myform" action="db/login.php" method="POST">
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
  <p>Copyright © 2021 by ausadipasal</p>
</footer>
</div>

</body>
</html>

