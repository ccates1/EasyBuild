<?php
  session_start();
  include('connection.php');
  if($_POST['sessionid'] && $_POST['description']) {
    $sessionid = $_POST['sessionid'];
    $desc = $_POST['description'];
    $query = mysqli_query($dbc, "DELETE FROM Inventory WHERE session_id = '$sessionid' AND description = '$desc';");
  }
?>
