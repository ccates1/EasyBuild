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
  <?php include('nav.html'); ?>

  <div class="container">
    <div class="page-content" >
      <div class="card">
        <div class="card-header white-text bg-primary">
          <h4><i class="fa fa-info fa-fw"></i> Account Information</h4>
        </div>
        <div class="card-block">
          <div class="row" style="margin-bottom: 10px;" id="account-details">
            <div class="col list-group-item bg-warning-custom white-text underly-shadow">
              <i class="fa fa-user-circle-o fa-fw"></i> Username: <?php echo $_SESSION['username']; ?>
            </div>
            <div class="col list-group-item bg-warning-custom white-text underly-shadow">
              <i class="fa fa-at fa-fw"></i> Email: <?php echo $_SESSION['email']; ?>
            </div>
            <div class="col list-group-item bg-warning-custom white-text underly-shadow">
              <i class="fa fa-star fa-fw"></i> Type of User: <?php echo $_SESSION['user_type']; ?>
            </div>
          </div>
          <hr />
          <form class="active" id="login-form" method="post" action="accountEdit.php">
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="username" class="form-control" />
              <label for="username">Change Username</label>
            </div>
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="username" class="form-control" />
              <label for="username">Change Email</label>
            </div>
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="email" class="form-control" />
              <label for="username">Confirm New Email</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password" name="password" class="form-control" />
              <label for="password">Change Password</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password" name="password" class="form-control" />
              <label for="password">Confirm New Password</label>
            </div>
            <button type="submit" class="btn bg-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include('scripts.html'); ?>
</body>
</html>
