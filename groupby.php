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
        <h2>Home</h3>
    </a>
    <h4>Group By</h4>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Your submitted query</span>
        <input type="text" readonly class="form-control" placeholder="<?php echo htmlspecialchars($_SESSION['submittedQuery']); ?>">
    </div>
    <form method="POST" class="row row-cols-auto align-items-center mb-3">
        
        <div class="col">Select</div>
        <div class="col">
            <select class="form-select" name="aggregate" id="aggregate" required>
                <option selected disabled value="">Choose...</option>
                <option value="count">Count</option>
                <option value="avg">Average</option>
                <option value="sum">Sum</option>
            </select>
        </div>
        <div class="col">
            <select class="form-select" name="aggregateCol" id="aggregateCol" required>
                <option selected disabled value="">Choose...</option>
                <?php
                    foreach($_SESSION['cols'] as $col){
                        echo "<option value='$col'>$col</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col">group by</div>
        <div class="col">
            <select class="form-select" name="groupbyCol" id="groupbyCol" required>
                <option selected disabled value="">Choose...</option>
                <?php
                    foreach($_SESSION['cols'] as $col){
                        echo "<option value='$col'>$col</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col">
            <input class="btn btn-primary" type="submit" value="Execute Group By" id="btn-exec"></input>
        </div>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
    ?>
            <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="toggleView()" id="btn-pivot">Pivot</button>
            <button class="btn btn-primary" onclick="Export()">Export</button>
            </div>
    <?php
            GroupBy($conn, $_POST['aggregate'], $_POST['aggregateCol'],$_POST['groupbyCol']);
            table($_SESSION['unpivoted_groupBy'],$_SESSION['pivoted_groupBy']);
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script src="table2excel.js"></script>
</body>
</html>