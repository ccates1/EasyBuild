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
  function clicked(test) {
    document.getElementById(test.id).style.background= "black";
    console.log(test.id);
  }
  </script>
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="container">
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
          echo '<div class="card-deck">
          <div class="card">
          <div class="card-block white-text bg-primary">
          <h4 class="card-title">Builder Information <i class="fa fa-wrench fa-fw"></i>:</h4>
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
          <h4 class="card-title">Home-Owner Information <i class="fa fa-wrench fa-fw"></i>:</h4>
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
      <section id="cd-timeline" class="cd-container">
        <?php
          if(!empty($_GET['id'])) {
            $query = mysqli_query($dbc, "SELECT * FROM Sessions INNER JOIN ChecklistItems ON Sessions.id = '$sessionid' AND ChecklistItems.session_id = '$sessionid'");
            if(mysqli_num_rows($query) != 0) {
              while($row = mysqli_fetch_array($query)) {
                $step = $row['step'];
                $checklistitemdesc = $row['description'];
                $iscompleted = $row['isCompleted'];
                $hasSubs = $row['hasSubs'];
                if($iscompleted == '0' && $step != '1') {
                  if($hasSubs == '1') {
                    $query2 = mysqli_query($dbc, "SELECT * FROM Subs WHERE checklistitem_id = '$step';");
                    if(mysqli_num_rows($query2) != 0) {
                      echo '<div class="cd-timeline-block" id="disabler">
                        <div class="cd-timeline-img cd-picture">
                          <img src="png/blank.png" alt="">
                        </div>
                        <div class="cd-timeline-content">
                          <h2>'.$checklistitemdesc.'</h2>
                          <p>
                          <div class="card-group">';
                      while($row = mysqli_fetch_array($query2)) {
                        $subDescription = $row['description'];
                        echo '<div class="card">
                        <div class="card-block">
                        <div class="card-title text-center">
                        '.$subDescription.'
                        </div>
                        <p class="card-body">

                        </p>
                        </div>
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
                    echo '<div class="cd-timeline-block" id="disabler">
                      <div class="cd-timeline-img cd-picture">
                        <img src="png/blank.png" alt="">
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
                } else {
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
              }
            }
        }
        ?>
      </section> <!-- cd-timeline -->
    </div>

  </div>
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
</body>

</html>
