<?php
  date_default_timezone_set("Europe/stockholm");
  session_start();

  include("../connection.php");
  include("check_login.php");



  if($_SERVER["REQUEST_METHOD"] == "POST")
  {

    $user_name = mysqli_real_escape_string($con, $_POST["user_name"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);


    if (empty($user_name)){
      echo "<div class='oops'>Please fill out your username</div>";
    } else{

    if (empty($password)){
      echo "<div class='oops'>Please fill out your password</div>";
    } else{


    if(!empty($user_name) && !empty($password))
    {

    $query = "SELECT * FROM `users` WHERE `user_name` = '$user_name'";

    $result = mysqli_query($con, $query);

    //Kollar om användarnamnet finns is databasen
    if($result && mysqli_num_rows($result) > 0 ) {

        $user_data = mysqli_fetch_assoc($result);
        // Om lösenordet och användarnamnet är lika med det i databasen gå till index.php
        if($user_data['password'] === $password && $user_data['user_name'] === $user_name) {
          $_SESSION['user_id'] = $user_data['user_id'];
          header("Location: ../index.php");

        } else{ //om lösenordet inte tillhör användaren
          echo "<div class='oops'>Wrong password</div>";}

        } else { //om användarnamnet inte finns i databasen
          echo "<div class='oops'>Username: $user_name does not exist</div>";}

       } else{
         echo "<div class='oops'>Big error</div>";
       }
     }
   }
 }

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Log in</title>
     <link rel="stylesheet" href="style.css">
   </head>
    <body style="background-color: #ACDDDE;">

        <form method="post" class="box">
          <h1 style="margin:10px;">Log in</h1>

          <b>Name</b><br>
          <input class="text" type="text" name="user_name" maxlength="25"><br><br>
          <b>Password</b><br>
          <input class="text" type="password" name="password" maxlength="25"><br><br><br>

          <input class="button" type="submit" value="Login"><br><br>

          <label style="font-size:15px;">Dont have an accout?</label>
          <a class="link_login" href="signup.php">Signup</a><br><br>
        </form>


   </body>
 </html>
