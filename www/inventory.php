<?php
session_start();
include('connection.php');
if (empty($_SESSION['username'])) {
  header('location: index.php');
};
?>
<html lang="en">
<head>
  <?php include('head.html'); ?>
  <script type="text/javascript">
  jQuery(document).ready(function($){
    var amount = document.getElementById("amount");
    $("#plus").click(function() {
      amount.value++;
    });
    $("#minus").click(function() {
      if(amount.value > 0) {
        amount.value--;
      }
    });
    $("#submit").click(function() {
      var description = document.getElementById("select-item");
      var sessionid = document.getElementById("session");
      if(description.value == "") {
        window.alert("Please select an item to add to your session's inventory.");
        return;
      } else {
        $.ajax({
          type: 'POST',
          url: 'submititem.php',
          data : 'sessionid='+ sessionid.value + '&amount='+ amount.value + '&description='+ description.value + '&isedit=' + '0',
          success: function(data) {
            window.location.reload();
            window.alert("The item was added to your inventory!");
          }
        });
      }
    });
  });
  function submitChange(index, description) {
    var getid = 'amount' + index;
    var listAmount = document.getElementById(getid.toString());
    var sessionid = document.getElementById("session");
    var desc = description;
    $.ajax({
      type: 'POST',
      url: 'submititem.php',
      data : 'sessionid='+ sessionid.value + '&amount='+ listAmount.value + '&description='+ desc + '&isedit=' + '1',
      success: function(data) {
        window.alert("Item was updated successfully!");
      }
    });
  }
  function incrementValue(index) {
    var getid = 'amount' + index;
    var listAmount = document.getElementById(getid.toString());
    listAmount.value++;
  }
  function decrementValue(index) {
    var getid = 'amount' + index;
    var listAmount = document.getElementById(getid.toString());
    if(listAmount.value > 0) {
      listAmount.value--;
    }
  }
  function deleteItem(description) {
    var sessionid = document.getElementById("session");
    var desc = description;
    $.ajax({
      type: 'POST',
      url: 'deleteitem.php',
      data : 'sessionid='+ sessionid.value + '&description='+ desc,
      success: function(data) {
        window.location.reload();
        window.alert("Item was deleted successfully!");
      }
    });
  }
  </script>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="page-content">
    <?php
    if(!empty($_GET['id'])) {
      $sessionid = $_GET['id'];
      $user_type = $_SESSION['user_type'];
      $sender = $_SESSION['username'];
      $query = mysqli_query($dbc, "SELECT Sessions.name, Sessions.id, Builders.username AS builderusername, Builders.email AS builderemail, Owners.username AS ownerusername, Owners.email AS owneremail FROM Sessions INNER JOIN Builders ON Builders.id = Sessions.builder_id INNER JOIN Owners ON Owners.id = Sessions.owner_id WHERE Sessions.id = '$sessionid'");
      if(mysqli_num_rows($query) != 0) {
        while($row = mysqli_fetch_array($query)) {
          $sessionname = $row['name'];
          $sessionid = $row['id'];
          $buildername = $row['builderusername'];
          $builderemail = $row['builderemail'];
          $ownername = $row['ownerusername'];
          $owneremail = $row['owneremail'];
        }
      }
      $query = mysqli_query($dbc, "SELECT * FROM Inventory WHERE session_id = '$sessionid';");
      if(mysqli_num_rows($query) != 0) {
        $count = mysqli_num_rows($query);
      } else {
        $count = 0;
      }
    }
    ?>
    <div class="container">
      <div class="text-left" style="margin-bottom: 10px;">
        <?php
        echo "<a class='text-primary' href=\"javascript:history.go(-1)\"><i class='fa fa-arrow-circle-o-left fa-fw'></i> GO BACK</a>";
        ?>
      </div>
      <div class="card">
        <div class="card-header bg-primary white-text">
          <h4><i class="fa fa-check-square-o fa-fw"></i> <?php echo $sessionname; ?> Inventory</h4>
        </div>
        <div class="card-block bg-faded">
          <div id="success-msg" class="text-center">

          </div>
          <div class="card-block text-center" id="inventory-header">
            <h4 class="text-primary">Select an item to add to the inventory: </h4>
            <hr />
            <ul class="list-inline">
              <li class="list-inline-item">
                <select id="select-item" class="custom-select">
                  <option value="" selected>
                  </option>
                  <option value="Aluminum Siding">
                    Aluminum Siding
                  </option>
                  <option value="Appliances">
                    Appliances
                  </option>
                  <option value="Asphalt Shingles">
                    Asphalt Shingles
                  </option>
                  <option value="Brick">
                    Brick
                  </option>
                  <option value="Concrete">
                    Concrete
                  </option>
                  <option value="Doors">
                    Doors
                  </option>
                  <option value="Ducting">
                    Ducting
                  </option>
                  <option value="Insulation">
                    Insulation
                  </option>
                  <option value="Lumber">
                    Lumber
                  </option>
                  <option value="Nails">
                    Nails
                  </option>
                  <option value="Paint">
                    Paint
                  </option>
                  <option value="Plumbing Fittings">
                    Plumbing Fittings
                  </option>
                  <option value="Plywood">
                    Plywood
                  </option>
                  <option value="Sheating">
                    Sheating
                  </option>
                  <option value="Windows">
                    Windows
                  </option>
                  <option value="Wiring">
                    Wiring
                  </option>
                </select>
              </li>
              <li class="list-inline-item">
                <div class="md-form input-group " style="width: initial; margin-bottom: 0px;">
                  <span class="input-group-addon bg-danger white-text"><i class="fa fa-minus cursor" id="minus"></i></span>
                  <input type="text" class="input-custom form-control text-center" id="amount" value="0"/>
                  <span class="input-group-addon bg-success white-text" ><i class="fa fa-plus cursor" id="plus"></i></span>
                </div>
              </li>
              <li class="list-inline-item">
                <button type="button" class="btn btn-outline btn-outline-primary waves-effect" id="submit">Add</button>
              </li>
              <input type="hidden" class="hidden" id="session" name="session" value="<?php echo $sessionid; ?>" />
            </ul>
          </div>
          <div class="list-group">
            <?php
            $index = 0;
            $query = mysqli_query($dbc, "SELECT * FROM Inventory WHERE session_id = '$sessionid';");
            if(mysqli_num_rows($query) != 0) {
              $count = mysqli_num_rows($query);
              echo '<div class="list-group-item justify-content-between bg-primary white-text">
              <h4>Current Inventory Items: '.$count.'</h4>
              </div>';
              while($row = mysqli_fetch_array($query)) {
                $desc = $row['description'];
                $amount = $row['amount'];
                $icon = $row['icon'];
                $index++;
                ?>
                <div class="list-group-item justify-content-between">
                  <img class="img-thumbnail" src="<?php echo $icon; ?>">
                  <ul class="text-center" style="margin-bottom: 0px;">
                    <li style="padding-bottom: -10px">
                      <h4 class="dark-text"><?php echo $desc; ?></h4>
                    </li>
                    <hr />
                    <li>
                      <div class="md-form input-group" style="width: initial; margin-bottom: 0px;">
                        <span class="input-group-addon bg-danger white-text" ><i class="fa fa-minus cursor" onclick="decrementValue(<?php echo $index;?>)" id="minus<?php echo $index; ?>"></i></span>
                        <input type="text" class="input-custom form-control text-center" id="amount<?php echo $index; ?>" value="<?php echo $amount ?>"/>
                        <span class="input-group-addon bg-success white-text" ><i class="fa fa-plus cursor" onclick="incrementValue(<?php echo $index;?>)" id="plus<?php echo $index; ?>"></i></span>
                      </div>
                    </li>
                  </ul>
                  <ul style="margin-bottom: 0px;">
                    <li>
                      <button type="button" class="btn btn-outline btn-outline-primary btn-sm" onclick="submitChange('<?php echo $index; ?>', '<?php echo $desc; ?>')">Submit</button>
                    </li>
                    <li>
                      <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('<?php echo $desc; ?>')">Delete</button>
                    </li>
                  </ul>
                </div>
                <?php
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('scripts.html'); ?>
</body>
</html>
