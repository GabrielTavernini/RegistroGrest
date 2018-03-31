<?php
    session_start();
    $laboratori;
    $sport;
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

    $sql = "SELECT ID, Nome FROM Laboratori";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $laboratori[$row['ID']] = $row['Nome'];
        }
    }

    $sql = "SELECT ID, Nome FROM Sport";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $sport[$row['ID']] = $row['Nome'];
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
<!--
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Traforo</a>
                <div class="dropdown-content">
                <a href="./laboratorio.php?day=0&lab=Traforo">Complessivo</a>    
                <a href="./laboratorio.php?day=1&lab=Traforo">Giorno 1</a>
                <a href="./laboratorio.php?day=2&lab=Traforo">Giorno 2</a>
                <a href="./laboratorio.php?day=3&lab=Traforo">Giorno 3</a>
                <a href="./laboratorio.php?day=4&lab=Traforo">Giorno 4</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Cucina</a>
                <div class="dropdown-content">
                <a href="./laboratorio.php?day=0&lab=Cucina">Complessivo</a>    
                <a href="./laboratorio.php?day=1&lab=Cucina">Giorno 1</a>
                <a href="./laboratorio.php?day=2&lab=Cucina">Giorno 2</a>
                <a href="./laboratorio.php?day=3&lab=Cucina">Giorno 3</a>
                <a href="./laboratorio.php?day=4&lab=Cucina">Giorno 4</a>
                </div>
            </li>-->
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
                        echo "<h3>Complessivo</h3>";
                    else
                        echo "<h3>Giorno ".$day."</h3>";
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
                                    echo "<th class='text-left'>Presente1</th>
                                        <th class='text-left'>Sport1</th>
                                        <th class='text-left'>Presente2</th>
                                        <th class='text-left'>Sport2</th>
                                        <th class='text-left'>Presente3</th>
                                        <th class='text-left'>Sport3</th>
                                        <th class='text-left'>Presente4</th>
                                        <th class='text-left'>Sport4</th>
                                        <th class='invisible'>LabID</th>";
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

                            $sql = "SELECT Nome, Eta, LabID, Presenza1, Sport1, Presenza2, Sport2, Presenza3, Sport3, Presenza4, Sport4 FROM Generale";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    if($day == 0) {
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">" 
                                            . $laboratori[$row["LabID"]]. " </td><td value=". $row["Presenza1"]. ">" 
                                            . $presenza[$row["Presenza1"]]. " </td><td value=". $row["Sport1"]. ">" 
                                            . $sport[$row["Sport1"]]. " </td><td value=". $row["Presenza2"]. ">" 
                                            . $presenza[$row["Presenza2"]]. " </td><td value=". $row["Sport2"]. ">" 
                                            . $sport[$row["Sport2"]]. " </td><td value=". $row["Presenza3"]. ">" 
                                            . $presenza[$row["Presenza3"]]. " </td><td value=". $row["Sport3"]. ">" 
                                            . $sport[$row["Sport3"]]. " </td><td value=". $row["Presenza4"]. ">" 
                                            . $presenza[$row["Presenza4"]]. " </td><td value=". $row["Sport4"]. ">" 
                                            . $sport[$row["Sport4"]]. " </td></tr>" ; 
                                    }
                                    
                                    if($day == 1){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">" 
                                            . $laboratori[$row["LabID"]]. " </td><td value=". $row["Presenza1"]. ">" 
                                            . $presenza[$row["Presenza1"]]. " </td><td value=". $row["Sport1"]. ">" 
                                            . $sport[$row["Sport1"]]. " </td></tr>"; 
                                    }

                                    if($day == 2){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">" 
                                            . $laboratori[$row["LabID"]]. " </td><td value=". $row["Presenza2"]. ">" 
                                            . $presenza[$row["Presenza2"]]. " </td><td value=". $row["Sport2"]. ">" 
                                            . $sport[$row["Sport2"]]. " </td></tr>"; 
                                    }

                                    if($day == 3){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">" 
                                            . $laboratori[$row["LabID"]]. " </td><td value=". $row["Presenza3"]. ">" 
                                            . $presenza[$row["Presenza3"]]. " </td><td value=". $row["Sport3"]. ">" 
                                            . $sport[$row["Sport3"]]. " </td></tr>"; 
                                    }

                                    if($day == 4){
                                        echo "<tr class='clickable'><td class='text-left'>" 
                                            . $row["Nome"]. "</td><td>" 
                                            . $row["Eta"]. " </td><td value=". $row["LabID"]. ">" 
                                            . $laboratori[$row["LabID"]]. " </td><td value=". $row["Presenza4"]. ">" 
                                            . $presenza[$row["Presenza4"]]. " </td><td value=". $row["Sport4"]. ">" 
                                            . $sport[$row["Sport4"]]. " </td></tr>"; 
                                    }
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