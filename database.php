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

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if($conn){
        // if(!isset($_SESSION['tables'])){
        //     $query = "SHOW TABLES";
        //     $res = mysqli_query($conn, $query);
        //     if ($res) {
        //         $tables = array();
        //         while ($row = mysqli_fetch_row($res)) {
        //             $tables[] = $row[0];
        //         }
        //         $_SESSION['tables'] = $tables;
        //         foreach($tables as $table){
        //             $queryCol = "SHOW COLUMNS FROM `$table`";
        //             // echo "$queryCol,";
        //             $resCol = mysqli_query($conn, $queryCol);
        //             if ($resCol) {
        //                 $columns = array();
        //                 while ($row = mysqli_fetch_row($resCol)) {
        //                     $columns[] = $row[0];
        //                 }
        //                 $_SESSION["table_$table"] = $columns;
        //             }
        //         }
        //     }
        // }
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