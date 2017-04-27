<?php
include("connection.php");
session_start();
?>
<html>
<head>
  <?php include("head.html"); ?>
  <script type="text/javascript">
    var selection = "";
    jQuery(document).ready(function($) {

      $("#builder-login-btn").click(function() {
        var builder = document.getElementById("builder-login").value;
        selection = builder;
      });
      $("#owner-login-btn").click(function() {
        var owner = document.getElementById("owner-login").value;
        selection = owner;
      });
      $("#login-submit").click(function(e) {
        var username = document.getElementById("username-login").value;
        var password = document.getElementById("password-login").value;
        var msg = "";
        if(!username) {
          msg = 'Please enter a username!';
          document.getElementById("result-msg").innerHTML = msg;
          e.preventDefault();
          return;
        }
        if(!password) {
          msg = 'Please enter a password!';
          document.getElementById("result-msg").innerHTML = msg;
          e.preventDefault();
          return;
        }
        if(selection == "") {
          msg = 'Please select a type of user!';
          document.getElementById("result-msg").innerHTML = msg;
          e.preventDefault();
          return;
        }
        if(msg == "") {

          $.ajax({
            type: 'POST',
            url: 'login.php',
            data : 'username='+ username + '&password='+ password + '&user_type=' + selection,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(errorThrown);
              window.alert("Something unexpected happened. Please try again later!");
            },
            success: function(data) {
              if(data[0] == "Success") {
                username = "";
                password = "";
                window.location.href = "home.php";
              } else {
                var result = document.getElementById("result-msg");
                var errors = "";
                data.forEach(function(item) {
                  errors += item + "<br />";
                });
                result.innerHTML = errors;
              }
            }
          });
        }

      });

      $("#builder-register-btn").click(function() {
        var builder = document.getElementById("builder-register").value;
        selection = builder;
      });
      $("#owner-register-btn").click(function() {
        var owner = document.getElementById("owner-register").value;
        selection = owner;
      });
      $("#register-submit").click(function() {
        var username = document.getElementById("username-register").value;
        var email = document.getElementById("email-register").value;
        var password = document.getElementById("password-register").value;
        var confirmPassword = document.getElementById("confirm-password-register").value;
        var msg = "";
        if(!username) {
          msg = 'Please enter a username!';
          document.getElementById("result-msg").innerHTML = msg;
          return;
        }
        if(!email) {
          msg = 'Please enter a email!';
          document.getElementById("result-msg").innerHTML = msg;
          return;
        }
        if(!password) {
          msg = 'Please enter a password!';
          document.getElementById("result-msg").innerHTML = msg;
          return;
        }
        if(password != confirmPassword) {
          msg = 'Passwords do not match!';
          document.getElementById("result-msg").innerHTML = msg;
          return;
        }
        if(selection == "") {
          msg = 'Please select a type of user!';
          document.getElementById("result-msg").innerHTML = msg;
          return;
        }
        if(msg == "") {
 
          $.ajax({
            type: 'POST',
            url: 'register.php',
            data : 'username='+ username + '&email=' + email +
             '&password=' + password + '&user_type='+ selection,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(errorThrown);
              window.alert("Something unexpected happened. Please try again later!");
            },
            success: function(data) {
              if(data[0] == "Success") {
                username = "";
                email = "";
                password = "";
                confirmPassword = "";
                window.location.href = "home.php";
              } else {
                var result = document.getElementById("result-msg");
                var errors = "";
                data.forEach(function(item) {
                  errors += item + "<br />";
                });
                result.innerHTML = errors;
              }
            }
          });
        }

      });
    });
  </script>
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
          <div id="result-msg" class="text-center text-danger">

          </div>
          <div class="active" id="login-form" >
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username-login" name="username-login" class="form-control" />
              <label for="username">Username</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password-login" name="password-login" class="form-control" />
              <label for="password">Password</label>
            </div>
            <div class="row">
              <div class="form-control text-center" style="border: 0px;">
                <legend style="color: #000;">
                  Are you a home owner or builder?
                </legend>
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" id="builder-login-btn" style="box-shadow: 0px;">
                    <input type="radio" name="user_type" id="builder-login" value="builder">Builder <i class="fa fa-wrench fa-fw"></i>
                  </label>
                  <label class="btn btn-primary" id="owner-login-btn" style="box-shadow: 0px;">
                    <input type="radio" name="user_type" id="owner-login" value="owner" >Home Owner <i class="fa fa-home fa-fw"></i>
                  </label>
                </div>
              </div>
            </div>
            <button type="button" id="login-submit" class="btn bg-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
          </div>
          <div class="" id="register-form" name="registrationForm" >
            <div class="md-form">
              <i class="fa fa-at prefix"></i>
              <input type="email" id="email-register" name="email-register" class="form-control" />
              <label for="email">Email</label>
            </div>
            <div class="md-form">
              <i class="fa fa-user prefix"></i>
              <input type="text" id="username-register" name="username-register" class="form-control" />
              <label for="username">Username</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="password-register" name="password-register" class="form-control" />
              <label for="password">Password</label>
            </div>
            <div class="md-form">
              <i class="fa fa-lock prefix"></i>
              <input type="password" id="confirm-password-register" name="confirm-password-register" class="form-control" />
              <label for="confirm-password">Confirm Password</label>
            </div>
            <div class="row">
              <div class="form-control text-center" style="border: 0px;">
                <legend style="color: #000;">
                  Are you a home owner or builder?
                </legend>
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" id="builder-register-btn" style="box-shadow: 0px;">
                    <input type="radio" name="selection" id="builder-register" value="builder">Builder <i class="fa fa-wrench fa-fw"></i>
                  </label>
                  <label class="btn btn-primary" id="owner-register-btn" style="box-shadow: 0px;">
                    <input type="radio" name="selection" id="owner-register" value="owner" >Home Owner <i class="fa fa-home fa-fw"></i>
                  </label>
                </div>
              </div>
            </div>
            <button type="button" id="register-submit" class="btn bg-primary btn-rounded btn-block">Submit <i class="fa fa-check fa-fw right"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("scripts.html"); ?>
  <script type="text/javascript">
  $(function () {
    $('#login-form-link').click(function (e) {
      selection = "";
      $("#login-form").fadeIn(300);
      $("#register-form").fadeOut(300);
      $('#register-form-link').removeClass('active');
      $(this).addClass('active');
      $('#login-form').addClass('active');
      $('#register-form').removeClass('active');
      e.preventDefault();
    });
    $('#register-form-link').click(function (e) {
      selection = "";
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
