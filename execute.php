<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the query from the form
$user_query = $_POST['query'];
echo "hello world";
// Execute the query
$result = $conn->query($user_query);

// Check if the query was successful
if ($result) {
    // Check if there are results and display them
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        // Output table headers
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>{$fieldinfo->name}</th>";
        }
        echo "</tr>";
        // Output table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
} else {
    echo "Error: " . $conn->error;
}

// Close the connection
$conn->close();
?>
