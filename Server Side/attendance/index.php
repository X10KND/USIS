<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="w3-container">
    
<?php
    
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
	
	if($_SERVER["REQUEST_METHOD"] == "GET") {
	    
	    echo '<h2>' . $_GET['course'] . " Sec " . $_GET['sec'] . ' Attendance Sheet</h2>';
	
		$stmt = $db->prepare("SELECT * FROM course WHERE initials = ? AND course = ? AND sec = ?");
        $stmt->bind_param("sss", $_SESSION['initials'], $_GET['course'], $_GET['sec']);
        $stmt->execute();
    	
        $result = $stmt->get_result();
        $count = mysqli_num_rows($result);
        
        $stmt->close();
		
		if($count == 1) {
			$stmt2 = $db->prepare("SELECT DISTINCT * FROM attendance WHERE course = ? AND sec = ?");
			$stmt2->bind_param("ss", $_GET['course'], $_GET['sec']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row = mysqli_fetch_all($result2,MYSQLI_ASSOC);
            $count2 = mysqli_num_rows($result2);
            $stmt2->close();
            
            //print_r($row);
            
            echo '<table class="w3-table-all">
                    <thead>
                      <tr class="w3-green">
                        <th>Student ID</th>
                        <th>Date</th>
                        <th>Time</th>
                      </tr>
                    </thead>';
            
            for($i = 0; $i < $count2; $i++) {
                $time = intval($row[$i]['unix']) + 21600;
                //echo $row[$i]['studentid']." ".$row[$i]['course']." Sec: ".$row[$i]['sec']." ".gmdate("d-m-Y h:i:s A", $time);
                //echo "<br><br>";
                echo  '<tr>
                        <td>'.$row[$i]['studentid'].'</td>
                        <td>'.gmdate("d-m-Y", $time).'</td>
                        <td>'.gmdate("h:i:s A", $time).'</td>
                      </tr>';
            }
            ?>
            <!---<a href="../download?<?php //echo "course=" . $_GET['course'] . "&sec=" . $_GET['sec']; ?>">Download</a>__>
            <?php
		}
		else {
		    print_r("Course not found");
		}
	}
	
?>
</div>
</body>
