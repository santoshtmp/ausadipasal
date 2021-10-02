<?php

include "database.php";
$obj = new query();

if (isset($_POST['login'])) {
  $uname=$_POST['username'];
  $pass=$_POST['password'];
  
  $result=$obj->checkLogin($uname,$pass);
  if($result){
    session_start();
    $_SESSION['uname']=$uname;
    setcookie("uname", $uname, time()+60*60*24, '/'); 
    if ($_SESSION['uname'] == true) {
      echo "
      <script>
      alert('you are sucessfully login..');
      location.href='../home.php';
      </script>
      ";
    } 
  }
  else{
    ?>
    <script>
      alert('Username or Password does not match ! !');
      window.open('../index.php','_self');
    </script>
    <?php
  }


}
