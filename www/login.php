<?php
  session_start();
  include('connection.php');
  if($_SERVER['REQUEST_METHOD']=='POST') {
    $errors = array();
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(!empty($_POST['user_type'])) {
      $user_type = $_POST['user_type'];
    }
    if(!empty($username) && !empty($password) && !empty($user_type)) {
      if($user_type == 'builder') {
        $query = mysqli_query($dbc, "SELECT * FROM Builders WHERE username = '$username'");
      } else {
        $query = mysqli_query($dbc, "SELECT * FROM Owners WHERE username = '$username'");
      }
      if(mysqli_num_rows($query) != 0) {
        while($row = mysqli_fetch_array($query)) {
          $dbusername = $row['username'];
          echo("<script>console.log('PHP: ".$dbusername."');</script>");

          $dbpassword = $row['password'];
          $dbtype = $row['type'];
        }
        if($username == $dbusername) {
          if($password == $dbpassword) {
            $_SESSION['user_type'] = $dbtype;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header('location: home.php');
          } else {
            $errors[] = "Invalid password!";
          }
        } else {
          $errors[] = "Invalid username!";
        }
      } else {
        $errors[] = "Username was not found within the system!";
      }
    } else {
      if(empty($username)) {
        $errors[] = "Please enter a username.";
      }
      if(empty($password)) {
        $errors[] = "Please enter a password.";
      }
      if(empty($user_type)) {
        $errors[] = "Please select a type of user.";
      }
    }
    if(!empty($errors)) {
      echo '<div class=\"container\">
      <div class=\"alert alert-danger\" role=\"alert\">
      <strong>Error! The following error(s) occurred:</strong> <br />';
      foreach($errors as $msg){
        echo $msg.'<br />';
      }
      echo '</div></div>';
      echo '<a href="index.php">Back to Registration Form</a>';
    }
  }
?>
