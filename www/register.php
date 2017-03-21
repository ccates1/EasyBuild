<?php
  session_start();
  include('connection.php');
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $confirmPassword = test_input($_POST["confirm-password"]);
    $user_type = test_input($_POST["selection"]);
    echo("<script>console.log('PHP: ".$username."');</script>");
    echo("<script>console.log('PHP: ".$email."');</script>");
    echo("<script>console.log('PHP: ".$password."');</script>");
    echo("<script>console.log('PHP: ".$confirmPassword."');</script>");
    echo("<script>console.log('PHP: ".$user_type."');</script>");

    if(!empty($username) && !empty($email) && !empty($password) && !empty($confirmPassword) && !empty($user_type)) {
      if($user_type == "builder") {
        $checkemail = mysqli_query($dbc, "SELECT * FROM Builders WHERE email = '$email'");
        $checkusername = mysqli_query($dbc, "SELECT * FROM Builders WHERE username = '$username'");
      } else {
        $checkemail = mysqli_query($dbc, "SELECT * FROM Owners WHERE email = '$email'");
        $checkusername = mysqli_query($dbc, "SELECT * FROM Owners WHERE username = '$username'");
      }
      if(mysqli_num_rows($checkemail) != 0) {
        $errors[] = "Email is already registered within the system!";
      } else if(mysqli_num_rows($checkusername) != 0) {
        $errors[] = "Username is already registered within the system!";
      } else if($password != $confirmPassword) {
        $errors[] = 'Passwords do not match!';
      } else {
        if($user_type == "builder") {
          mysqli_query($dbc, "INSERT INTO `Builders` (`username`, `email`, `password`) VALUES ('".$username."', '".$email."', '".$password."');");
          $_SESSION['user_type'] = $user_type;
          $_SESSION['username'] = $username;
          $_SESSION['email'] = $email;
          header('location: home.php');
        } else {
          mysqli_query($dbc, "INSERT INTO `Owners` (`username`, `email`, `password`) VALUES ('".$username."', '".$email."', '".$password."');");
          $_SESSION['user_type'] = $user_type;
          $_SESSION['username'] = $username;
          $_SESSION['email'] = $email;
          header('location: home.php');
        }
      }
      if(!empty($errors)) {
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
      if(empty($user_type)) {
        $errors[] = "Please select a user type!";
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
