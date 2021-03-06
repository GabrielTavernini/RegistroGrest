<?php
    $laboratori = array();
    $sport = array();
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
    $conn->close();


  if(isset($_POST["add"])) {
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

    $nome = $_POST["nome"];
    $eta = $_POST["eta"];
    $pre1 = $_POST["pre1"];
    $pre2 = $_POST["pre2"];
    $pre3 = $_POST["pre3"];
    $pre4 = $_POST["pre4"];
    $sport4 = $_POST["sport"];
    $LabID = $_POST["lab"];

    $sql = "INSERT INTO Generale (Nome, Eta, LabID, Presenza1, Presenza2, Presenza3, Presenza4, Sport)
    VALUES ('$nome', '$eta', '$LabID', '$pre1', '$pre2', '$pre3', '$pre4', '$sport')";

    if ($conn->query($sql) === TRUE) {
        header('LOCATION:./general.php'); die();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  }
?>



<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new</title>
    <link rel="stylesheet" href="./Style/style.css" type="text/css">
    <link rel="stylesheet" href="./Style/inputs.css" type="text/css">
  </head>

  <body>
    <div class="login-page">
      <div class="form">
        <form class="login-form"  name="input" action="" method="post">
            <input type="text" placeholder="Nome Cognome" name="nome" />
            <input type="number" placeholder="Età" name="eta">
            <div class="select">
                <select name="lab">
                    <option value="99">Seleziona Laboratorio</option>
                    <?php
                        for ($x = 0; $x < count($laboratori); $x++) {
                            echo "<option value='$x'>$laboratori[$x]</option>";
                        } 
                    ?>
                </select>
                <div class="select__arrow"></div>
            </div>  
			<div class="select">
                <select name="sport">
                    <option value="99">Seleziona Sport</option>
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            echo "<option value='$x'>$sport[$x]</option>";
                        } 
                    ?>
                </select>
                <div class="select__arrow"></div>
            </div>   
            <label class="control control--checkbox">Presenza 1<input type="checkbox" value="1" name="pre1"/> <div class="control__indicator"></div> </label>
            <label class="control control--checkbox">Presenza 2<input type="checkbox" value="1" name="pre2"/> <div class="control__indicator"></div> </label>
            <label class="control control--checkbox">Presenza 3<input type="checkbox" value="1" name="pre3"/> <div class="control__indicator"></div> </label>
            <label class="control control--checkbox">Presenza 4<input type="checkbox" value="1" name="pre4"/> <div class="control__indicator"></div> </label>
            
            <button type="submit" name="add">AGGIUNGI</button>
        </form>
      </div>
    </div>
  </body>
</html>