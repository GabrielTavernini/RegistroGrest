<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Grest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Date";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["Giorno"] . ":" . $row["Data"] . ";";
    }
    echo "</div>";
} else {
    echo "0 results";
}

$sql = "SELECT * FROM Laboratori";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["ID"] . ":" . $row["Nome"] . ";";
    }
    echo "</div>";
} else {
    echo "0 results";
}

$sql = "SELECT * FROM Sport";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div>";
    //echo "<table><tr><th>ID</th><th>Sport</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "<tr><td>" . $row["ID"]. "</td><td>" . $row["Nome"]. "</td></tr>";
        echo $row["ID"] . ":" . $row["Nome"] . ";";
    }
    //echo "</table>";
    echo "</div>";
} else {
    echo "0 results";
}
$conn->close();
?> 

</body>
</html>