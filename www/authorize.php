<?php
  include("connection.php");
?>
<html>
  <head>
    <?php include("head.html"); ?>
  </head>
  <body>
    <div class="container">
      <?php include("nav.html"); ?>
      <div class="page-content">
        <div class="card card-login">
          <div class="card-header">
            <div class="row">
              <div class="col-6 text-center">
                <a href="#" class="active" id="login-form-link"><h3>Login</h3></a>
              </div>
              <div class="col-6 text-center">
                <a href="#" id="register-form-link"><h3>Register</h3></a>
              </div>
            </div>
          </div>
          <div class="card-block">
            <form class="active" id="login-form" method="post" action="login.php">
              <div class="md-form">
                <i class="fa fa-user prefix"></i>
                <input type="text" id="username" class="form-control" />
                <label for="username">Username</label>
              </div>
              <div class="md-form">
                <i class="fa fa-lock prefix"></i>
                <input type="password" id="password" class="form-control" />
                <label for="password">Password</label>
              </div>
              <button class="btn btn-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
            </form>
            <form class="" id="register-form" method="post" action="register.php" >
              <div class="md-form">
                <i class="fa fa-at prefix"></i>
                <input type="email" id="email" class="form-control" />
                <label for="email">Email</label>
              </div>
              <div class="md-form">
                <i class="fa fa-user prefix"></i>
                <input type="text" id="username" class="form-control" />
                <label for="username">Username</label>
              </div>
              <div class="md-form">
                <i class="fa fa-lock prefix"></i>
                <input type="password" id="password" class="form-control" />
                <label for="password">Password</label>
              </div>
              <button class="btn btn-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
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
