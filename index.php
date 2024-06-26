<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RepGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
        include 'function.php';
        include_once 'database.php';
    ?>
    <a href="index.php">
        <h3>Report Generator</h3>
    </a>
    <form method="POST" class="row g-3">
        <div class="input-group mb-3">
            <input type="text" id="query" name="query" class="form-control" placeholder="Insert your query here" aria-label="Insert your query here" aria-describedby="btn-exec">
            <input class="btn btn-primary" type="submit" value="Execute Query" id="btn-exec"></input>
        </div>
    </form>
    <div>

    </div>
    <div class="result">
        <?php

            if($_SERVER['REQUEST_METHOD']=="POST"){
                $query = $_POST['query'];
                echo "<p>INPUTTED QUERY: [$query]</p>";
                if("select" != strtolower(substr($query,0,6))){
                    echo "not allowed";
                    die;
                }
                $res = $conn->query($query);
                if($res){
                    ParseQuery($query);
                    echo "<p>SEL [{$_SESSION['sel_from']}] FROM</p>";
                    echo "<p>FROM [{$_SESSION['from_end']}]</p>";
                    foreach($_SESSION['cols'] as $s){
                        echo "<p>[{$s}]</p>";
                    }
                    $normal = [];
                    while ($row = mysqli_fetch_assoc($res)) {
                        $normal[] = $row;
                    }
                    $switched = [];
                    foreach ($normal as $rowKey => $row) {
                        foreach ($row as $colKey => $value) {
                            $switched[$colKey][$rowKey] = $value;
                        }
                    }
                    $_SESSION['normal'] = $normal;
                    $_SESSION['switched'] = $switched;
                }
            }
            if($_SESSION['normal'] && $_SESSION['switched']){

        ?>
            <button type="button" class="btn btn-primary" onclick="toggleView()" id="btn-pivot">Pivot</button>
            <a href="groupby.php" class="btn btn-primary" role="button" aria-disabled="false">Group By</a>
            <a href="case.php" class="btn btn-primary" role="button" aria-disabled="false">Case</a>
            <a href="export.php" class="btn btn-primary" role="button" aria-disabled="false">Export</a>
        <?php
            
            include 'table.php';
            }

        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>
</html>