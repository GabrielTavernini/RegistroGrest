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
        $names = array();
        $eta = array();
        $labs = array();
        $pre1 = array();
        $spo1 = array();
        $pre2 = array();
        $spo2 = array();
        $pre3 = array();
        $spo3 = array();
        $pre4 = array();
        $spo4 = array();

        $conn = new mysqli($servername, $username, $password, $dbname);
        if($lab != 99)
            $sql = "SELECT Nome, Eta, LabID, Presenza1, Sport1, Presenza2, Sport2, Presenza3, Sport3, Presenza4, Sport4 FROM Generale WHERE LabID = '$lab'";
        else
            $sql = "SELECT Nome, Eta, LabID, Presenza1, Sport1, Presenza2, Sport2, Presenza3, Sport3, Presenza4, Sport4 FROM Generale";

        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
            $names[] = $row["Nome"];
            $eta[] = $row["Eta"];
            $labs[] = $row["LabID"];
            $pre1[] = $row["Presenza1"];
            $spo1[] = $row["Sport1"];
            $pre2[] = $row["Presenza2"];
            $spo2[] = $row["Sport2"];
            $pre3[] = $row["Presenza3"];
            $spo3[] = $row["Sport3"];
            $pre4[] = $row["Presenza4"];
            $spo4[] = $row["Sport4"];
        }

        $arr = array("names" => $names, "eta" => $eta, "labs" => $labs, "pre1" => $pre1, "spo1" => $spo1, "pre2" => $pre2, "spo2" => $spo2, "pre3" => $pre3, "spo3" => $spo3, "pre4" => $pre4, "spo4" => $spo4);
        $json_arr = json_encode($arr);

        print $json_arr;
    }else{print "wrong password";}
?>