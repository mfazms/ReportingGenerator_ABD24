<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "repgen";

    $conn = "";

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    // if($conn){
    //     echo "connected to DB";
    // }
    // else{
    //     echo "sometin went wrong lol";
    // }
?>