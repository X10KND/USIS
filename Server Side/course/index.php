<!DOCTYPE html>

<?php
    
	$error = "";
	
    define('DB_SERVER', 'localhost');
	define('DB_USERNAME', '');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', '');
	
	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
    session_start();
    
	if(isset($_SESSION['loginstatus'])) {
		if($_SESSION['loginstatus'] == 0) {
			header("location: ../");
		}
	}
	else {
		header("location: ../");
	}
	
    $stmt = $db->prepare("SELECT * FROM course WHERE initials = ?");
    $stmt->bind_param("s", $_SESSION['initials']);
    $stmt->execute();
	
    $result = $stmt->get_result();
    $row = mysqli_fetch_all($result,MYSQLI_ASSOC);    
    $count = mysqli_num_rows($result);

?>


<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	
	<style>
		.center {
		  margin: auto;
		  width: 10%;
		  padding: 10px;
		}
		
		.card {
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
          max-width: 300px;
          margin: auto;
          text-align: center;
          font-family: arial;
        }
        
        .title {
          color: #333;
          font-size: 18px;
        }

        
        
        button:hover, a:hover {
          opacity: 0.7;
        }
	</style>
</head>
<body>
    <h2 style="text-align:center"></h2>
    
    <div class="card" style="margin: 100px auto auto auto;">
        <img src="image/<?php echo $_SESSION['initials'] ?>.jpg" style="width:100%">
        <h2><?php echo $_SESSION['name']?></h2>
        <p class="title"><?php echo $_SESSION['title'] . ", " . $_SESSION['dept']?></p>
        <p>Brac University</p>
        <button class="w3-button w3-red" onclick="document.location.href=this.getAttribute('href');" href="../logout">Logout</button>
	    <br><br>
        <div class="w3-dropdown-hover">
        <button class="w3-button w3-black">Available Course</button>
		<div class="w3-dropdown-content w3-bar-block w3-border">
		<?php
			for($i = 0; $i < $count; $i++) {
			    echo "<a href=../code?course=". $row[$i]['course'] . "&sec=" . $row[$i]['sec'] ." class=\"w3-bar-item w3-button\">". $row[$i]['course'] . " Sec: " . $row[$i]['sec'] ."</a>";
			}
		?>
	    </div>
	    <br><br>
    </div>
    </div>


</body>
</html>