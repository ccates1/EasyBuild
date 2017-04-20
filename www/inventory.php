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
    <div class="page-content">
      <div class="container">
        <div class="card">
          <div class="card-header bg-primary white-text">
            <h4><i class="fa fa-check-square-o fa-fw"></i> Inventory</h4>
          </div>
          <div class="card-block">
            <div class="list-group">
              <div class="list-group-item">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
