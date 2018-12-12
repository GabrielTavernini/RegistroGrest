<?php
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Grest";
    $pass = array();

    $conn = new mysqli($servername, $username, $password, $dbname);

	$day;
    $sql = "SELECT Giorno FROM Today";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
           $day = $row['Giorno'];
        }
	}
	
	if(isset($_POST["plus"])) {    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

		$newDay = $day + 1;
		if($newDay <= 3){
			$sql = "UPDATE Today SET Giorno = '$newDay' WHERE Giorno='$day'";
			if ($conn->query($sql) === TRUE) {
				header('LOCATION:./general.php'); die();
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			$conn->close();
		}

		header('LOCATION:./general.php'); die();
	}
	
	if(isset($_POST["minus"])) {    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

		$newDay = $day - 1;
		if($newDay >= 0){
			$sql = "UPDATE Today SET Giorno = '$newDay' WHERE Giorno='$day'";
			if ($conn->query($sql) === TRUE) {
				header('LOCATION:./general.php'); die();
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			$conn->close();
		}

		header('LOCATION:./general.php'); die();
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
            <h1><?php echo "Giorno ".($day + 1); ?></h1> 
            <div>
				<button type="submit" name="plus" style="font-size: 18px;"><b>+1</b></button>
				<button type="submit" name="minus" style="background: #f72c2c; font-size: 18px"><b>-1</b></button>
            </div> 
        </form>
      </div>
    </div>
  </body>
</html>