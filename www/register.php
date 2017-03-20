<?php
  session_start();
  include('connection.php');
  if($_SERVER['REQUEST_METHOD']=='POST') {
    $errors = array();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    if(isset($_POST['selection'])) {
      $user_type = $_POST['selection'];
    } else {
      $errors[] = "Please select a type of user for this account!";
    }
    if(!empty($username) && !empty($email) && !empty($password) && !empty($confirmPassword) && !empty($user_type)) {
      if($password != $confirmPassword) {
        $errors[] = 'Passwords do not match!';
      }
      $checkemail = mysqli_query($dbc, "SELECT * FROM Accounts WHERE email = '$email'");
      $checkusername = mysqli_query($dbc, "SELECT * FROM Accounts WHERE username = '$username'");
      if(mysqli_num_rows($checkemail) != 0) {
        $errors[] = "Email is already registered within the system!";
      }
      if(mysqli_num_rows($checkusername) != 0) {
        $errors[] = "Username is already registered within the system!";
      }
      if(!empty($errors)) {
        mysqli_query($dbc, "INSERT INTO Accounts (`username`, `email`, `password`, `type`) VALUES ('".$username."', '".$email."', '".$password."', '".$type."');");
        $_SESSION['user_type'] = $user_type;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header('location: home.php');
      } else {
        echo "Error! The following error(s) occurred: <br />";
        foreach($errors as $msg){
          echo $msg."<br />";
        }
        echo "<br />";
        echo "<a href='index.php'>Back to Registration Form</a>";
      }
    } else {
      if(empty($username)) {
        $errors[] = "Please enter a username for this account!";
      }
      if(empty($email)) {
        $errors[] = "Please enter a email for this account!";
      }
      if(empty($password)) {
        $errors[] = "Please enter a password for this account!";
      }
      if($password != $confirmPassword) {
        $errors[] = "Passwords do not match!";
      }
      echo "Error! The following error(s) occurred: <br />";
      foreach($errors as $msg){
        echo $msg."<br />";
      }
      echo "<br />";
      echo "<a href='index.php'>Back to Registration Form</a>";
    }
  }
?>
