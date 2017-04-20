<?php
session_start();
include('connection.php');

if(isset($_GET['counter'])) {
    
 $count = $_GET['counter'];

    $_SESSION['count'] = $count;
    
    echo $count;
    
}
   else {
       echo "NOT WORKING";
   }

?>