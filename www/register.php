<?php
session_start();
include('connection.php');

if($_POST['username'] && $_POST['email'] && $_POST['password'] && $_POST['user_type']) {
  $errors = array();
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $user_type = $_POST["user_type"];

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
  } else {
    if($user_type == "builder") {
      mysqli_query($dbc, "INSERT INTO Builders (`username`, `email`, `password`) VALUES ('".$username."', '".$email."', '".$password."');");
      $_SESSION['user_type'] = $user_type;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $sql = mysqli_query($dbc, "SELECT id FROM Builders WHERE username = '$username';");
      while($row = mysqli_fetch_array($sql)) {
        $_SESSION['user_id'] = $row['id'];
      }
    } else {
      mysqli_query($dbc, "INSERT INTO Owners (`username`, `email`, `password`) VALUES ('".$username."', '".$email."', '".$password."');");
      $_SESSION['user_type'] = $user_type;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $sql = mysqli_query($dbc, "SELECT id FROM Owners WHERE username = '$username';");
      while($row = mysqli_fetch_array($sql)) {
        $_SESSION['user_id'] = $row['id'];
      }
    }
  }

  if(!empty($errors)) {
    echo json_encode($errors);
  } else {
    $success = array();
    $success[] = "Success";
    echo json_encode($success);
  }
}
?>
