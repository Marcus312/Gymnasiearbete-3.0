<?php
  date_default_timezone_set("Europe/stockholm");
  include("../connection.php");
  include("check_login.php");



  if($_SERVER["REQUEST_METHOD"] == "POST")
  {

    $user_name = mysqli_real_escape_string($con, $_POST["user_name"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $password2 = mysqli_real_escape_string($con, $_POST["password2"]);
    $user_id = rand(10000000000, 100000000000);

    if(empty($user_name)){
      echo "<div class='oops'>Please fill out username</div>";
    } else{

    if(empty($password)){
      echo "<div class='oops'>Please fill out password</div>";
    } else {

    if($password != $password2){
      echo "<div class='oops'>Passwords doesn't match</div>";
    } else {

    //Kollar om användarnamnet är upptaget
    $query123 = mysqli_query($con, "SELECT * FROM `users` WHERE `user_name`='".$user_name."'");


    if(!empty($user_name) && !empty($password) && !(mysqli_num_rows($query123) > 0))
    {

      $sql = "INSERT INTO `users` (`user_id`, `user_name`, `password`) VALUES (?,?,?);";

      $stmt = mysqli_stmt_init($con);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR BRUH";
      } else {
        mysqli_stmt_bind_param($stmt, "sss", $user_id, $user_name, $password);
        mysqli_stmt_execute($stmt);
      }

      header("Location: login.php");


      //användarnamnet är upptaget error
    } else{
    echo "<div class='oops'>".$_POST['user_name']." is already taken</div>";
      }
     }
    }
   }
  }
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Signup</title>
     <link rel="stylesheet" href="style.css">
   </head>
   <body style="background-color: #ACDDDE;">


        <form method="post" class="box" >

          <h1 style="">Sign up</h1>

          <b>Name</b><br>
          <input class="text" type="text" name="user_name" maxlength="25"><br><br>
          <b>Password</b><br>
          <input class="text" type="password" name="password"  maxlength="25"><br><br>
          <b>Verify Password</b><br>
          <input class="text" type="password" name="password2"  maxlength="25"><br><br>

          <label style="font-weight:bold;">&bull; Passwords are stored in plain text</label><br><br>

          <input class="button" type="submit" value="Sign up"><br><br>

          <label style="font-size:15px;">Already got an account?</label>
          <a class="link_login"href="login.php">Log in</a><br><br>
        </form>



   </body>
 </html>
