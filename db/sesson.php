<?php
  session_start();
  if (!isset($_SESSION['uname'])) {
    echo "
      <script>
            alert('please login..');
      location.href='index.php'
      </script>
  ";
  }
?>
