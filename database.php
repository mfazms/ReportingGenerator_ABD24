<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "repgen";
    $_SESSION['db_name'] = $db_name;

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    session_start();
    // if($conn){
    //     echo "connected to DB";
    // }
    // else{
    //     echo "sometin went wrong lol";
    // }
?>
<!-- <form method="POST" action="index.php" class="row g-3">
        <div class="input-group mb-3">
            <input type="text" id="db_name" name="db_name" class="form-control" placeholder="Database name" aria-label="Database name" aria-describedby="btn-exec">
            <input class="btn btn-primary" type="submit" value="Generate Report" id="btn-exec"></input>
        </div>
    </form> -->