<?php
include("../connection.php");
date_default_timezone_set("Europe/stockholm");



if(!empty($_POST["name"]) && !empty($_POST["comment"])){


	$commentId = mysqli_real_escape_string($con, $_POST["commentId"]);
	$comment = mysqli_real_escape_string($con, $_POST["comment"]);
	$originalSender = mysqli_real_escape_string($con, $_POST["originalSender"]);
	$sender = mysqli_real_escape_string($con, $_POST["name"]);


	$insertComments = "INSERT INTO `comment` (`parent_id`, `comment`, `originalSender`, `sender`) VALUES ('$commentId', '$comment','$originalSender', '$sender')";
	mysqli_query($con, $insertComments) or die("database error: ". mysqli_error($con));


	$status = array();
}
echo json_encode($status);
?>
