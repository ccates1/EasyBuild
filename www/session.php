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
  function disable (el) {
    el.checked = true;
    el.setAttribute = "checked";
    el.disabled = true;
  }
  function clicked(id, desc, session, step) {
    var sessionid = session;
    var step = step;
    var getid = id + 1;
    var checkid = 'checkbox' + id;
    document.getElementById(id).disabled = true;
    document.getElementById(getid.toString()).classList.remove('disabler');
    $.ajax({
      type: 'POST',
      url: 'completed.php',
      data : 'rowdesc='+ desc + '&sessionid='+ session + '&step='+ step,
      success: function(data) {
        $('#modalPopup').modal('show');
        $('#fetched-data').html(data);
      }
    });
  }
  </script>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="page-content hidden-md-down">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-4">
          <?php
          if(!empty($_GET['id'])) {
            $sessionid = $_GET['id'];
            $query = mysqli_query($dbc, "SELECT Sessions.name, Sessions.id, Builders.username AS builderusername, Builders.email AS builderemail, Owners.username AS ownerusername, Owners.email AS owneremail FROM Sessions INNER JOIN Builders ON Builders.id = Sessions.builder_id INNER JOIN Owners ON Owners.id = Sessions.owner_id WHERE Sessions.id = '$sessionid'");
            if(mysqli_num_rows($query) != 0) {
              while($row = mysqli_fetch_array($query)) {
                $sessionname = $row['name'];
                $sessionid = $row['id'];
                $buildername = $row['builderusername'];
                $builderemail = $row['builderemail'];
                $ownername = $row['ownerusername'];
                $owneremail = $row['owneremail'];
              }
              echo '
              <div class="card z-index-5">
              <div class="card-block white-text warning-color">
              <h4 class="card-title" style="font-size: 1.25rem;">Builder Information <i class="fa fa-wrench fa-fw"></i></h4>
              <div class="list-group list-group-flush card-body" style="color:#2d2e2e;">
              <div class="list-group-item">
              <i class="fa fa-user-o fa-fw"></i> Username: '.$buildername.'
              </div>
              <div class="list-group-item">
              <i class="fa fa-at fa-fw"></i> Email: '.$builderemail.'
              </div>
              </div>
              </div>
              </div>
              <hr  />
              <div class="card z-index-5">
              <div class="card-block white-text bg-primary">
              <h4 class="card-title" style="font-size: 1.25rem;">Owner Information <i class="fa fa-home fa-fw"></i></h4>
              <div class="list-group list-group-flush card-body" style="color:#2d2e2e;">
              <div class="list-group-item">
              <i class="fa fa-user-o fa-fw"></i> Username: '.$ownername.'
              </div>
              <div class="list-group-item">
              <i class="fa fa-at fa-fw"></i> Email: '.$owneremail.'
              </div>
              </div>
              </div>
              </div>
              <hr  />';
            }
          }
          ?>
          <div class="card equal">
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
          <hr  />
          <div class="card equal">
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
          <hr  />
          <div class="card equal">
            <div class="card-block success-color text-center white-text">
              <h4 class="card-title">Floor Plan</h4>
              <p class="card-text">
                <button type="button" class="btn btn-outline btn-outline-success waves-effect btn-sm">Access</button>
              </p>
            </div>
            <div class="card-footer success-color-dark" id="footer">
              <small class="ellipsis white-text">Last updated 3 mins ago</small>
            </div>
          </div>
        </div>
        <div class="col-8">
          <div class="card" >
            <div class="card-header white-text bg-primary text-center">
              <i class="fa fa-info-circle fa-fw"></i> <?php echo $sessionname; ?>
            </div>
            <div class="card-block bg-faded">
              <section id="cd-timeline" class="cd-container">
                <?php
                if(!empty($_GET['id'])) {
                  $query = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid' AND ChecklistItems.isCompleted = '0';");
                  $query2 = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid' AND ChecklistItems.isCompleted = '1';");
                  if(mysqli_num_rows($query) != 0 || mysqli_num_rows($query2) != 0) {
                    $checkindex = -1;
                    $index = -1;
                    $subindex = -1;
                    while($row = mysqli_fetch_array($query2)) {
                      $checkindex++;
                      $step = $row['step'];
                      $checklistitemdesc = $row['description'];
                      $iscompleted = $row['isCompleted'];
                      $hasSubs = $row['hasSubs'];
                      echo '
                      <div class="cd-timeline-block">
                      <div class="cd-timeline-img cd-picture">
                      <img src="png/check.png" alt="">
                      </div>
                      <div class="cd-timeline-content">
                      <h2>'.$checklistitemdesc.'</h2>
                      <p>
                      <form>
                      <div class="md-form">
                      <input type="text" class="form-control" id="1-message" />
                      <label for="1-message">Leave Message:</label>
                      </div>
                      <div class="form-check">
                      <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" checked disabled="true" />
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description" >Mark Completion</span>
                      </label>
                      </div>
                      </form>
                      </p>
                      <button type="button" class="cd-read-more btn btn-warning">Submit Message</button>
                      <span class="cd-date">Estimated Finish: Jan 2</span>
                      </div>
                      </div>';
                    }
                    while($row = mysqli_fetch_array($query)) {
                      $index++;
                      $step = $row['step'];
                      $checklistitemdesc = $row['description'];
                      $hasSubs = $row['hasSubs'];
                      if($step != '1' && $index != 0) {
                        if($hasSubs == '1') {
                          echo '<div class="cd-timeline-block disabler" id="'.$index.'">
                          <div class="cd-timeline-img cd-picture">
                          <img src="png/blank.png" alt="">
                          </div>
                          <div class="cd-timeline-content">
                          <h2>'.$checklistitemdesc.'</h2>
                          <p>
                          <div class="list-group">';
                          $query3 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '1';");
                          if(mysqli_num_rows($query3) != 0) {
                            while($row = mysqli_fetch_array($query3)) {
                              $subDescription = $row['description'];
                              echo '<div class="list-group-item justify-content-between">
                              '.$subDescription.'
                              <label class="custom-control custom-checkbox align-middle">
                              <input type="checkbox" class="custom-control-input" checked disabled="true" />
                              <span class="custom-control-indicator"></span>
                              </label>
                              </div>';
                            }
                          }
                          $query4 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '0';");
                          if(mysqli_num_rows($query4) != 0) {
                            while($row = mysqli_fetch_array($query4)) {
                              $subDescription = $row['description'];
                              echo '<div class="list-group-item justify-content-between">
                              '.$subDescription.'
                              <label class="custom-control custom-checkbox ">
                              <input type="checkbox" class="custom-control-input"  />
                              <span class="custom-control-indicator"></span>
                              </label>
                              </div>';
                            }
                            echo '</div>
                            </p>
                            <a href="#0" class="cd-read-more btn-info">Submit</a>
                            <span class="cd-date">Estimated Finish: Jan 2</span>
                            </div>
                            </div>';
                          }
                        } else {
                          echo '<div class="cd-timeline-block disabler" id="'.$index.'">
                          <div class="cd-timeline-img cd-picture">
                          <img src="png/blank.png" alt="">
                          </div>
                          <div class="cd-timeline-content">
                          <h2>'.$checklistitemdesc.'</h2>
                          <p>
                          <form>
                          <div class="md-form">
                          <input type="text" class="form-control" id="1-message" disabled/>
                          <label for="1-message">Leave Message:</label>
                          </div>
                          <div class="form-check">
                          <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" onclick="clicked('.$index.', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\')" id="checkbox'.$index.'" disabled>
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description">Mark Completion</span>
                          </label>
                          </div>
                          </form>
                          </p>
                          <button type="button" class="cd-read-more btn btn-warning" disabled>Submit Message</button>
                          <span class="cd-date">Estimated Finish: Jan 2</span>
                          </div>
                          </div>';
                        }
                      } else {
                        if($hasSubs == '1') {
                          echo '<div class="cd-timeline-block" id="'.$index.'">
                          <div class="cd-timeline-img cd-picture">
                          <img src="png/blank.png" alt="">
                          </div>
                          <div class="cd-timeline-content">
                          <h2>'.$checklistitemdesc.'</h2>
                          <p>
                          <div class="list-group">';
                          $query3 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '1';");
                          if(mysqli_num_rows($query3) != 0) {
                            while($row = mysqli_fetch_array($query3)) {
                              $subDescription = $row['description'];
                              echo '<div class="list-group-item justify-content-between">
                              '.$subDescription.'
                              <label class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" checked disabled="true" />
                              <span class="custom-control-indicator"></span>
                              </label>
                              </div>';
                            }
                          }
                          $query4 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '0';");
                          if(mysqli_num_rows($query4) != 0) {
                            while($row = mysqli_fetch_array($query4)) {
                              $subDescription = $row['description'];
                              echo '<div class="list-group-item justify-content-between">
                              '.$subDescription.'
                              <label class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input"  />
                              <span class="custom-control-indicator"></span>
                              </label>
                              </div>';
                            }
                            echo '</div>
                            </p>
                            <a href="#0" class="cd-read-more btn-info">Submit</a>
                            <span class="cd-date">Estimated Finish: Jan 2</span>
                            </div>
                            </div>';
                          }
                        } else {
                          echo '<div class="cd-timeline-block" id="'.$index.'">
                          <div class="cd-timeline-img cd-picture">
                          <img src="png/check.png" alt="">
                          </div>
                          <div class="cd-timeline-content">
                          <h2>'.$checklistitemdesc.'</h2>
                          <p>
                          <form>
                          <div class="md-form">
                          <input type="text" class="form-control" id="1-message" />
                          <label for="1-message">Leave Message:</label>
                          </div>
                          <div class="form-check">
                          <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" onclick="clicked('.$index.', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\'); disable(this);" id="checkbox'.$index.'">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description" >Mark Completion</span>
                          </label>
                          </div>
                          </form>
                          </p>
                          <button type="button" class="cd-read-more btn btn-warning">Submit Message</button>
                          <span class="cd-date">Estimated Finish: Jan 2</span>
                          </div>
                          </div>';
                        }

                      }
                    }
                  }
                }
                ?>
              </section> <!-- cd-timeline -->
              <div class="modal fade" tabindex="-1" role="dialog" id="modalPopup">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Success!</h5>
                      <button type="button" class="close" data-dismiss="modal" >
                      </button>
                    </div>
                    <div class="modal-body">
                      <div id="fetched-data">
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
  </div>
  <div class="page-content hidden-lg-up">
    <?php
    if(!empty($_GET['id'])) {
      $sessionid = $_GET['id'];
      $query = mysqli_query($dbc, "SELECT Sessions.name, Sessions.id, Builders.username AS builderusername, Builders.email AS builderemail, Owners.username AS ownerusername, Owners.email AS owneremail FROM Sessions INNER JOIN Builders ON Builders.id = Sessions.builder_id INNER JOIN Owners ON Owners.id = Sessions.owner_id WHERE Sessions.id = '$sessionid'");
      if(mysqli_num_rows($query) != 0) {
        while($row = mysqli_fetch_array($query)) {
          $sessionname = $row['name'];
          $sessionid = $row['id'];
          $buildername = $row['builderusername'];
          $builderemail = $row['builderemail'];
          $ownername = $row['ownerusername'];
          $owneremail = $row['owneremail'];
        }
    ?>
    <div class="container">
      <div class="card">
        <div class="card-header white-text bg-primary">
          <i class="fa fa-info-circle fa-fw"></i> <?php echo $sessionname; ?>
        </div>
        <div class="card-block bg-faded">
          <?php
              echo '<div class="card-deck">
              <div class="card">
              <div class="card-block white-text warning-color">
              <h4 class="card-title">Builder Information <i class="fa fa-wrench fa-fw"></i></h4>
              <div class="list-group list-group-flush card-body" style="color:#2d2e2e;">
              <div class="list-group-item">
              <i class="fa fa-user-o fa-fw"></i> Username: '.$buildername.'
              </div>
              <div class="list-group-item">
              <i class="fa fa-at fa-fw"></i> Email: '.$builderemail.'
              </div>
              </div>
              </div>
              </div>
              <div class="card">
              <div class="card-block white-text bg-primary">
              <h4 class="card-title">Owner Information <i class="fa fa-home fa-fw"></i></h4>
              <div class="list-group list-group-flush card-body" style="color:#2d2e2e;">
              <div class="list-group-item">
              <i class="fa fa-user-o fa-fw"></i> Username: '.$ownername.'
              </div>
              <div class="list-group-item">
              <i class="fa fa-at fa-fw"></i> Email: '.$owneremail.'
              </div>
              </div>
              </div>
              </div>
              </div>';
            }
          }
          ?>
          <div class="card-margin">
            <div class="card-deck-wrapper">
              <div class="row">
                <div class="col-md-4">
                  <div class="card equal">
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
                <div class="col-md-4">
                  <div class="card equal">
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
                <div class="col-md-4">
                  <div class="card equal">
                    <div class="card-block success-color text-center white-text">
                      <h4 class="card-title">Floor Plan</h4>
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

      <section id="cd-timeline" class="cd-container">
        <?php
        if(!empty($_GET['id'])) {
          $query = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid' AND ChecklistItems.isCompleted = '0';");
          $query2 = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid' AND ChecklistItems.isCompleted = '1';");
          if(mysqli_num_rows($query) != 0 || mysqli_num_rows($query2) != 0) {
            $checkindex = -1;
            $index = -1;
            $subindex = -1;
            while($row = mysqli_fetch_array($query2)) {
              $checkindex++;
              $step = $row['step'];
              $checklistitemdesc = $row['description'];
              $iscompleted = $row['isCompleted'];
              $hasSubs = $row['hasSubs'];
              echo '<div class="cd-timeline-block">
              <div class="cd-timeline-img cd-picture">
              <img src="png/check.png" alt="">
              </div>
              <div class="cd-timeline-content">
              <h2>'.$checklistitemdesc.'</h2>
              <p>
              <form>
              <div class="md-form">
              <input type="text" class="form-control" id="1-message" />
              <label for="1-message">Leave Message:</label>
              </div>
              <div class="form-check">
              <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" checked disabled="true" />
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description" >Mark Completion</span>
              </label>
              </div>
              </form>
              </p>
              <button type="button" class="cd-read-more btn btn-warning">Submit Message</button>
              <span class="cd-date">Estimated Finish: Jan 2</span>
              </div>
              </div>';
            }
            while($row = mysqli_fetch_array($query)) {
              $index++;
              $step = $row['step'];
              $checklistitemdesc = $row['description'];
              $hasSubs = $row['hasSubs'];
              if($step != '1' && $index != 0) {
                if($hasSubs == '1') {
                  echo '<div class="cd-timeline-block disabler" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/blank.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <div class="list-group">';
                  $query3 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '1';");
                  if(mysqli_num_rows($query3) != 0) {
                    while($row = mysqli_fetch_array($query3)) {
                      $subDescription = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subDescription.'
                      <label class="custom-control custom-checkbox align-middle">
                      <input type="checkbox" class="custom-control-input" checked disabled="true" />
                      <span class="custom-control-indicator"></span>
                      </label>
                      </div>';
                    }
                  }
                  $query4 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '0';");
                  if(mysqli_num_rows($query4) != 0) {
                    while($row = mysqli_fetch_array($query4)) {
                      $subDescription = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subDescription.'
                      <label class="custom-control custom-checkbox ">
                      <input type="checkbox" class="custom-control-input"  />
                      <span class="custom-control-indicator"></span>
                      </label>
                      </div>';
                    }
                    echo '</div>
                    </p>
                    <a href="#0" class="cd-read-more btn-info">Submit</a>
                    <span class="cd-date">Estimated Finish: Jan 2</span>
                    </div>
                    </div>';
                  }
                } else {
                  echo '<div class="cd-timeline-block disabler" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/blank.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <form>
                  <div class="md-form">
                  <input type="text" class="form-control" id="1-message" disabled/>
                  <label for="1-message">Leave Message:</label>
                  </div>
                  <div class="form-check">
                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" onclick="clicked('.$index.', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\')" id="checkbox'.$index.'" disabled>
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Mark Completion</span>
                  </label>
                  </div>
                  </form>
                  </p>
                  <button type="button" class="cd-read-more btn btn-warning" disabled>Submit Message</button>
                  <span class="cd-date">Estimated Finish: Jan 2</span>
                  </div>
                  </div>';
                }
              } else {
                if($hasSubs == '1') {
                  echo '<div class="cd-timeline-block" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/blank.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <div class="list-group">';
                  $query3 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '1';");
                  if(mysqli_num_rows($query3) != 0) {
                    while($row = mysqli_fetch_array($query3)) {
                      $subDescription = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subDescription.'
                      <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" checked disabled="true" />
                      <span class="custom-control-indicator"></span>
                      </label>
                      </div>';
                    }
                  }
                  $query4 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '0';");
                  if(mysqli_num_rows($query4) != 0) {
                    while($row = mysqli_fetch_array($query4)) {
                      $subDescription = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subDescription.'
                      <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input"  />
                      <span class="custom-control-indicator"></span>
                      </label>
                      </div>';
                    }
                    echo '</div>
                    </p>
                    <a href="#0" class="cd-read-more btn-info">Submit</a>
                    <span class="cd-date">Estimated Finish: Jan 2</span>
                    </div>
                    </div>';
                  }
                } else {
                  echo '<div class="cd-timeline-block" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/check.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <form>
                  <div class="md-form">
                  <input type="text" class="form-control" id="1-message" />
                  <label for="1-message">Leave Message:</label>
                  </div>
                  <div class="form-check">
                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" onclick="clicked('.$index.', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\'); disable(this);" id="checkbox'.$index.'">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description" >Mark Completion</span>
                  </label>
                  </div>
                  </form>
                  </p>
                  <button type="button" class="cd-read-more btn btn-warning">Submit Message</button>
                  <span class="cd-date">Estimated Finish: Jan 2</span>
                  </div>
                  </div>';
                }

              }
            }
          }
        }
        ?>
      </section> <!-- cd-timeline -->
      <div class="modal fade" tabindex="-1" role="dialog" id="modalPopup">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Success!</h5>
              <button type="button" class="close" data-dismiss="modal" >
              </button>
            </div>
            <div class="modal-body">
              <div id="fetched-data">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('scripts.html'); ?>
  <script type="text/javascript">
  jQuery(document).ready(function($){

    function clicked(id) {
      console.log(id);
    }

    var timelineBlocks = $('.cd-timeline-block'),
    offset = 0.8;

    //hide timeline blocks which are outside the viewport
    hideBlocks(timelineBlocks, offset);

    //on scolling, show/animate timeline blocks when enter the viewport
    $(window).on('scroll', function(){
      (!window.requestAnimationFrame)
      ? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
      : window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
    });

    function hideBlocks(blocks, offset) {
      blocks.each(function(){
        ( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
      });
    }

    function showBlocks(blocks, offset) {
      blocks.each(function(){
        ( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
      });
    }
  });
  </script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
  <script type="text/javascript">
  $('.equal').matchHeight();
  </script>
</body>

</html>
