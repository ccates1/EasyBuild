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
  <?php
    
  ?>
  <div class="container">
    <div class="page-content">
      <div class="card">
        <div class="card-block">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
              <div class="col-sm-8">
                <div class="md-form">
                  <i class="fa fa-search prefix"></i>
                  <input type="text" id="search" class="form-control" name="search">
                  <label for="search">Search for Builder</label>
                </div>
              </div>
              <div class="col-sm-4 text-center">
                <button type="submit" class="btn btn-primary">Search</button>
              </div>
            </div>
          </form>
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
