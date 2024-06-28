<?php
    session_start();
    if(!isset($_SESSION['db_name'])){
        echo "notset";
	    header("Location: login.php");
        exit;
    }
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = $_SESSION['db_name'];
    // function dbExist($req_db_name){
    //     $temp = mysqli_connect($db_server, $db_user, $db_pass);
    //     if (!$temp) {
    //         die("Connection failed: " . mysqli_connect_error());
    //     }
    //     $query = "SHOW DATABASES LIKE '$req_db_name'";
    //     $result = mysqli_query($temp, $query);
    //     if (mysqli_num_rows($result) > 0) {
    //         mysqli_close($temp);
    //         return true;
    //     } else {
    //         mysqli_close($temp);
    //         return false;
    //     }
    // }
    // $db_name = "repgen";
    
    // $_SESSION['db_name'] = $db_name;
    // if($_SESSION['tryingToLogIn']){
    //     $temp = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    //     if($temp){
    //         $_SESSION['tryingToLogIn'] = false;
    //         header("Location: index.php");
    //         exit;
    //     }
    //     header("Location: login.php");
    //     exit;
    // }

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if($conn){
        
    }
    else{
        echo "sometin went wrong lol";
	    header("Location: login.php");
        exit;
    }
?>
<!-- <form method="POST" action="index.php" class="row g-3">
        <div class="input-group mb-3">
            <input type="text" id="db_name" name="db_name" class="form-control" placeholder="Database name" aria-label="Database name" aria-describedby="btn-exec">
            <input class="btn btn-primary" type="submit" value="Generate Report" id="btn-exec"></input>
        </div>
    </form> -->