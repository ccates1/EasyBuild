<?php
session_start();
include("connection.php");
if($_POST['sessionid'] && $_POST['sender'] && $_POST['content'] && $_POST['user_type']) {
  $sessionid = $_POST['sessionid'];
  $sender = $_POST['sender'];
  $content = $_POST['content'];
  $user_type = $_POST['user_type'];
  $query = mysqli_query($dbc, "INSERT INTO Messages (`sender`, `content`, `session_id`, `user_type`) VALUES ('".$sender."', '".$content."', '".$sessionid."', '".$user_type."');");
}
?>
