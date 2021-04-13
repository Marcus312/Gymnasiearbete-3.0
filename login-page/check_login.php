<?php
// kollar om användaren är inloggad, om inte:

  function check_login($con)
  {
    if(isset($_SESSION["user_id"]))
    {
        $user_id = $_SESSION["user_id"];
        $query = "SELECT * FROM `users` WHERE `user_id` = '$user_id' LIMIT 1";

        $result  = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0 )
        {
          $user_data = mysqli_fetch_assoc($result);
          return $user_data;
        }
    }

//Gå till login-sidan om användaren inte är inloggad
header("Location: login-page/login.php");
die;

  }
