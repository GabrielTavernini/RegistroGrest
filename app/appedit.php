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
	else if($lab == "98" && $_GET["password"] == "atletici")
		$validUser = true;
    else
        $validUser = $_GET["password"] == $pass[$_GET["username"]];

    if($validUser)
    {
        $name = $_GET["Nome"];
        $eta = $_GET["Eta"];
        $LabID = $_GET["Lab"];
        $pre1 = $_GET["P1"];
        $pre2 = $_GET["P2"];
        $pre3 = $_GET["P3"];
        $pre4 = $_GET["P4"];
        $sport = $_GET["S"];

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "UPDATE Generale SET Nome = '$name', Eta = '$eta', Presenza1 ='$pre1', Presenza2 = '$pre2', Presenza3 = '$pre3', Presenza4 = '$pre4', Sport = '$sport', LabID = '$LabID' 
        WHERE Nome='$name' && Eta='$eta'";

        $conn->query($sql);
    }
?>