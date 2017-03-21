<?php
session_start();
include('connection.php');
if (empty($_SESSION['username'])) {
  header('location: index.php');
};
?>
<html>
<head>
  <?php include('head.html'); ?>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="container">
    <?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?>

    <div class="page-content">
      <div class="row justify-content-center">
        <div class="card">
          <div class="card-header bg-primary white-text">
            <h4>Welcome, <?php echo "".$_SESSION['username'].""; ?> <i class="fa fa-user-circle-o fa-fw"></i></h4>
          </div>
          <div class="card-body card-margin">
            <div class="card-deck-wrapper">
              <div class="card-deck">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-block danger-color text-center white-text">
                      <h4 class="card-title">Inventory</h4>
                      <p class="card-text">
                        <button type="button" class="btn btn-outline btn-outline-danger waves-effect btn-sm">Access</button>
                      </p>
                    </div>
                    <div class="card-footer danger-color-dark" id="footer">
                      <small class="ellipsis white-text">Last updated 3 mins ago</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-block info-color text-center white-text">
                      <h4 class="card-title">Order Status</h4>
                      <p class="card-text">
                        <button type="button" class="btn btn-outline btn-outline-info waves-effect btn-sm">Access</button>
                      </p>
                    </div>
                    <div class="card-footer info-color-dark" id="footer">
                      <small class="ellipsis white-text">Last updated 3 mins ago</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-block warning-color text-center white-text">
                      <h4 class="card-title">Floor Plan</h4>
                      <p class="card-text">
                        <button type="button" class="btn btn-outline btn-outline-warning waves-effect btn-sm">Access</button>
                      </p>
                    </div>
                    <div class="card-footer warning-color-dark" id="footer">
                      <small class="ellipsis white-text">Last updated 3 mins ago</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-block success-color text-center white-text">
                      <h4 class="card-title">Account</h4>
                      <p class="card-text">
                        <button type="button" class="btn btn-outline btn-outline-success waves-effect btn-sm">Access</button>
                      </p>
                    </div>
                    <div class="card-footer success-color-dark" id="footer">
                      <small class="ellipsis white-text">Last updated 3 mins ago</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <?php include('scripts.html'); ?>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
  <script type="text/javascript">
  $('.card').matchHeight();
  </script>
</body>

</html>
