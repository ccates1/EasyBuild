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
    var usernameEdit = false;
    var emailEdit = false;
    var passwordEdit = false;
    $("#changeUsername").click(function() {
      var checkDisabled = this.className;
      if(checkDisabled.indexOf("btn-primary") !== -1) {
        usernameEdit = true;
        $("#username").removeAttr("disabled");
        $("#submit").removeAttr("disabled");
        $("#changeUsername").removeClass("btn-primary");
        $("#changeUsername").addClass("btn-danger");
        $("#changeUsername").html("Cancel");
        $("#changeUsernameActive").removeClass('hidden');
      } else {
        usernameEdit = false;
        $("#username").attr("disabled", true);
        $("#changeUsername").removeClass("btn-danger");
        $("#changeUsername").addClass("btn-primary");
        $("#changeUsername").html("Edit");
        $("#changeUsernameActive").addClass('hidden');
        if(usernameEdit === false && emailEdit === false && passwordEdit === false) {
          $("#submit").attr("disabled", true);
        }
      }
    });
    $("#changeEmail").click(function() {
      var checkDisabled = this.className;
      if(checkDisabled.indexOf("btn-primary") !== -1) {
        emailEdit = true;
        $("#email").removeAttr("disabled");
        $("#submit").removeAttr("disabled");
        $("#changeEmail").removeClass("btn-primary");
        $("#changeEmail").addClass("btn-danger");
        $("#changeEmail").html("Cancel");
        $("#changeEmailActive").removeClass('hidden');
      } else {
        emailEdit = false;
        $("#email").attr("disabled", true);
        $("#changeEmail").removeClass("btn-danger");
        $("#changeEmail").addClass("btn-primary");
        $("#changeEmail").html("Edit");
        $("#changeEmailActive").addClass('hidden');
        if(usernameEdit === false && emailEdit === false && passwordEdit === false) {
          $("#submit").attr("disabled", true);
        }
      }
    });
    $("#changePassword").click(function() {
      var checkDisabled = this.className;
      if(checkDisabled.indexOf("btn-primary") !== -1) {
        passwordEdit = true;
        $("#password").removeAttr("disabled");
        $("#submit").removeAttr("disabled");
        $("#changePassword").removeClass("btn-primary");
        $("#changePassword").addClass("btn-danger");
        $("#changePassword").html("Cancel");
        $("#changePasswordActive").removeClass('hidden');
      } else {
        passwordEdit = false;
        $("#password").attr("disabled", true);
        $("#changePassword").removeClass("btn-danger");
        $("#changePassword").addClass("btn-primary");
        $("#changePassword").html("Edit");
        $("#changePasswordActive").addClass('hidden');
        if(usernameEdit === false && emailEdit === false && passwordEdit === false) {
          $("#submit").attr("disabled", true);
        }
      }
    });
    $("#submit").click(function(e) {
      var username = document.getElementById('username');
      var confirmUsername = document.getElementById('confirmUsername');
      var email = document.getElementById('email');
      var confirmEmail = document.getElementById('confirmEmail');
      var password = document.getElementById('password');
      var confirmPassword = document.getElementById('confirmPassword');
      if(usernameEdit === true) {
        if(username.value != confirmUsername.value) {
          window.alert("Usernames don't match!");
          e.preventDefault();
          return;
        }
      }
      if(emailEdit === true) {
        if(email.value != confirmEmail.value) {
          window.alert("Emails don't match!");
          e.preventDefault();
          return;
        }
      }
      if(passwordEdit === true) {
        if(password.value != confirmPassword.value) {
          window.alert("Passwords don't match!");
          e.preventDefault();
          return;
        }
      }
      if(usernameEdit === true || emailEdit === true || passwordEdit === true) {
        var currentUsername = document.getElementById('currentUsername');
        var userType = document.getElementById('userType');
        $.ajax({
          type: 'POST',
          url: 'editAccount.php',
          data: 'username=' + username.value + '&currentUsername=' + currentUsername.value + '&email=' + email.value + '&password=' + password.value + '&userType=' + userType.value,
          dataType: "json",
          success: function(data) {
            // window.location.reload();

            if(data.length) {
              if(data.indexOf("Username already exists") != -1 || data.indexOf("Email already exists") != -1) {
                var msg = "<p class='text-danger'>";
              } else {
                var msg = "<p class='text-success'>";
              }
              data.forEach(function(item) {
                msg += item + '<br />';
              });
              msg += "</p>";
              var placeMsg = document.getElementById('success-msg');
              placeMsg.innerHTML = msg;
              $("#submit").attr("disabled", true);
              if(usernameEdit === true) {
                $("#username").attr("disabled", true);
                $("#changeUsername").removeClass("btn-danger");
                $("#changeUsername").addClass("btn-primary");
                $("#changeUsername").html("Edit");
                $("#changeUsernameActive").addClass('hidden');
              }
              if(emailEdit === true) {
                $("#email").attr("disabled", true);
                $("#changeEmail").removeClass("btn-danger");
                $("#changeEmail").addClass("btn-primary");
                $("#changeEmail").html("Edit");
                $("#changeEmailActive").addClass('hidden');
              }
              if(passwordEdit === true) {
                $("#password").attr("disabled", true);
                $("#changePassword").removeClass("btn-danger");
                $("#changePassword").addClass("btn-primary");
                $("#changePassword").html("Edit");
                $("#changePasswordActive").addClass('hidden');
              }
              $('html, body').animate({
                scrollTop: $("#success-msg").offset().top
              }, 2000);
            } else {
              window.alert(data);
            }
          }
        });
      }
    })
  });
  </script>
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
          <div id="success-msg" class="text-center">

          </div>
          <input type="hidden" class="hidden" id="currentUsername" name="currentUsername" value="<?php echo $_SESSION['username']; ?>">
          <input type="hidden" class="hidden" id="userType" name="userType" value="<?php echo $_SESSION['user_type']; ?>">
          <div class="md-form input-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo $_SESSION['username']; ?>" disabled>
            <label for="username"><i class="fa fa-user-o fa-fw"></i> Username</label>
            <button type="button" id="changeUsername" class="input-group-addon btn btn-primary">Edit</button>
          </div>
          <div id="changeUsernameActive" class="hidden">
            <div class="md-form">
              <input type="text" name="confirmUsername" id="confirmUsername" class="form-control" />
              <label for="confirmUsername">Confirm New Username</label>
            </div>
          </div>
          <div class="md-form input-group">
            <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo $_SESSION['email']; ?>" disabled>
            <label for="username"><i class="fa fa-at fa-fw"></i> Email</label>
            <button type="button" id="changeEmail" class="input-group-addon btn btn-primary">Edit</button>
          </div>
          <div id="changeEmailActive" class="hidden">
            <div class="md-form">
              <input type="text" name="confirmEmail" id="confirmEmail" class="form-control" />
              <label for="confirmEmail">Confirm New Email</label>
            </div>
          </div>
          <div class="md-form input-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="" disabled>
            <label for="password"><i class="fa fa-lock fa-fw"></i> Password</label>
            <button type="button" id="changePassword" class="input-group-addon btn btn-primary">Edit</button>
          </div>
          <div id="changePasswordActive" class="hidden">
            <div class="md-form">
              <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" />
              <label for="confirmPassword">Confirm New Password</label>
            </div>
          </div>
          <button type="button" id="submit" class="btn bg-primary btn-rounded btn-block" disabled>Submit <i class="fa fa-check fa-fw right"></i></button>
        </div>
      </div>
    </div>
  </div>
  <?php include('scripts.html'); ?>
</body>
</html>
