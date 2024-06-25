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
    <h1>Report Generator</h1>
    <form method="POST" class="row g-3">
        <div class="input-group mb-3">
            <input type="text" id="query" name="query" class="form-control" placeholder="Insert your query here" aria-label="Insert your query here" aria-describedby="btn-exec">
            <input class="btn btn-primary" type="submit" value="Execute Query" id="btn-exec"></input>
        </div>
    </form>
    <div class="result">
        <?php
            include_once 'database.php';

            if($_SERVER['REQUEST_METHOD']=="POST"){

                $query = $_POST['query'];
                echo "<p>user inputted: $query</p>";
            }
            $res = $conn->query($query);
            if($res){
                if($res->num_rows>0){
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                while($fieldinfo = $res->fetch_field()){
                    echo "<th>{$fieldinfo->name}</th>";
                }
                echo"</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $res->fetch_assoc()){
                    echo "<tr>";
                    foreach($row as $col){
                        echo "<td>{$col}</td>";
                    }
                    echo"</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                }
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>