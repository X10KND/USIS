<?php
    
    define('DB_SERVER', 'localhost');
	define('DB_USERNAME', '');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', '');
	
	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    
    session_start();
    
    function mysqli_field_name($result, $field_offset)
    {
        $properties = mysqli_fetch_field_direct($result, $field_offset);
        return is_object($properties) ? $properties->name : null;
    }
    
	if(isset($_SESSION['loginstatus'])) {
		if($_SESSION['loginstatus'] == 0) {
			header("location: ../");
		}
	}
	else {
		header("location: ../");
	}
	
	if($_SERVER["REQUEST_METHOD"] == "GET") {
	
		$stmt = $db->prepare("SELECT * FROM course WHERE initials = ? AND course = ? AND sec = ?");
        $stmt->bind_param("sss", $_SESSION['initials'], $_GET['course'], $_GET['sec']);
        $stmt->execute();
    	
        $result2 = $stmt->get_result();
        $count = mysqli_num_rows($result2);
        
        $stmt->close();
		
		if($count == 1) {
			$stmt2 = $db->prepare("SELECT DISTINCT * FROM attendance WHERE course = ? AND sec = ?");
			$stmt2->bind_param("ss", $_GET['course'], $_GET['sec']);
            $stmt2->execute();
            $result = $stmt2->get_result();
            $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
            $count2 = mysqli_num_rows($result);
            $stmt2->close();
            
            $filename = "test";
            
            $file_ending = "xls";
            
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=$filename.xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $sep = "\t"; //tabbed character
            
            /*for ($i = 0; $i < mysqli_num_fields($result) - 1; $i++) {
                echo mysqli_field_name($result,$i) . "\t";
            }*/
            echo "Student ID" . "\t";
            echo "Course" . "\t";
            echo "Sec" . "\t";
            echo "Date" . "\t";
            
            print("\n");    
            
                for($i=0; $i<$count2;$i++)
                {
                    $schema_insert = "";
                    
                    $schema_insert .= $row[$i]['studentid'].$sep;
                    $schema_insert .= $row[$i]['course'].$sep;
                    $schema_insert .= $row[$i]['sec'].$sep;
                    $schema_insert .= gmdate("d-m-Y h:i:s A", intval($row[$i]['unix']) + 21600).$sep;
                    
                    $schema_insert = str_replace($sep."$", "", $schema_insert);
                    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                    $schema_insert .= "\t";
                    print(trim($schema_insert));
                    print "\n";
                }   
        
		}
		else {
		    print_r("Course not found");
		}
	}
?>