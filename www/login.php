<?php
session_start();
include('connection.php');
if($_POST['username'] && $_POST['password'] && $_POST['user_type']) {
  $errors = array();
  $username = $_POST['username'];
  $password = $_POST['password'];
  $user_type = $_POST['user_type'];
  if($user_type == 'builder') {
    $query = mysqli_query($dbc, "SELECT * FROM Builders WHERE username = '$username'");
    $isbuilder = true;
  } else {
    $query = mysqli_query($dbc, "SELECT * FROM Owners WHERE username = '$username'");
    $isbuilder = false;
  }
  if(mysqli_num_rows($query) != 0) {
    while($row = mysqli_fetch_array($query)) {
      $dbusername = $row['username'];
      $dbid = $row['id'];
      $dbpassword = $row['password'];
      $dbemail = $row['email'];
    }
    if($username == $dbusername) {
      if($password == $dbpassword) {
        if($isbuilder == true) {
          $_SESSION['user_type'] = 'builder';
        } else {
          $_SESSION['user_type'] = 'owner';
        }
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $dbid;
        $_SESSION['email'] = $dbemail;
      } else {
        $errors[] = "Invalid password!";
      }
    } else {
      $errors[] = "Invalid username!";
    }
  } else {
    $errors[] = "Username was not found within the system!";
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
