<?php
    
    define('DB_SERVER', 'localhost');
	define('DB_USERNAME', '');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', '');
	
	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
    $stmt = $db->prepare("SELECT * FROM attendance");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
            
    $count = mysqli_num_rows($result);
    $stmt->close();
    
    for($i = 0; $i < $count; $i++) {
        $time = intval($row[$i]['unix']) + 21600;
        echo $row[$i]['studentid']." ".$row[$i]['course']." Sec: ".$row[$i]['sec']." ".gmdate("d-m-Y h:i:s A", $time);
        echo "<br><br>";
    }
?>