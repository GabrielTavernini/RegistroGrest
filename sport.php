<?php
    session_start();
    $laboratori = array();
	$sport = array();
	$date = array();
    $presenza;
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
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($date, $row['Data']);
        }
	}

    $sql = "SELECT Nome FROM Laboratori";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($laboratori, $row['Nome']);
        }
    }

    $sql = "SELECT Nome FROM Sport";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($sport, $row['Nome']);
        }
    }

    $sql = "SELECT ID, Nome FROM Presenza";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $presenza[$row['ID']] = $row['Nome'];
        }
    }
    $conn->close();
    

    
    $t=time();
    if (isset($_SESSION['logged']) && ($t - $_SESSION['logged'] > 900)) {
        header('location:./logout.php');
    }
    else {$_SESSION['logged'] = time();} 

    if(!isset($_SESSION['login'])) {
        header('LOCATION:./index.php'); die();
    }

    $day = 0;
    if(isset($_GET['day'])) {
        $day = $_GET['day'];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Generale</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="15" > 

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./Style/table_style.css" type="text/css">
        <!--<link rel="stylesheet" href="./sticky_navbar.css" type="text/css">-->
        <link rel="stylesheet" href="./Style/floating_button.css" type="text/css">
        <link rel="stylesheet" href="./Style/dropdown_style.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>         
            .invisible {
                display: none;
            }
        </style>
    </head>

    <body style="margin: 0px;">
        <ul>
            <li class="dropdown active">
                <a href="javascript:void(0)" class="dropbtn">Generale</a>
                <div class="dropdown-content">
                <a href="./general.php?day=0">Complessivo</a>    
                <a href="./general.php?day=1">Giorno 1</a>
                <a href="./general.php?day=2">Giorno 2</a>
                <a href="./general.php?day=3">Giorno 3</a>
                <a href="./general.php?day=4">Giorno 4</a>
                </div>
                
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Sport</a>
                <div class="dropdown-content">
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            echo "<a href='./sport.php?day=" . $day . "&sport=" . $x . "'>". $sport[$x] ."</a>";
                        } 
                    ?>    
                </div>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Laboratori</a>
                <div class="dropdown-content">
                    <?php
                        for ($x = 0; $x < count($laboratori); $x++) {
                            echo "<a href='./laboratorio.php?day=" . $day . "&labID=" . $x . "'>". $laboratori[$x] ."</a>";
                        } 
                    ?>    
                </div>
            </li>

            <li class="logout"><a href="./logout.php">Esci</a></li>
        </ul>
        
        <!--
        <div id="navbar">
            <a class="active" href="javascript:void(0)">Generale</a>
            <a href="javascript:void(0)">Traforo</a>
            <a href="javascript:void(0)">Cucina</a>
            <a href="javascript:void(0)">Ballo</a>
            <a href="javascript:void(0)">Prima Elementare</a>
            <a href="javascript:void(0)">Seconda Elementare</a>
            <a href="javascript:void(0)">Terza Elementare</a>

            <a href="./logout.php" class="logout">Esci</a>
        </div>-->

        <div class="content">
            <div class="table-title">
                <?php 
                    if($day == 0)
                        echo "<h3>Complessivo - ".$sport[$_GET['sport']]."</h3>";
                    else
                        echo "<h3>Giorno ".$day." (".$date[$day - 1].") - ".$sport[$_GET['sport']]."</h3>";
                ?>
            </div>
            <div class="scrolling-content">
                <table class="table-fill">
                    <thead>
                        <tr>
                            <th class="text-left">Nome</th>
                            <th class="text-left">Eta</th>
                            <th class='text-left'>Laboratorio</th>
                            <?php 
                                if($day == 0)
                                {
                                    echo "<th class='text-left'>".$date[0]."</th>
                                        <th class='text-left'>".$date[1]."</th>
                                        <th class='text-left'>".$date[2]."</th>
                                        <th class='text-left'>".$date[3]."</th>
                                        <th class='text-left'>Sport</th>";
                                }else{
                                    echo "<th class='text-left'>Presente</th>
                                        <th class='text-left'>Sport</th>";
                                }
                            ?>


                        </tr>
                    </thead>
                    <tbody class="table-hover">
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

                            $sql = "SELECT Nome, Eta, LabID, Presenza1, Presenza2, Presenza3, Presenza4, Sport FROM Generale WHERE Sport = '" . $_GET['sport'] . "'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    if($day == 0) {
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">";

                                            //laboratorio
                                            if( $row["LabID"] != 99 ) { echo $laboratori[$row["LabID"]]; }
                                            else{ echo "N/A"; }

                                            //presenza 1
                                            echo " </td><td value=". $row["Presenza1"]. ">" 
                                            . $presenza[$row["Presenza1"]]. " </td>";

                                            //presenza 2
                                            echo " </td><td value=". $row["Presenza2"]. ">" 
                                            . $presenza[$row["Presenza2"]]. " </td>";
                                            
                                            //presenza 3
                                            echo " </td><td value=". $row["Presenza3"]. ">" 
                                            . $presenza[$row["Presenza3"]]. " </td>";
                                            
                                            //presenza 4
                                            echo " </td><td value=". $row["Presenza4"]. ">" 
                                            . $presenza[$row["Presenza4"]]. " </td>"; 
                                    }
                                    
                                    if($day == 1){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">";
                                            if( $row["LabID"] != 99 ) { echo $laboratori[$row["LabID"]]; }
                                            else{ echo "N/A"; }

                                            //presenza 1
                                            echo " </td><td value=". $row["Presenza1"]. ">" 
											. $presenza[$row["Presenza1"]]. " </td>";
                                    }

                                    if($day == 2){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">";
                                            if( $row["LabID"] != 99 ) { echo $laboratori[$row["LabID"]]; }
                                            else{ echo "N/A"; }

                                            //presenza 2
                                            echo " </td><td value=". $row["Presenza2"]. ">" 
                                            . $presenza[$row["Presenza2"]]. " </td>";
                                    }

                                    if($day == 3){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">";
                                            if( $row["LabID"] != 99 ) { echo $laboratori[$row["LabID"]]; }
                                            else{ echo "N/A"; }

                                            //presenza 3
                                            echo " </td><td value=". $row["Presenza3"]. ">" 
                                            . $presenza[$row["Presenza3"]]. " </td>";
                                    }

                                    if($day == 4){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">";
                                            if( $row["LabID"] != 99 ) { echo $laboratori[$row["LabID"]]; }
                                            else{ echo "N/A"; }

                                            //presenza 4
                                            echo " </td><td value=". $row["Presenza4"]. ">" 
                                            . $presenza[$row["Presenza4"]]. " </td>"; 
									}
								
									//sport
									echo "<td value=". $_GET['sport']. ">";
									if( $row["Sport"] != 99 ) { echo $sport[$_GET['sport']]; }
									else{ echo "N/A"; }
									echo " </td></tr>" ;

								}

                            } else {
                                echo "0 results";
                            }

                            $conn->close();
                        ?> 
                    </tbody>
                </table>
            </div>
        </div>

        <a href="./new.php" class="float">
            <i class="fa fa-plus my-float"></i>
        </a>

        <script>
            window.onscroll = function() {myFunction()};

            var navbar = document.getElementById("navbar");
            var sticky = navbar.offsetTop;

            function myFunction() {
                if (window.pageYOffset >= sticky) {
                    navbar.classList.add("sticky")
                } else {
                    navbar.classList.remove("sticky");
                }
            }
        </script>

        <script>
            console.log("Script")
            var elements = document.getElementsByClassName('clickable');
            for (var i = 0; i < elements.length; i++) {
                var element = elements[i];
                element.addEventListener('click', function() {
                    window.location.assign("./edit.php?" + "nome=" + this.cells[0].innerHTML + "&eta=" + this.cells[1].innerHTML);
                });
            }
        </script>

    </body>
</html>