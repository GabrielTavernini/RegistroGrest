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
	else if($lab == "nolab")
		$validUser = true;
	else
        $validUser = $_GET["password"] == $pass[$_GET["username"]];

    if($validUser)
    {
        $names = array();
        $eta = array();
        $labs = array();
        $pre1 = array();
        $pre2 = array();
        $pre3 = array();
        $pre4 = array();
        $spo = array();

        $conn = new mysqli($servername, $username, $password, $dbname);
		if($lab != 99 && $lab != "nolab" && $lab != 98)
			$sql = "SELECT Nome, Eta, LabID, Presenza1, Presenza2, Presenza3, Presenza4, Sport FROM Generale WHERE LabID = '$lab'";
		else if($lab == "nolab")
			$sql = "SELECT Nome, Eta, LabID, Presenza1, Presenza2, Presenza3, Presenza4, Sport FROM Generale WHERE LabID = 99";
        else
            $sql = "SELECT Nome, Eta, LabID, Presenza1, Presenza2, Presenza3, Presenza4, Sport FROM Generale";

        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
            $names[] = $row["Nome"];
            $eta[] = $row["Eta"];
            $labs[] = $row["LabID"];
            $pre1[] = $row["Presenza1"];
            $pre2[] = $row["Presenza2"];
            $pre3[] = $row["Presenza3"];
            $pre4[] = $row["Presenza4"];
			$spo[] = $row["Sport"];
        }

        $arr = array("names" => $names, "eta" => $eta, "labs" => $labs, "pre1" => $pre1, "pre2" => $pre2, "pre3" => $pre3, "pre4" => $pre4, "spo" => $spo);
        $json_arr = json_encode($arr);

        print $json_arr;
    }else{print "wrong password";}
?>