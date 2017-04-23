<?php
session_start();
include('connection.php');
if (empty($_SESSION['username'])) {
  header('location: index.php');
};
?>
<html lang="en">
<head>
  <?php include('head.html'); 
    echo '<link rel="stylesheet" type="text/css" href="css/paint.css">';
  ?>
  
</head>
<body>
  <?php include("nav.html"); ?>
  <div class="page-content">
    
        <div class="container">
        <?php
            echo "<a class='text-primary' href=\"javascript:history.go(-1)\"><i class='fa fa-arrow-circle-o-left fa-fw'></i> GO BACK</a>";
        ?>
        
          <div class="card">
            <div class="card-header white-text bg-primary">
              <h4><i class="fa fa-list fa-lg" style="vertical-align:middle"></i> Paint Rooms</h4>
            </div>
            <div class="card-block bg-faded">
              
       
          <?php
          if(!empty($_GET['id'])) {
            
          ?>
          <hr />
          
        </div>
      </div>

      <section id="cd-timeline" class="cd-container">
        
        <?php
         
        }
                             
          


          echo '<div class="cd-timeline-block" ><!--disabler-->
                  <!--<div class="cd-timeline-img cd-picture">
                    <img src="png/blank.png" alt="">
                  </div>-->
                  <div class="<!--cd-timeline-content-->">
                    <h2></h2>
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

            <button type="button" class="btn btn-info btn-md" id="pBtn'.$count.'"  data-toggle="modal" data-target="#myModal" style="background-color:#2B7CFF; margin: 0 auto; display: block;" >Choose Color</button>

            <br />

            <h4 id="clrPickId"></h4>


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
                        
                        alert("Count is: " + data);
                        
                            if(data == 1) {
                                
                                $("#clrPickId").text("Color: " + document.getElementById("colorChoice").innerHTML);
                            }
                            if(data == 2) {
                                $("#clrPickId").text("Color: " + document.getElementById("colorChoice").innerHTML);
                            }
                            if(data == 3) {
                                $("#clrPickId").text("Color: " + document.getElementById("colorChoice").innerHTML);
                            }
                        
                           
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

            </div>
          </form>
        </p>


      </div>
    </div>';
                      
        ?>
      </section> <!-- cd-timeline -->
    </div>
  </div>


  <?php include('scripts.html'); ?>

</body>

</html>
