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
  <div class="page-content">

    <?php
      if(!empty($_GET['id'])) {
        $sessionid = $_GET['id'];
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
        $query = mysqli_query($dbc, "SELECT * FROM Messages WHERE session_id = '$sessionid';");
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
        <div class="card-header white-text bg-primary">
          <i class="fa fa-list fa-lg"></i> <?php echo $sessionname; ?>
        </div>
        <div class="card-block bg-faded">
          <ul class="media-list center-block">
            <div class="message-content">
              <h4 style="font-weight: 600">Post New Message:</h4>
              <form id="message-form" method="post" action="message.php">
                <div class="md-form" style="margin-top: 20px;">
                  <input type="text" id="content" name="content" class="form-control" />
                  <label for="content">Insert Message Here</label>
                </div>
                <button type="submit" class="btn btn-warning waves-effect">Submit</button>
              </form>
            </div>
          <?php
            $query = mysqli_query($dbc, "SELECT * FROM Messages WHERE session_id = '$sessionid';");
            if(mysqli_num_rows($query) != 0) {
              while($row = mysqli_fetch_array($query)) {
                $sender = $row['sender'];
                $user_type = $row['user_type'];
                $content = $row['content'];
          ?>
            <div class="message-content">
              <div class="media">
                <?php
                  if($user_type=="builder") {
                ?>
                <img class="d-flex mr-3" src="png/builder.png" style="max-width: 65px;" alt="">
                <?php
                  } else {
                ?>
                <img class="d-flex mr-3" src="png/owner.png" style="max-width: 65px;" alt="">
                <?php
                  }
                ?>
                <div class="media-body">
                  <h5 class="mt-0"><?php echo $sender; ?></h5>
                  <?php echo $content; ?>
                </div>
              </div>
            </div>
          <?php
              }
            } else {
          ?>
          <div class="message-content">
            <strong>No messages have been posted for this session yet.</strong>
          </div>
          <?php
            }
          ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <?php include('scripts.html'); ?>
</body>

</html>
