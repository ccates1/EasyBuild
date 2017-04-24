<?php
session_start();
include("connection.php");
if($_POST['desc'] && $_POST['value'] && $_POST['session']) {
  $sessionid = $_POST['session'];
  $value = $_POST['value'];
  $description = $_POST['desc'];
  $sql = mysqli_query($dbc, "UPDATE Paint SET color = '$value', isCompleted = '1' WHERE description = '$description' AND session_id_fk = '$sessionid';");
  echo $value;
}
?>
