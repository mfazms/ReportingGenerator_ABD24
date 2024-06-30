<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="row row-cols-auto mb-3" id='mynavbar'>
        <a class="" href="index.php">
            <h3>Report Generator</h3>
        </a>
        <!-- <a href="logout.php" class="btn btn-outline-danger" role="button" aria-disabled="false">LOGOUT</a> -->
    </div>
    <?php
    include 'function.php';
    // include_once 'database.php';
    ?>
    <form method="POST" class="row g-3">
        <div class="input-group mb-3">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                aria-label="Username" aria-describedby="btn-exec" required>
            <input type="text" id="password" name="password" class="form-control" placeholder="Password"
                aria-label="Password" aria-describedby="btn-exec" required>
            <input type="text" id="db_name" name="db_name" class="form-control" placeholder="Database name"
                aria-label="Database name" aria-describedby="btn-exec" required>
            <input class="btn btn-primary" type="submit" value="Login" id="btn-login"></input>
        </div>
    </form>
    <!-- <form method="POST" class="row justify-content-md-center g-3" >
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="btn-exec" required>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <input type="text" id="password" name="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="btn-exec" required>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <input type="text" id="db_name" name="db_name" class="form-control" placeholder="Database name" aria-label="Username" aria-describedby="btn-exec" required>
            </div>
        </div>
        <div class="row justify-content-md-center mt-3">
            <div class="col col-lg-4">
                <div class="d-grid">
                    <input class="btn btn-primary" type="submit" value="Login" id="btn-login"></input>
                </div>
            </div>
        </div>
    </form> -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        $req_username = $_POST['username'];
        $req_password = $_POST['password'];
        $req_db_name = $_POST['db_name'];
        $permissionsArray = getPermissions($req_username, $req_password);
        if ($permissionsArray !== null && in_array($req_db_name, $permissionsArray)) {
            $_SESSION['db_name'] = $req_db_name;
            // echo $_SESSION['db_name'];
            // $_SESSION['tryingToLogIn'] = true;
            include_once 'database.php';
            header('Location: index.php');
            exit();
        } else {
            ?>
            <div class='alert alert-danger' role='alert'>
            Invalid username, password, database not exist, or not allowed to access database!
            </div>
            <?php
        }
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="main.js"></script>
    <script src="table2excel.js"></script>

</body>

</html>
