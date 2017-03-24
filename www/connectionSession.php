<?php
  session_start();
  include('connection.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    $recipientusername = $_POST['username'];
    $recipientemail = $_POST['email'];
    $recipienttype = $_POST['user_type'];
    $sessionname = $_POST['sessionname'];

    if(!empty($recipientusername) && !empty($recipientemail) && !empty($recipienttype) && !empty($sessionname)) {
      if($recipienttype == "builder") {
        $isbuilder = true;
        $query = mysqli_query($dbc, "SELECT * FROM Builders WHERE username = '$recipientusername'");
      } else {
        $isbuilder = false;
        $query = mysqli_query($dbc, "SELECT * FROM Owners WHERE username = '$recipientusername'");
      }
      if(mysqli_num_rows($query) != 0) {
        while($row = mysqli_fetch_array($query)) {
          $dbrecipientid = $row['id'];
          $senderid = $_SESSION['user_id'];
        }

        if($isbuilder == true) { // if the recipient is a builder (sender is a home owner)
          $checkquery = mysqli_query($dbc, "SELECT * FROM Sessions WHERE builder_id = '$dbrecipientid' AND owner_id = '$senderid';");
          $checkquery2 = mysqli_query($dbc, "SELECT * FROM Sessions WHERE name = '$sessionname';");
          if(mysqli_num_rows($checkquery) != 0) {
            $errors[] = "There is already a session with these two users!";
          } else if(mysqli_num_rows($checkquery2) != 0) {
            $errors[] = "There is already session with this name!";
          }
          if(empty($errors)) {
            $query2 = mysqli_query($dbc, "INSERT INTO Sessions (`name`, `owner_id`, `builder_id`) VALUES ('".$sessionname."', '".$senderid."', '".$dbrecipientid."');");
            header('location: home.php');
          }

        } else {
          $checkquery = mysqli_query($dbc, "SELECT * FROM Sessions WHERE builder_id = '$senderid' AND owner_id = '$dbrecipientid';");
          if(mysqli_num_rows($checkquery) != 0) {
            $errors[] = "There is already a session with these two users!";
          }
          if(empty($errors)) {
            $query2 = mysqli_query($dbc, "INSERT INTO Sessions (`name`, `owner_id`, `builder_id`) VALUES ('".$sessionname."', '".$dbrecipientid."', '".$senderid."');");
            header('location: home.php');
          }
        }
      }
    } else {
      if(empty($sessionname)) {
        $errors[] = "Please enter a name for your session";
      }
    }
    if(!empty($errors)) {
      echo '<div class="container">
      <div class="card">
      <div class="card-header bg-danger">
      Error! The folloring error(s) occurred:
      </div>
      <div class="card-block text-center">';
      foreach($errors as $msg){
        echo $msg.'<br />';
      }
      echo '<a href="connect.php">Back to Session Registration Form</a>
      </div>
      </div>
      </div>';
    }
  }
?>
