<?php
session_start();
include('connection.php');
if($_POST['sessionid'] && $_POST['description'] && $_POST['amount']) {
  $isedit = $_POST['isedit'];
  if($isedit == '0') {
    $sessionid = $_POST['sessionid'];
    $desc = $_POST['description'];
    $amount = $_POST['amount'];
    if($desc == "Aluminum Siding") {
      $icon = "/EasyBuild/www/png/aluminum.png";
    }
    else if($desc == "Appliances") {
      $icon = "/EasyBuild/www/png/appliance.png";
    }
    else if($desc == "Asphalt Shingles") {
      $icon = "/EasyBuild/www/png/shingles.png";
    }
    else if($desc == "Brick") {
      $icon = "/EasyBuild/www/png/brick.png";
    }
    else if($desc == "Concrete") {
      $icon = "/EasyBuild/www/png/concrete.png";
    }
    else if($desc == "Doors") {
      $icon = "/EasyBuild/www/png/door.png";
    }
    else if($desc == "Ducting") {
      $icon = "/EasyBuild/www/png/ducting.png";
    }
    else if($desc == "Insulation") {
      $icon = "/EasyBuild/www/png/insulation.png";
    }
    else if($desc == "Lumber") {
      $icon = "/EasyBuild/www/png/lumber.png";
    }
    else if($desc == "Nails") {
      $icon = "/EasyBuild/www/png/nail.png";
    }
    else if($desc == "Paint") {
      $icon = "/EasyBuild/www/png/paint.png";
    }
    else if($desc == "Plumbing Fittings") {
      $icon = "/EasyBuild/www/png/plumbing.png";
    }
    else if($desc == "Plywood") {
      $icon = "/EasyBuild/www/png/plywood.png";
    }
    else if($desc == "Sheeting") {
      $icon = "/EasyBuild/www/png/sheeting.png";
    }
    else if($desc == "Windows") {
      $icon = "/EasyBuild/www/png/window.png";
    }
    else if($desc == "Wiring") {
      $icon = "/EasyBuild/www/png/wire.png";
    }
    $query = mysqli_query($dbc, "INSERT INTO Inventory (`session_id`, `description`, `amount`, `icon`) VALUES ('".$sessionid."', '".$desc."', '".$amount."', '".$icon."');");
    return $isedit;
  } else {
    $sessionid = $_POST['sessionid'];
    $desc = $_POST['description'];
    $amount = $_POST['amount'];
    $query = mysqli_query($dbc, "UPDATE Inventory SET amount = '$amount' WHERE session_id = '$sessionid' AND description = '$desc';");
  }

}

?>
