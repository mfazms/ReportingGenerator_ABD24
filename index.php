<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<body>
    <?php
        include 'function.php';
        include_once 'database.php';
    ?>
    
    <div class="row row-cols-auto mb-3" id='mynavbar'>
        <a class="" href="index.php">
            <h3>Report Generator</h3>
        </a>
        <a href="logout.php" class="btn btn-outline-danger" role="button" aria-disabled="false">LOGOUT</a>
    </div>
    <form method="POST" class="row g-3 mb-3">
        <div class="row row-cols-auto mb-2">
            <div class="col">
                <select class="form-select" name="selectTable" id="selectTable" required>
                    <option selected disabled value="">Choose...</option>
                    <?php
                        $query = "show tables";
                        $res = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_row($res)){
                            ?>
                    <option value="<?php echo $row[0]?>"><?php echo $row[0]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row row-cols-auto mb-2" id="selectColumnDiv">

        </div>
        <div class="row" >
            <div class="col" id="btn-exec-div">
                <!-- <input class="btn btn-primary" type="submit" value="Execute Query" id="btn-exec"></input> -->
            </div>
        </div>
    </form>
        <?php
            // echo $_SESSION['db_name'];
            if($_SERVER['REQUEST_METHOD']=="POST"){
                if (isset($_POST['columns']))
                {
                    unset($_SESSION['columns']);
                    $_SESSION['columns'] = $_POST['columns'];
                }
                $_SESSION['selectedColumnsText'] = implode(', ',$_SESSION['columns']);
                $_SESSION['selectedColumns'] = $_SESSION['columns'];
                $query = "select " . $_SESSION['selectedColumnsText'] . " from `" . $_SESSION['table'] . '`';
                // echo $query;
                ExecuteQuery($conn,$query,$_SESSION['unpivoted'],$_SESSION['pivoted']);
                // ParseQuery($query);
            }
            // if(isset($_SESSION['columns'])){
            //     $columns = $_SESSION['columns'];
            //     foreach ($columns as $column) {
            //         echo "Selected column: " . htmlspecialchars($column) . "<br>";
            //     }
            // }
            if(isset($_SESSION['unpivoted']) && isset($_SESSION['pivoted'])){
                ?>
                <div class="mb-3">
                <button type="button" class="btn btn-primary" onclick="toggleView()" id="btn-pivot">Pivot</button>
                <a href="groupby.php" class="btn btn-primary" role="button" aria-disabled="false">Group By</a>
                <a href="case.php" class="btn btn-primary" role="button" aria-disabled="false">Case</a>
                <button class="btn btn-primary" onclick="Export()">Export</button>
                </div>
                <?php
                table($_SESSION['unpivoted'],$_SESSION['pivoted']);
            }
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script src="table2excel.js"></script>
    <script>
        $(document).ready(function(){
            $('#selectTable').change(function(){
            var selectedTable = $('#selectTable').val(); 
        
            $.ajax({
                type: 'POST',
                url: 'fetch_columns.php',
                data: {selectTable:selectedTable},  
                success: function(data){
                    $('#selectColumnDiv').html(data);
                    var buttonHtml = '<input class="btn btn-outline-success" type="submit" value="Execute Query" id="btn-exec"></input>';
                    $('#btn-exec-div').html(buttonHtml);
                }
                });
            });
        });
    </script> 
</body>
</html>