<?php
session_start();
if (isset($_SESSION['uname'])) {
	session_destroy();
    setcookie("uname", $_SESSION['uname'], time()-60*60*24,'/');
	echo "
      <script>
      alert('you are sucessfuly logout');
      location.href='../index.php';
      </script>
	";
}else{
	echo "
      <script>
      alert('please login..');
      location.href='../index.php';
      </script>
	";
}
?>
