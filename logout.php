<?php 
session_start();

session_destroy();

header('location:home.php');

// After user logs out
unset($_SESSION['user_authenticated']);
?>