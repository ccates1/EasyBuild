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
            $id = $_SESSION['user_id'];
            $email = $_SESSION['email'];
            $username = $_SESSION['username'];
            $user_type = $_SESSION['user_type'];
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
                  <?php
                  $empty = true;
                  if($user_type == "builder") {
                    $sql = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN Owners WHERE Sessions.builder_id = '$id' AND Owners.id = Sessions.owner_id;");
                    if(mysqli_num_rows($sql) != 0) {
                      $empty = false;
                      while($row = mysqli_fetch_array($sql)) {
                        $session_name = $row['name'];
                        $session_id = $row['id'];
                        $owner_username = $row['username'];
                        $owner_email = $row['email'];
                        echo '<tr class="text-center">
                        <td>
                        '.$session_name.'
                        </td>
                        <td>
                        '.$owner_username.'
                        </td>
                        <td>
                        '.$owner_email.'
                        </td>
                        <td>
                        <a role="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm" href="session.php?id='.$session_id.'">GO</a>
                        </td>
                        </tr>';
                      }
                    }
                  } else {
                    $sql = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN Builders WHERE Sessions.owner_id = '$id' AND Builders.id = Sessions.builder_id;");
                    if(mysqli_num_rows($sql) != 0) {
                      $empty = false;
                      while($row = mysqli_fetch_array($sql)) {
                        $session_name = $row['name'];
                        $session_id = $row['id'];
                        $builder_username = $row['username'];
                        $builder_email = $row['email'];
                        echo '<tr class="text-center">
                        <td>
                        '.$session_name.'
                        </td>
                        <td>
                        '.$builder_username.'
                        </td>
                        <td>
                        '.$builder_email.'
                        </td>
                        <td>
                        <a role="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm" href="session.php?id='.$session_id.'">GO</a>
                        </td>
                        </tr>';
                      }
                    }
                  }
                  if($empty == true) {
                    echo '<tr class="text-center">
                    <td colspan="4">
                    No sessions found
                    </td>
                    </tr>';
                  }
                  ?>

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
