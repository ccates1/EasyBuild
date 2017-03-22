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
  <?php
    /*$errors = array();
    function sendConnection($recipientusername, $recipientemail, $recipienttype, $sessionname) {
      if($recipienttype == 'Builder') {
        $isbuilder = true;
        $query = mysqli_query("SELECT * FROM Builders WHERE username = $recipientUsername");
      } else {
        $isbuilder = false;
        $query = mysqli_query("SELECT * FROM Owners WHERE username = $recipientUsername");
      }
      if(mysqli_num_rows($query) != 0) {
        while($row = mysqli_fetch_array($query)) {
          $dbrecipientid = $row['id'];
          $senderid = $_SESSION['user_id'];
        }
        if($isBuilder == true) {
          $query2 = mysqli_query("INSERT INTO Sessions (`name`, `owner_id`, `builder_id`) VALUES ('".$sessionname."', '".$senderid."', '".$dbrecipientid."');");
          $query3 = mysqli_query("INSERT INTO ChecklistItems (`session_id`, `description`) VALUES (SELECT(id FROM Sessions WHERE name = '$sessionname)'), ")

        } else {
          $query2 = mysqli_query("INSERT INTO Sessions (`name`, `owner_id`, `builder_id`) VALUES ('".$sessionName."', '".$dbrecipientid."', '".$senderid."');");
        }
        $query2 = mysqli_query("INSERT INTO Sessions (`name`, `owner_id`, `builder_id`, `checklist_id`) VALUES ('".$sessionName."', '".$."')")
      } else {
        $errors[] = "Could not retrieve the requested data at this time.";
      }
    }*/
  ?>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="container">
    <div class="page-content">
      <div class="card">
        <div class="card-block">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="searchForm">
            <div class="row">
              <div class="form-control text-center" style="border: 0px;">
                <legend style="color: #000;">
                  Are you searching for a home owner or builder?
                </legend>
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary">
                    <input type="radio" name="user_type" id="builder" value="builder">Builder <i class="fa fa-wrench fa-fw"></i>
                  </label>
                  <label class="btn btn-primary">
                    <input type="radio" name="user_type" id="owner" value="owner" >Home Owner <i class="fa fa-home fa-fw"></i>
                  </label>
                </div>
              </div>
            </div>
            <div class="md-form">
              <i class="fa fa-search prefix"></i>
              <input type="text" id="search" class="form-control" name="search">
              <label for="search">Search for Builder</label>
            </div>
            <button type="submit" class="btn bg-primary btn-block">Submit Search</button>
          </form>
          <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
              $errors = array();
              $search = $_POST['search'];
              if(isset($_POST['user_type'])) {
                $user_type = $_POST['user_type'];
              } else {
                $errors[] = "Please select which type of user you are searching for!";
              }
              if(!empty($search) && !empty($user_type)) {
                if($user_type == "builder") {
                  $query = mysqli_query($dbc, "SELECT * FROM Builders WHERE username = '$search' OR email = '$search'");
                } else {
                  $query = mysqli_query($dbc, "SELECT * FROM Owners WHERE username = '$search' OR email = '$search'");
                }
                if(mysqli_num_rows($query) != 0) {
                  // Searched by the username
                  while($row = mysqli_fetch_array($query)) {
                    $dbusername = mysql_real_escape_string($row['username']);
                    $dbemail = mysql_real_escape_string($row['email']);
                    found($dbusername, $dbemail, $user_type);
                  }
                } else {
                  // Username and email was not found
                  $errors[] = "There is no user with the provided credentials!";
                }
              } else {
                if(empty($search)) {
                  $errors[] = "Please enter a username to search!";
                }
              }
              if(!empty($errors)) {
                notFound($search);
              }
            }
          ?>
          <div class="row">
              <?php
              function found($username, $email, $user_type) {
                echo "<div class='col-xs-12'>
                <div class='text-center'>
                <div class='alert alert-success' role='alert'>
                <strong>User Found!</strong> <br />
                <i class='fa fa-user-circle-o fa-fw'></i> Username: ".$username." <br />
                <i class='fa fa-at fa-fw'></i> Email: ".$email." <br />
                <input type='text' class='form-control' placeholder='Please enter a name for your builder/home owner session here' name='sessionName' />
                <button type='button' class='btn btn-info' onclick='sendConnection($username, $email, $user_type, sessionName)'>Send Connection! <i class='fa fa-envelope-o fa-fw'></i></button>
                </div>
                </div>";
              }
              function notFound($search) {
                echo "<div class='col-xs-12'>
                <div class='text-center'>
                <div class='alert alert-danger' role='alert'>
                <strong>User Not Found!</strong> <br />
                <i class='fa fa-times fa-fw'></i> ".$search." was not found within the system! <i class='fa fa-times fa-fw'></i><br />
                </div>
                </div>";
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
