<?php
    $laboratori;
    $sport;
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
    $editSport1 = "";
    $editSport2 = "";
    $editSport3 = "";
    $editSport4 = "";

    $sql = "SELECT * FROM Generale WHERE Nome='$editName' && Eta='$editEta'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $editLab = $row["LabID"];
            $editPre1 = $row["Presenza1"];
            $editSport1 = $row["Sport1"];
            $editPre2 = $row["Presenza2"];
            $editSport2 = $row["Sport2"];
            $editPre3 = $row["Presenza3"];
            $editSport3 = $row["Sport3"];
            $editPre4 = $row["Presenza4"];
            $editSport4 = $row["Sport4"];;
        }
    } else {
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
        
        $sport1 = $_POST["sport1"];
        $sport2 = $_POST["sport2"];
        $sport3 = $_POST["sport3"];
        $sport4 = $_POST["sport4"];
        $lab = $laboratori[$_POST["lab"]];
        $LabID = $_POST["lab"];

        $sql = "UPDATE Generale SET Nome = '$nome', Eta = '$eta', Presenza1 ='$pre1' , Sport1 = '$sport1', Presenza2 = '$pre2',
        Sport2 = '$sport2', Presenza3 = '$pre3', Sport3 = '$sport3', Presenza4 = '$pre4', Sport4 = '$sport4', LabID = '$LabID' 
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
                    <option value=" " <?php if($editLab == '') { echo 'selected'; } ?>>Seleziona Laboratorio</option>
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
            <label class="control control--checkbox">Presenza 1<input type="checkbox" <?php if($editPre1 == 1) {echo 'checked';} ?> value="1" name="pre1"/> <div class="control__indicator"></div> </label>
            <div class="select">
                <select name="sport1">
                    <option value=" " <?php if($editSport1== '') { echo 'selected'; } ?>>Seleziona Sport 1</option> //to do
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            if($editSport1 == $x) { 
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
            <label class="control control--checkbox">Presenza 2<input type="checkbox" <?php if($editPre2 == 1) {echo 'checked';} ?> value="1" name="pre2"/> <div class="control__indicator"></div> </label>
            <div class="select">
                <select name="sport2">
                    <option value=" " <?php if($editSport2== '') { echo 'selected'; } ?>>Seleziona Sport 2</option> //to do
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            if($editSport2 == $x) { 
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
            <label class="control control--checkbox">Presenza 3<input type="checkbox" <?php if($editPre3 == 1) {echo 'checked';} ?> value="1" name="pre3"/> <div class="control__indicator"></div> </label>
            <div class="select">
                <select name="sport3">
                    <option value=" " <?php if($editSport3== '') { echo 'selected'; } ?>>Seleziona Sport 3</option> //to do
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            if($editSport3 == $x) { 
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
            <label class="control control--checkbox">Presenza 4<input type="checkbox" <?php if($editPre4 == 1) {echo 'checked';} ?> value="1" name="pre4"/> <div class="control__indicator"></div> </label>
            <div class="select">
                <select name="sport4">
                    <option value=" " <?php if($editSport4== '') { echo 'selected'; } ?>>Seleziona Sport 4</option> //to do
                    <?php
                        for ($x = 0; $x < count($sport); $x++) {
                            if($editSport4 == $x) { 
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
            <div>
                <button type="submit" name="update">SALVA</button>
                <button type="submit" name="delete" style="background: #f72c2c;">ELIMINA</button>
            </div> 
        </form>
      </div>
    </div>
  </body>
</html>