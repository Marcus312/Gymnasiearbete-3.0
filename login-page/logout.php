<?php

//loggar ut användaren från sessionen
session_start();

if(isset($_SESSION["user_id"]))
{
  unset($_SESSION["user_id"]);
}
header("Location: login.php");
die;

 ?>
