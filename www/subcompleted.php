<?php
session_start();
include('connection.php');

if($_POST['subdesc'] && $_POST['sessionid'] && $_POST['step']) {
  $sessionid = $_POST['sessionid'];
  $subdesc = $_POST['subdesc'];
  $step = $_POST['step'];
  $query = mysqli_query($dbc, "UPDATE Subs SET isCompleted = '1' WHERE session_id_fk = '$sessionid' AND description = '$subdesc';");
  $returnquery = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step';");
  $checkarray = array();
  $iscompleted = true;
  if(mysqli_num_rows($returnquery) != 0) {
    while($row = mysqli_fetch_array($returnquery)) {
      if($row['isCompleted'] == '0') {
        $iscompleted = false;
      }
    }
    if($iscompleted == true) {
      $query2 = mysqli_query($dbc, "UPDATE ChecklistItems SET isCompleted = '1' WHERE session_id = '$sessionid' AND step = '$step';");
      echo "completed";
    } else {
      echo "not completed";
    }
  }
}
?>
