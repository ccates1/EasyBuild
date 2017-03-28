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
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="container">
    <div class="page-content">
      <div class="card">
        <div class="card-header bg-primary white-text">
          Session Creation
        </div>
        <div class="card-block">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="searchForm">
            <div class="md-form">
              <i class="fa fa-search prefix"></i>
              <input type="text" id="search" class="form-control" name="search">
              <label for="search">Search for User to Connect With</label>
            </div>
            <div class="form-control text-center" style="border: 0px;">
              <legend style="color: #000; border-bottom: 0px !important;">
                Are you searching for a home owner or builder?
              </legend>
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-warning">
                  <input type="radio" name="user_type" id="builder" value="builder">Builder <i class="fa fa-wrench fa-fw"></i>
                </label>
                <label class="btn btn-warning">
                  <input type="radio" name="user_type" id="owner" value="owner" >Home Owner <i class="fa fa-home fa-fw"></i>
                </label>
              </div>
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
                echo '<div class="text-center">
                <strong>Error! The following error(s) occurred:</strong> <br />';
                foreach($errors as $msg){
                  echo $msg.'<br />';
                }
                '</div>';
                notFound($search);
              }
            }
          ?>
          <div class="row">
              <?php
              function found($username, $email, $user_type) {
                echo "
                <div class='alert alert-success' role='alert'>
                <form method='post' action='connectionSession.php'>
                <input type='hidden' name='username' class='hidden' value=".$username." />
                <input type='hidden' name='email' class='hidden' value=".$email." />
                <input type='hidden' name='user_type' class='hidden' value=".$user_type." />
                <div class='text-center'>
                <strong>User Found!</strong> <br />
                <i class='fa fa-user-circle-o fa-fw'></i> Username: ".$username." <br />
                <i class='fa fa-at fa-fw'></i> Email: ".$email." <br />
                </div>
                <div class='row'>
                <div class='col-md-8 offset-md-2'>
                <div class='md-form' style='margin-top: 15px;'>
                <i class='fa fa-info-circle prefix'></i>
                <input type='text'id='sessionname' class='form-control' name='sessionname' />
                <label for='sessionname'>Session Name</label>
                <div class='text-center'>
                <p >*A Session Name is Required</p>
                </div>

                </div>
                </div>
                </div>
                <div class='text-center'>
                <button type='submit' class='btn btn-success'>Send Connection! <i class='fa fa-envelope-o fa-fw'></i></button>
                </div>
                </div>
                </form>
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
