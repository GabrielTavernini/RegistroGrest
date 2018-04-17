<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Grest";
    $pass = array();

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT Nome, Pass FROM Laboratori";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($pass, $row['Pass']);
        }
    }

    $lab = $_GET["username"];

    if($lab == 99 && $_GET["password"] == "admin")
        $validUser = true;
    else
        $validUser = $_GET["password"] == $pass[$_GET["username"]];

    if($validUser)
    {
        $name = $_GET["Nome"];
        $eta = $_GET["Eta"];
        $LabID = $_GET["Lab"];
        $pre1 = $_GET["P1"];
        $sport1 = $_GET["S1"];
        $pre2 = $_GET["P2"];
        $sport2 = $_GET["S2"];
        $pre3 = $_GET["P3"];
        $sport3 = $_GET["S3"];
        $pre4 = $_GET["P4"];
        $sport4 = $_GET["S4"];

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "UPDATE Generale SET Nome = '$name', Eta = '$eta', Presenza1 ='$pre1' , Sport1 = '$sport1', Presenza2 = '$pre2',
        Sport2 = '$sport2', Presenza3 = '$pre3', Sport3 = '$sport3', Presenza4 = '$pre4', Sport4 = '$sport4', LabID = '$LabID' 
        WHERE Nome='$name' && Eta='$eta'";

        $conn->query($sql);
    }
?>