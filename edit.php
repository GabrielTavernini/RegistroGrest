<?php
    $laboratori = array();
    $sport = array();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Grest";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $editName = $_GET["nome"];
    $editEta = $_GET["eta"];
    $editLab = "";
    $editPre1 = "";
    $editPre2 = "";
    $editPre3 = "";
	$editPre4 = "";
    $editSport = "";

    $sql = "SELECT * FROM Generale WHERE Nome='$editName' && Eta='$editEta'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $editLab = $row["LabID"];
            $editPre1 = $row["Presenza1"];
            $editPre2 = $row["Presenza2"];
            $editPre3 = $row["Presenza3"];
            $editPre4 = $row["Presenza4"];
            $editSport = $row["Sport"];;
        }
    } else {
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


    if(isset($_POST["update"])) {    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $nome = $_POST["nome"];
        $eta = $_POST["eta"];

        if(isset($_POST["pre1"])){
            $pre1 = $_POST["pre1"];
        }else{ $pre1 = 0;}

        if(isset($_POST["pre2"])){
            $pre2 = $_POST["pre2"];
        }else{ $pre2 = 0;}

        if(isset($_POST["pre3"])){
            $pre3 = $_POST["pre3"];
        }else{ $pre3 = 0;}
        
        if(isset($_POST["pre4"])){
            $pre4 = $_POST["pre4"];
        }else{ $pre4 = 0;}
        
        $sport = $_POST["sport"];
        $lab = $laboratori[$_POST["lab"]];
        $LabID = $_POST["lab"];

        $sql = "UPDATE Generale SET Nome = '$nome', Eta = '$eta', Presenza1 ='$pre1', Presenza2 = '$pre2', 
		Presenza3 = '$pre3', Presenza4 = '$pre4', Sport = '$sport', LabID = '$LabID' 
        WHERE Nome='$editName' && Eta='$editEta'";

        if ($conn->query($sql) === TRUE) {
            header('LOCATION:./general.php'); die();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    if(isset($_POST["delete"])) {    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "DELETE FROM Generale WHERE Nome='$editName' && Eta='$editEta'";

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
    <title>Edit</title>
    <link rel="stylesheet" href="./Style/style.css" type="text/css">
    <link rel="stylesheet" href="./Style/inputs.css" type="text/css">
  </head>

  <body>
    <div class="login-page">
      <div class="form">
        <form class="login-form"  name="input" action="" method="post">
            <input type="text" placeholder="Nome Cognome" name="nome" value="<?php echo $editName; ?>"/>
            <input type="text" placeholder="Età" name="eta" value="<?php echo $editEta; ?>"/>
            <div class="select">
                <select name="lab" >
                    <option value="99" <?php if($editLab == '99') { echo 'selected'; } ?>>Seleziona Laboratorio</option>
                    <?php
                        for ($x = 0; $x < count($laboratori); $x++) {
                            if($editLab == $x) { 
                                echo "<option value='$x' selected>$laboratori[$x]</option>";
                            }
                            else{
                                echo "<option value='$x'>$laboratori[$x]</option>";
                            }
                        } 
                    ?>
                </select>
                <div class="select__arrow"></div>
            </div>  
			<div class="select">
                <select name="sport">
                    <option value="99" <?php if($editSport== '99') { echo 'selected'; } ?>>Seleziona Sport</option> 
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            if($editSport == $x) { 
                                echo "<option value='$x' selected>$sport[$x]</option>";
                            }
                            else{
                                echo "<option value='$x'>$sport[$x]</option>";
                            }
                        } 
                    ?>
                </select>
                <div class="select__arrow"></div>
            </div>  
            <label class="control control--checkbox">Presenza 1<input type="checkbox" <?php if($editPre1 == 1) {echo 'checked';} ?> value="1" name="pre1"/> <div class="control__indicator"></div> </label>     
            <label class="control control--checkbox">Presenza 2<input type="checkbox" <?php if($editPre2 == 1) {echo 'checked';} ?> value="1" name="pre2"/> <div class="control__indicator"></div> </label>
            <label class="control control--checkbox">Presenza 3<input type="checkbox" <?php if($editPre3 == 1) {echo 'checked';} ?> value="1" name="pre3"/> <div class="control__indicator"></div> </label>       
            <label class="control control--checkbox">Presenza 4<input type="checkbox" <?php if($editPre4 == 1) {echo 'checked';} ?> value="1" name="pre4"/> <div class="control__indicator"></div> </label>
            
            <div>
                <button type="submit" name="update">SALVA</button>
                <button type="submit" name="delete" style="background: #f72c2c;">ELIMINA</button>
            </div> 
        </form>
      </div>
    </div>
  </body>
</html>