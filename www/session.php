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
    <div class="page-content">
      <section id="cd-timeline" class="cd-container">
        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-picture">
            <img src="png/1.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Generate Construction Drawings</h2>
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
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src="png/2.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Foundation</h2>
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
            <span class="cd-date">Estimated Finish: Jan 14</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-picture">
            <img src="png/3.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Plumbing</h2>
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
            <span class="cd-date">Estimated Finish: Jan 20</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src="png/4.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Framing</h2>
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
            <span class="cd-date">Estimated Finish: Jan 27</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src="png/6.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Electrical</h2>
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
            <span class="cd-date">Estimated Finish: Feb 2</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src="png/7.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Water/Sewage Construction</h2>
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
            <span class="cd-date">Estimated Finish: Feb 7</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src="png/8.png" alt="">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Gas Connection</h2>
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
            <span class="cd-date">Estimated Finish: Feb 14</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->
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
