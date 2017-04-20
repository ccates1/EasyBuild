<?php
session_start();
include('connection.php');
if (empty($_SESSION['username'])) {
  header('location: index.php');
};
?>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/paint.css">
  <?php include('head.html'); ?>
  <script type="text/javascript">
  function disable (el) {
    el.checked = true;
    el.setAttribute = "checked";
    el.disabled = true;
  }
  function clicked(id, desc, sessionid, step) {
    var sessionid = sessionid;
    var step = step;
    var getid = id + 1;
    var checkid = 'checkbox' + getid.toString();
    if(step == "10") {
      $.ajax({
        type: 'POST',
        url: 'completed.php',
        data : 'rowdesc='+ desc + '&sessionid='+ sessionid + '&step='+ step,
        success: function(data) {
          window.location.reload();
          window.alert("Congratulations, all items are not complete!");
        }
      });
    } else {
      document.getElementById(id).disabled = true;
      document.getElementById(checkid.toString()).disabled = false;
      document.getElementById(checkid).disabled = false;
      document.getElementById(getid.toString()).classList.remove('disabler');
      $.ajax({
        type: 'POST',
        url: 'completed.php',
        data : 'rowdesc='+ desc + '&sessionid='+ sessionid + '&step='+ step,
        success: function(data) {
          window.location.reload();
        }
      });
    }
  }
  function subclicked(subid, id, checklistitemdesc, sessionid, step, subdesc) {
    var sessionid = sessionid;
    var step = step;
    var getid = id + 1;
    var checkid = 'checkbox' + subid;
    document.getElementById(checkid.toString()).disabled = true;
    $.ajax({
      type: 'POST',
      url: 'subcompleted.php',
      data : 'sessionid=' + sessionid + '&subdesc='+ subdesc + '&step=' + step,
      success: function(data) {
        if(data == "completed") {
          window.location.reload();
          window.alert('Your next task is available');
        } else {
          window.location.reload();
          window.alert("More items to mark complete before next task is available");
        }
      }
    });
  }
  </script>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="page-content">
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
              <h4><i class="fa fa-list fa-lg" style="vertical-align:middle"></i> Session Checklist</h4>
            </div>
            <div class="card-block bg-faded">
              <?php
              echo '<div class="card-deck">
              <div class="card">
              <div class="card-block white-text bg-primary">
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
                    <div class="card-block bg-primary text-center white-text">
                      <h4 class="card-title">
                        Message Center
                      </h4>
                      <p class="card-text">
                        <a role="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm" href="messagecenter.php?id=<?php echo $sessionid; ?>">Access</a>
                      </p>
                    </div>
                    <div class="card-footer primary-color-dark text-center" id="footer">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card equal">
                    <div class="card-block bg-primary text-center white-text">
                      <h4 class="card-title">Inventory</h4>
                      <p class="card-text">
                        <a role="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm" href="inventory.php?id=<?php echo $sessionid; ?>">Access</a>
                      </p>
                    </div>
                    <div class="card-footer primary-color-dark text-center" id="footer">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card equal">
                    <div class="card-block bg-primary text-center white-text">
                      <h4 class="card-title">Reciepts/Budget</h4>
                      <p class="card-text">
                        <button type="button" class="btn btn-outline btn-outline-primary waves-effect btn-sm">Access</button>
                      </p>
                    </div>
                    <div class="card-footer primary-color-dark text-center" id="footer">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          if(!empty($_GET['id'])) {
            $query = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid' AND ChecklistItems.isCompleted = '0';");
            $query2 = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid' AND ChecklistItems.isCompleted = '1';");
            $numnotcompleted = mysqli_num_rows($query);
            $numcompleted = mysqli_num_rows($query2);
            $totalitems = $numcompleted + $numnotcompleted;
            $scale = 1.0;
            $value = 40;
            $max = 150;
            $scale = 1.0;
            if (!empty($totalitems)) {
              $percent = ($numcompleted * 100) / $totalitems;
            }
            else {
              $percent = 0;
            }
          ?>
          <hr />
          <blockquote class="blockquote bq-primary">
              <p class="bq-title"><i class="fa fa-info-circle fa-fw"></i> <?php echo $sessionname; ?></p>
              <p>This is your collaboration page for both parties involved within the home construction
                process. Builders are able to mark the completion of each item.</p>
                <div class="text-center" style="margin-top:15px;">
                  <h4 class="primary-text"><?php echo $numcompleted;?> of <?php echo $totalitems;?> Checklist Items Completed</h4>
                  <div class="progress">
                    <div class="progress-bar" style="width:<?php echo round($percent * $scale); ?>%;"></div>
                  </div>
                </div>
          </blockquote>


        </div>
      </div>

      <section id="cd-timeline" class="cd-container">
        <?php
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
              $sessionid = $row['session_id'];
              if($hasSubs == '1') {
                echo '<div class="cd-timeline-block" id="'.$index.'">
                <div class="cd-timeline-img cd-picture">
                <img src="png/blank.png" alt="">
                </div>
                <div class="cd-timeline-content">
                <h2>'.$checklistitemdesc.'</h2>
                <p>
                <div class="list-group">';
                $query5 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND session_id_fk = '$sessionid';");
                if(mysqli_num_rows($query5)) {
                  while($row = mysqli_fetch_array($query5)) {
                    $subdesc = $row['description'];
                    echo '<div class="list-group-item justify-content-between">
                    '.$subdesc.'
                    <label class="custom-control custom-checkbox align-middle">
                    <input type="checkbox" class="custom-control-input" checked disabled="true" />
                    <span class="custom-control-indicator"></span>
                    </label>
                    </div>';
                  }
                  echo '</div>
                  </p>
                  <span class="cd-date">Estimated Finish: Jan 2</span>
                  </div>
                  </div>';
                }
              } else {
                echo '<div class="cd-timeline-block">
                <div class="cd-timeline-img cd-picture">
                <img src="png/check.png" alt="">
                </div>
                <div class="cd-timeline-content">
                <h2>'.$checklistitemdesc.'</h2>
                <p>
                <div class="form-check">
                <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" checked disabled="true" />
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description" >Mark Completion</span>
                </label>
                </div>
                </p>
                <span class="cd-date">Estimated Finish: Jan 2</span>
                </div>
                </div>';
              }
            }
            while($row = mysqli_fetch_array($query)) {
              $step = $row['step'];
              $checklistitemdesc = $row['description'];
              $sessionid = $row['session_id'];
              $hasSubs = $row['hasSubs'];
              if($step != '1' && $index != -1) {
                if($hasSubs == '1') {
                  echo '<div class="cd-timeline-block disabler" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/blank.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <div class="list-group">';
                  $query3 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '1' AND session_id_fk = '$sessionid';");
                  if(mysqli_num_rows($query3) != 0) {
                    while($row = mysqli_fetch_array($query3)) {
                      $subdesc = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subdesc.'
                      <label class="custom-control custom-checkbox align-middle">
                      <input type="checkbox" class="custom-control-input" checked disabled="true" />
                      <span class="custom-control-indicator"></span>
                      </label>
                      </div>';
                    }
                  }
                  $query4 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '0' AND session_id_fk = '$sessionid';");
                  if(mysqli_num_rows($query4) != 0) {
                    while($row = mysqli_fetch_array($query4)) {
                      $subdesc = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subdesc.'
                      <label class="custom-control custom-checkbox ">
                      <input type="checkbox" class="custom-control-input"  />
                      <span class="custom-control-indicator"></span>
                      </label>
                      </div>';
                    }
                    echo '</div>
                    </p>
                    <span class="cd-date">Estimated Finish: Jan 2</span>
                    </div>
                    </div>';
                  }
                } else {

                    //Paint PART
                      if($step == '7') {

                          echo '<div class="cd-timeline-block" id="paintId" ><!--disabler-->
                                  <div class="cd-timeline-img cd-picture">
                                    <img src="png/blank.png" alt="">
                                  </div>
                                  <div class="cd-timeline-content">
                                    <h2>'.$checklistitemdesc.'</h2>
                                    <p>
                                    <form>
                                        <div class="md-form">';


                          $queryPaint = mysqli_query($dbc, "SELECT * FROM Paint");

                          $count = 0;
                          while($row = mysqli_fetch_array($queryPaint)) {
                              $paintDescription = $row['Description'];
                              $paintId = $row['id'];

                              $count++;

                            echo "<br />";

                            echo '<div class="card">
                            <div class="card-block">
                            <div class="card-title text-center"><h4>
                            '.$paintDescription.'</h4>
                            <br />
                            </div>

                            <button type="button" class="btn btn-info btn-md" id="pBtn'.$count.'"  data-toggle="modal" data-target="#myModal" style="margin: 0 auto; display: block;" >Choose Color</button>

                            <br />

                            <h4 id="clrPickId"> </h4>


                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                    <script>

                                    var getId = document.getElementById("pBtn'.$count.'");
                                    getId.onclick = function() {

                                       $.ajax({
                                        type: "GET",
                                        url: "getCount.php",
                                        data: {counter:  '.$count.'},
                                        success: function(data) {
                                          //  alert(data);
                                        }
                                    });

                                    if('.$count.' == 1) {
                                  //  alert("Button1");
                                    document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }
                                    if('.$count.' == 2) {
                                   // alert("Button2");
                                    document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }
                                    if('.$count.' == 3) {
                                  //  alert("Button3");
                                    document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }
                                     if('.$count.' == 4) {
                                   //  alert("Button4");
                                     document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }
                                    if('.$count.' == 5) {
                                   //  alert("Button5");
                                     document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }
                                     if('.$count.' == 6) {
                                   //  alert("Button6");
                                     document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }
                                    if('.$count.' == 7) {
                                   //  alert("Button7");
                                     document.getElementById("modalTitleId").innerHTML="'.$paintDescription.'";
                                    }

                                    };

                                </script>

                                <h3 class="modal-title" id="modalTitleId"></h3>
                                  </div>
                                  <div class="modal-body" id="showModal">


                                    <script src="js/color.js"></script>

                                    <h4><b>Color: <span id="colorChoice"></span></b></h4>

                                        <div style="cursor: pointer; background-color: tan; width: 40px; height: 40px; border-radius: 50%; color: red; " type="color-picker" value=""></div>

                                        <div style="display:none;" id="extraSpace">
                                            <br /><br /><br />
                                        </div>
                                  </div>

                                  <div class="modal-footer">

                                    <button type="button" class="btn btn-info " id="subBtn'.$count.'" data-dismiss="modal" >Submit</button>

                                    <script>

                                    var getSubmitId = document.getElementById("subBtn'.$count.'");

                                    getSubmitId.onclick = function() {

                                    var chosenColor = document.getElementById("colorChoice").innerHTML;

                                       $.ajax({
                                        type: "GET",
                                        url: "insertColors.php",
                                        data: {color:  chosenColor},
                                        success: function(data) {
                                           // alert(data);
                                            $("#clrPickId").text("Color: " + document.getElementById("colorChoice").innerHTML);
                                        }
                                    });
                                    }

                                    </script>

                                  </div>
                                </div><!--Close Modal-->
                                </div>
                            </div>
                            <p class="card-body">
                            </p>
                            </div>
                            </div>';
                          }//Close While Loop

                            echo '</div><!--END FORM-->
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" />
                                Mark Completion
                              </label>
                            </div>
                          </form>
                        </p>
                        <a href="#0" class="cd-read-more btn-info">Submit</a>
                        <span class="cd-date">Estimated Finish: Jan 2</span>

                      </div>
                    </div>';
                      }


                  $index++;
                  echo '<div class="cd-timeline-block disabler" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/blank.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <div class="form-check">
                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" onclick="clicked('.$index.', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\')" id="checkbox'.$index.'" disabled>
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Mark Completion</span>
                  </label>
                  </div>
                  </p>
                  <span class="cd-date">Estimated Finish: Jan 2</span>
                  </div>
                  </div>';
                }
              } else {
                if($hasSubs == '1') {
                  $index++;
                  echo '<div class="cd-timeline-block" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/blank.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <div class="list-group">';
                  $query3 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '1' AND session_id_fk = '$sessionid';");
                  if(mysqli_num_rows($query3) != 0) {
                    while($row = mysqli_fetch_array($query3)) {
                      $subindex++;
                      $subdesc = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subdesc.'
                      <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" checked disabled="true" />
                      <span class="custom-control-indicator" offset-margin"></span>
                      </label>
                      </div>';
                    }
                  }
                  $query4 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step' AND isCompleted = '0' AND session_id_fk = '$sessionid';");
                  if(mysqli_num_rows($query4) != 0) {
                    while($row = mysqli_fetch_array($query4)) {
                      $subindex++;
                      $subdesc = $row['description'];
                      echo '<div class="list-group-item justify-content-between">
                      '.$subdesc.'
                      <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" onclick="subclicked('.$subindex.', \''.$index.'\', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\', \''.$subdesc.'\')" id="checkbox'.$subindex.'" />
                      <span class="custom-control-indicator offset-margin"></span>
                      </label>
                      </div>';
                    }
                  }
                  echo '</div>
                  </p>
                  <span class="cd-date">Estimated Finish: Jan 2</span>
                  </div>
                  </div>';
                } else {
                  $index++;
                  echo '<div class="cd-timeline-block" id="'.$index.'">
                  <div class="cd-timeline-img cd-picture">
                  <img src="png/check.png" alt="">
                  </div>
                  <div class="cd-timeline-content">
                  <h2>'.$checklistitemdesc.'</h2>
                  <p>
                  <div class="form-check">
                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" onclick="clicked('.$index.', \''.$checklistitemdesc.'\', \''.$sessionid.'\', \''.$step.'\'); disable(this);" id="checkbox'.$index.'">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description" >Mark Completion</span>
                  </label>
                  </div>
                  </p>
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
    </div>
  </div>
  <?php
  if($_SESSION['user_type'] == "owner") {
    ?>
    <script type="text/javascript">
    $( ".form-check" ).each(function() {
      $( this ).hide();
    });
    </script>
    <?php
  }
  ?>

  <?php include('scripts.html'); ?>
  <script type="text/javascript">
  jQuery(document).ready(function($){
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
