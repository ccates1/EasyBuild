<?php
  session_start();
  include('connection.php');
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $return = array();
    $errors = array();
    $currentusername = $_POST['currentUsername'];
    $user_type = $_POST['userType'];
    // Check if email already exists
    if($_POST['email'] != "") {
      $email = $_POST['email'];
      if($user_type == "builder") {
        $checkemailquery = mysqli_query($dbc, "SELECT * FROM Builders");
      } else {
        $checkemailquery = mysqli_query($dbc, "SELECT * FROM Owners");
      }
      if(mysqli_num_rows($checkemailquery) != 0) {
        while($row = mysqli_fetch_array($checkemailquery)) {
          if($email == $row['email']) {
            $errors[] = "Email already exists";
          }
        }
      }
    }
    if($_POST['password'] != "") {
      $password = $_POST['password'];
    }
    // Check if username already exists
    if($_POST['username'] != "") {
      $username = $_POST['username'];
      if($user_type == "builder") {
        $checkusernamequery = mysqli_query($dbc, "SELECT * FROM Builders");
      } else {
        $checkusernamequery = mysqli_query($dbc, "SELECT * FROM Owners");
      }
      if(mysqli_num_rows($checkusernamequery) != 0) {
        while($row = mysqli_fetch_array($checkusernamequery)) {
          if($username == $row['username']) {
            $errors[] = "Username already exists";
          }
        }
      }
    }
    // Check if errors, if so don't make any changes
    if(empty($errors)) {
      /* Email & and password changes have to come before username changes because each WHERE clause within
      each SQL statement gets the correct user based on their current username.
      */

      // Check if email is being changed
      if(!empty($email)) {
        if($user_type == "builder") {
          $query = mysqli_query($dbc, "UPDATE Builders SET email = '$email' WHERE username = '$currentusername';");
          $success[] = "Email was successfully updated";
          $_SESSION['email'] = $email;
        } else {
          $query = mysqli_query($dbc, "UPDATE Owners SET email = '$email' WHERE username = '$currentusername';");
          $success[] = "Email was successfully updated";
          $_SESSION['email'] = $email;
        }
      }
      // Check if password is being changed
      if(!empty($password)) {
        if($user_type == "builder") {
          $query = mysqli_query($dbc, "UPDATE Builders SET password = '$password' WHERE username = '$currentusername';");
          $success[] = "Password was successfully updated";
        } else {
          $query = mysqli_query($dbc, "UPDATE Owners SET password = '$password' WHERE username = '$currentusername';");
          $success[] = "Password was successfully updated";
        }
      }
      // Check if username is being changed
      if(!empty($username)) {
        if($user_type == "builder") {
          $query = mysqli_query($dbc, "UPDATE Builders SET username = '$username' WHERE username = '$currentusername';");
          $success[] = "Username was successfully updated";
          $_SESSION['username'] = $username;
        } else {
          $query = mysqli_query($dbc, "UPDATE Owners SET username = '$username' WHERE username = '$currentusername';");
          $success[] = "Username was successfully updated";
          $_SESSION['username'] = $username;
        }
      }
      if(!empty($success)) {
        echo json_encode($success);
      } else {
        echo "Something unexpected happened";
      }
    } else {
      echo json_encode($errors);
    }
  }

?>
