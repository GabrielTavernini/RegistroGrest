<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Grest";
    $labs = array();
    $dates = array();
    $sports = array();

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT * FROM Date";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($dates, $row['Data']);
        }
    }

    $sql = "SELECT Nome FROM Laboratori";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($labs, $row['Nome']);
        }
    }

    $sql = "SELECT Nome FROM Sport";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($sports, $row['Nome']);
        }
    }

    $arr = array("dates" => $dates, "labs" => $labs, "sports" => $sports);
    $json_arr = json_encode($arr);

    print $json_arr;
?>