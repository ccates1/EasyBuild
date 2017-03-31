<?php
include("connection.php");
session_start();
?>
<html>
<head>
  <?php include("head.html"); ?>
</head>
<body>
  <?php include("unauthorized-nav.html"); ?>
  <div class="container">
    <div class="page-content" style="padding-left: 25px; padding-right: 25px;">
      <div class="card z-depth-3">
        <div class="card-header white-text bg-primary">
          <div class="row">
            <div class="col-6 text-center">
              <a href="#" class="active" id="login-form-link"><h3>Login</h3></a>
            </div>
            <div class="col-6 text-center">
              <a href="#" class="register" id="register-form-link"><h3>Register</h3></a>
            </div>
          </div>
        </div>
        <div class="card-block">
          <form class="active" id="login-form" method="post" action="login.php">
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="username" class="form-control" />
              <label for="username">Username</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password" name="password" class="form-control" />
              <label for="password">Password</label>
            </div>
            <div class="row">
              <div class="form-control text-center" style="border: 0px;">
                <legend style="color: #000;">
                  Are you a home owner or builder?
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
            <button type="submit" class="btn bg-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
          </form>
          <form class="" id="register-form" name="registrationForm" method="post" action="register.php" >
            <div class="md-form">
              <i class="fa fa-at prefix"></i>
              <input type="email" id="email" name="email" class="form-control" />
              <label for="email">Email</label>
            </div>
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username" name="username" class="form-control" />
              <label for="username">Username</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password" name="password" class="form-control" />
              <label for="password">Password</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="confirm-password" name="confirm-password" class="form-control" />
              <label for="confirm-password">Confirm Password</label>
            </div>
            <div class="row">
              <div class="form-control text-center" style="border: 0px;">
                <legend style="color: #000;">
                  Are you a home owner or builder?
                </legend>
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary">
                    <input type="radio" name="selection" id="builder" value="builder">Builder <i class="fa fa-wrench fa-fw"></i>
                  </label>
                  <label class="btn btn-primary">
                    <input type="radio" name="selection" id="owner" value="owner" >Home Owner <i class="fa fa-home fa-fw"></i>
                  </label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn bg-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include("scripts.html"); ?>
  <script type="text/javascript">
  $(function () {
    $('#login-form-link').click(function (e) {
      $("#login-form").fadeIn(300);
      $("#register-form").fadeOut(300);
      $('#register-form-link').removeClass('active');
      $(this).addClass('active');
      $('#login-form').addClass('active');
      $('#register-form').removeClass('active');
      e.preventDefault();
    });
    $('#register-form-link').click(function (e) {
      $("#register-form").fadeIn(300);
      $("#login-form").fadeOut(300);
      $('#login-form-link').removeClass('active');
      $(this).addClass('active');
      $('#register-form').addClass('active');
      $('#login-form').removeClass('active');
      e.preventDefault();
    });

  });
  </script>
</body>
</html>
