<?php
session_start();
include('connection.php');
if (empty($_SESSION['username'])) {
  header('location: index.php');
};
?>
<html lang="en">

<head>
  <?php include('head.html');
  echo '<link rel="stylesheet" type="text/css" href="css/paint.css">';
  ?>
  <script type="text/javascript" src="js/jscolor.js"></script>
  <script type="text/javascript">
  var value;
  function update(picker, count) {
    var temp = count
    value = picker.toHEXString();
    var result = "<strong>Selection: " + picker.toHEXString() + "</strong>";
    var id = 'hex-str' + temp;
    document.getElementById(id.toString()).innerHTML = result;
  }
  function submit(description, id, count) {

    if(!value) {
      var element = document.getElementById('result-msg');
      element.innerHTML = "<p class='text-danger'>Select a color before submitting!</p>";
      $('html, body').animate({
        scrollTop: $("#result-msg").offset().top
      }, 2000);
    } else {
      var sessionid = id;
      var desc = description;
      $.ajax ({
        type: 'POST',
        url: 'submitColor.php',
        data : 'desc='+ desc + '&value='+ value + '&session='+ sessionid,
        success: function(data) {
          window.location.reload();
          window.alert("Your color selection has been successfully submitted!");
        }
      });
    }
  }
  </script>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="page-content">
    <div class="container">
      <?php
      echo "<a class='text-primary' href=\"javascript:history.go(-1)\"><i class='fa fa-arrow-circle-o-left fa-fw'></i> GO BACK</a>";
      ?>
      <div class="card">
        <div class="card-header white-text bg-primary">
          <h4><i class="fa fa-list fa-lg" style="vertical-align:middle"></i> Paint Room Colors</h4>
        </div>
        <div class="card-block bg-faded">
          <?php
          if(!empty($_GET['id'])) {
            $sessionid = $_GET['id'];
            $query = mysqli_query($dbc, "SELECT * FROM Sessions WHERE id = '$sessionid'");
            if(mysqli_num_rows($query) != 0) {
              while($row = mysqli_fetch_array($query)) {
                $sessionname = $row['name'];
                $sessionid = $row['id'];
                }
              }
            }
            ?>
            <div id="result-msg" class="text-center">

            </div>

              <div class="list-group">
                <div class="list-group-item bg-faded justify-content-between">
                  <p class="text-danger" style="margin: 0px; font-size: 13px; font-weight: bold;">
                    Items in red have not been submitted with color values
                  </p>
                  <p class="text-success" style="margin: 0px; font-size: 13px; font-weight: bold;">
                    Items in green have been submitted with color values
                  </p>
                </div>
              <?php
                $queryPaint = mysqli_query($dbc, "SELECT * FROM Paint WHERE session_id_fk = '$sessionid';");
                $count = 0;
                while($row = mysqli_fetch_array($queryPaint)) {
                  $count++;
                  $paintDescription = $row['description'];
                  $paintId = $row['id'];
                  $isCompleted = $row['isCompleted'];
                  if($isCompleted == '1') {
                    $colorvalue = $row['color'];
                    echo '<div class="list-group-item">
                    <div class="col col-md-4">
                    <h4 class="text-success" style="margin-bottom: 0px;">'.$paintDescription.'</h4>
                    <div id="hex-str'.$count.'">
                    </div>
                    </div>
                    <div class="col col-md-4 text-center">
                    <input class="jscolor {onFineChange:\'update(this, '.$count.')\'}" value="'.$colorvalue.'">
                    </div>
                    <div class="col col-md-4 text-right">
                    <button type="button" class="btn btn-outline btn-outline-warning waves-effect btn-sm" onclick="submit(\''.$paintDescription.'\', \''.$sessionid.'\', \''.$count.'\')">Change</button>
                    </div>
                    </div>';
                  } else {
                    echo '<div class="list-group-item">
                    <div class="col col-md-4">
                    <h4 class="text-danger" style="margin-bottom: 0px;">'.$paintDescription.'</h4>
                    <div id="hex-str'.$count.'">
                    </div>
                    </div>
                    <div class="col col-md-4 text-center">
                    <input class="jscolor {onFineChange:\'update(this, '.$count.')\'}" value="FFFFFF">
                    </div>
                    <div class="col col-md-4 text-right">
                    <button type="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm" onclick="submit(\''.$paintDescription.'\', \''.$sessionid.'\', \''.$count.'\')">Submit</button>
                    </div>
                    </div>';
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
