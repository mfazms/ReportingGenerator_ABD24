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
    <h4>Group By</h4>
    <div>

    </div>
    <div class="result">

        
        <div class="groupbyoptions row align-items-start">

            <select class="form-select col" aria-label="Default select example">
                <option selected>Type</option>
                <option value="count">Count</option>
                <option value="average">Average</option>
                <option value="sum">Sum</option>
            </select>
            <select class="form-select col" aria-label="Default select example">
                <option selected>Column</option>
                <?php
                    $i=0;
                    foreach($_SESSION['cols'] as $col){
                        echo "<option value='$i++'>$col</option>";
                    }
                ?>
            </select>
            <select class="form-select col" aria-label="Default select example">
                <option selected>Group By</option>
                <?php
                    $i=0;
                    foreach($_SESSION['cols'] as $col){
                        echo "<option value='$i++'>$col</option>";
                    }
                ?>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="toggleView()" id="btn-pivot">Pivot</button>
        <a href="groupby.php" class="btn btn-primary" role="button" aria-disabled="false">Group By</a>
        <?php
            include 'table.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>
</html>