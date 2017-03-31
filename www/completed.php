<?php
session_start();
include('connection.php');

if($_POST['rowdesc'] && $_POST['sessionid'] && $_POST['step']) {
  $sessionid = $_POST['sessionid'];
  $rowdesc = $_POST['rowdesc'];
  $step = $_POST['step'];
  $query = mysqli_query($dbc, "UPDATE ChecklistItems SET isCompleted = '1' WHERE session_id = '$sessionid' AND step = '$step';");
  echo '<p>Congrats, you have marked completion of the step: '.$rowdesc.', the next step on your checklist is now available</p>';
}
?>
