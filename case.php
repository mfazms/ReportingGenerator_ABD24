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
    <h4>Case</h4>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Your submitted query</span>
        <input type="text" readonly class="form-control" placeholder="<?php echo htmlspecialchars($_SESSION['submittedQuery']); ?>">
    </div>
    <form method="POST" class="row row-cols-auto align-items-center mb-3">
        
        <div class="col">Select where</div>
        <div class="col">
            <select class="form-select" name="caseCol" id="caseCol" required>
                <option selected disabled value="">Choose...</option>
                <?php
                    foreach($_SESSION['cols'] as $col){
                        echo "<option value='$col'>$col</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col">is</div>
        <div class="col">
            <select class="form-select" name="caseOpt" id="caseOpt" required>
                <option selected disabled value="">Choose...</option>
                <option value=">">></option>
                <option value="=">=</option>
                <option value="<"><</option>
            </select>
        </div>
        <div class="col">than</div>

        <div class="col">
            <select class="form-select" name="caseYear" id="caseYear" required>
                <option selected disabled value="">Choose...</option>
                <?php
                    for($i=2000; $i<=2024; $i++){
                        echo "<option value='$i'>$i</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col">
            <input class="btn btn-primary" type="submit" value="Execute Case" id="btn-exec"></input>
        </div>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
            echo'<div class="mb-3">';
            echo'<button type="button" class="btn btn-primary" onclick="toggleView()" id="btn-pivot">Pivot</button>';
            echo'<a href="export.php" class="btn btn-primary" role="button" aria-disabled="false">Export</a>';
            echo'</div>';
            CaseFilter($conn,$_POST['caseCol'],$_POST['caseOpt'],$_POST['caseYear']);
            table($_SESSION['temp'],$_SESSION['tempSwitched']);
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>
</html>