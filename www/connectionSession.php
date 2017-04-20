<?php
  session_start();
  include('connection.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    $recipientusername = $_POST['username'];
    $recipientemail = $_POST['email'];
    $recipienttype = $_POST['user_type'];
    $sessionname = mysqli_real_escape_string($dbc, trim($_POST['sessionname']));

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
          }
          if(mysqli_num_rows($checkquery2) != 0) {
            $errors[] = "There is already session with this name!";
          }
          if(empty($errors)) {
            $query2 = mysqli_query($dbc, "INSERT INTO Sessions (`name`, `owner_id`, `builder_id`, `isActive`) VALUES ('".$sessionname."', '".$senderid."', '".$dbrecipientid."', '1');");

            $query3 = "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Obtaining Building Permits', '1', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Foundation', '2', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Roofing', '3', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Rough-in Tasks', '4', '1' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Plumbing', '0', session_id FROM ChecklistItems WHERE step = '4';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Electrical', '0', session_id FROM ChecklistItems WHERE step = '4';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'HVAC', '0', session_id FROM ChecklistItems WHERE step = '4';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Insulation', '5', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Drywall', '6', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Paint', '7', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Primary Interior Construction', '8', '1' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Cabinets', '0', session_id FROM ChecklistItems WHERE step = '8';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Flooring', '0', session_id FROM ChecklistItems WHERE step = '8';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Interior Trim/Doors', '0', session_id FROM ChecklistItems WHERE step = '8';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Secondary Interior & Exterior Construction', '9', '1' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Final Paint', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Fixtures', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Appliances', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Landscaping/Driveway', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Attic Insulation', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Obtain Certificate of Occupancy', '10', '0' FROM Sessions WHERE name = '$sessionname';";

            // Execute multi query
            if (mysqli_multi_query($dbc,$query3)){
              do{
                // Store first result set
                if ($result=mysqli_store_result($dbc)){
                  while ($row=mysqli_fetch_row($result)){
                    printf("%s\n",$row[0]);
                  }
                  mysqli_free_result($dbc);
                }
              }while (mysqli_next_result($dbc));
            }
            header("location: home.php");

          }

        }
        if($isbuilder == false ){
          $checkquery = mysqli_query($dbc, "SELECT * FROM Sessions WHERE builder_id = '$senderid' AND owner_id = '$dbrecipientid';");
          $checkquery2 = mysqli_query($dbc, "SELECT * FROM Sessions WHERE name = '$sessionname';");
          if(mysqli_num_rows($checkquery) != 0) {
            $errors[] = "There is already a session with these two users!";
          }
          if(mysqli_num_rows($checkquery2) != 0) {
            $errors[] = "There is already session with this name!";
          }
          if(empty($errors)) {
            $query2 = mysqli_query($dbc, "INSERT INTO Sessions (`name`, `owner_id`, `builder_id`) VALUES ('".$sessionname."', '".$dbrecipientid."', '".$senderid."');");

            $query3 = "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Obtaining Building Permits', '1', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Foundation', '2', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Roofing', '3', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Rough-in Tasks', '4', '1' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Plumbing', '0', session_id FROM ChecklistItems WHERE step = '4';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Electrical', '0', session_id FROM ChecklistItems WHERE step = '4';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'HVAC', '0', session_id FROM ChecklistItems WHERE step = '4';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Insulation', '5', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`, `description`, `step`, `hasSubs`) SELECT id, 'Drywall', '6', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Paint', '7', '0' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Primary Interior Construction', '8', '1' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Cabinets', '0', session_id FROM ChecklistItems WHERE step = '8';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Flooring', '0', session_id FROM ChecklistItems WHERE step = '8';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Interior Trim/Doors', '0', session_id FROM ChecklistItems WHERE step = '8';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Secondary Interior & Exterior Construction', '9', '1' FROM Sessions WHERE name = '$sessionname';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Final Paint', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Fixtures', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Appliances', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Landscaping/Driveway', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO Subs (`checklistitem_id`, `description`, `isCompleted`, `session_id_fk`) SELECT id, 'Attic Insulation', '0', session_id FROM ChecklistItems WHERE step = '9';";

            $query3 .= "INSERT INTO ChecklistItems (`session_id`,`description`, `step`, `hasSubs`) SELECT id, 'Obtain Certificate of Occupancy', '10', '0' FROM Sessions WHERE name = '$sessionname';";

            // Execute multi query
            if (mysqli_multi_query($dbc,$query3)){
              do{
                // Store first result set
                if ($result=mysqli_store_result($dbc)){
                  while ($row=mysqli_fetch_row($result)){
                    printf("%s\n",$row[0]);
                  }
                  mysqli_free_result($dbc);
                }
              }while (mysqli_next_result($dbc));
            }

            header("location: home.php");

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
