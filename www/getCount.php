<?php
session_start();
include('connection.php');

if(isset($_GET['counter'])) {
    
 $count = $_GET['counter'];

 $_SESSION['count'] = $count;
    
}
   else {
       echo "NOT WORKING";
   }

?>