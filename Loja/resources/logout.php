<?php
   
   unset($_COOKIE['cliente']);
   setcookie('cliente', '', time() - 3600, '/');
   header ("Location: ../index.php");
?>