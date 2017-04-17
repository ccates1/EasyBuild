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
    <div class="page-content" style="padding-left: 25px; padding-right: 25px;">
        </div>
        <div class="card-block">
          <form class="active" id="login-form" method="post" action="accountEdit.php">
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="username" class="form-control" />
              <label for="username">Username</label>
            </div>
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="username" class="form-control" />
              <label for="username">Email</label>
            </div>
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="email" class="form-control" />
              <label for="username">Confirm New Email</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password" name="password" class="form-control" />
              <label for="password">Password</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password" name="password" class="form-control" />
              <label for="password">Confirm New Password</label>
            </div>
            </div>
            <button type="submit" class="btn bg-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
          </form>
        </div>
      </div>
        <?php include('scripts.html'); ?>
    </body>
</html>