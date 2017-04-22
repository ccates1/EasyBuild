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
  <div class="container">
    <?php /*echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';*/ ?>
    <div class="page-content">
      <div class="row justify-content-center">
        <div class="card">
          <div class="card-header bg-primary white-text">
            <h4><i class="fa fa-user-circle-o fa-fw"></i> Welcome, <?php echo "".$_SESSION['username'].""; ?></h4>
          </div>
          <div class="card-body" style="padding: 15px;">
            <?php
            if($_SESSION['user_type'] == "owner") {
              $isbuilder = false;
              $id = $_SESSION['user_id'];
              $query = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN Builders ON Sessions.builder_id = Builders.id;");
            } else {
              $isbuilder = true;
              $id = $_SESSION['user_id'];
              $query = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN Owners ON Sessions.owner_id = Owners.id;");
            }
            ?>
            <div class="text-center">
              <legend style="color: #000;">
                Your Active Sessions
              </legend>
              <table class="table table-bordered">
                <thead class="bg-primary white-text">
                  <tr>
                    <th class="text-center">
                      Session Name <i class="white-text fa fa-info-circle fa-fw"></i>
                    </th>
                    <th class="text-center">
                      Connected User <i class="white-text fa fa-handshake-o fa-fw"></i>
                    </th>
                    <th class="text-center">
                      Connected User Email <i class="white-text fa fa-at fa-fw"></i>
                    </th>
                    <th>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(mysqli_num_rows($query) != 0) { ?>
                  <?php while($row = mysqli_fetch_array($query)) { ?>
                  <tr class="text-center">
                    <td>
                      <?php echo $row['name']; ?>
                    </td>
                    <td>
                      <?php echo $row['username']; ?>
                    </td>
                    <td>
                      <?php echo $row['email']; ?>
                    </td>
                    <td>
                      <?php $sessionidentifier = $row['id']; ?>
                      <a role="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm" href="session.php?id=<?php echo $sessionidentifier; ?>">GO</a>
                    </td>
                  </tr>
                  <?php } } else {
                    ?>
                    <tr class="text-center">
                      <td colspan="4">
                        No sessions found
                      </td>
                    </tr>
                  <?php
                  }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> <!-- row -->

    </div>
  </div>
  <?php include('scripts.html'); ?>
</body>

</html>
