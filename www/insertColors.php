<?php
session_start();
include('connection.php');

$getCount = $_SESSION['count'];

if(isset($_GET['color'])) {
    
    $color = $_GET['color'];
    
    echo $color;
    
    if($getCount == 1) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 1");
    }
    else if($getCount == 2) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 2");
    }
    else if($getCount == 3) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 3");
    }
    else if($getCount == 4) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 4");
    }
    else if($getCount == 5) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 5");
    }
    else if($getCount == 6) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 6");
    }
    else if($getCount == 7) {
        mysqli_query($dbc, "UPDATE Paint SET Color = '$color' WHERE id = 7");
    }
}
else {
    echo "COLOR NOT WORKING";
}

?>