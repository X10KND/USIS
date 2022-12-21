<?php
    
    define('DB_SERVER', 'localhost');
	define('DB_USERNAME', '');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', '');
	
	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
    class Google2FA {
    
    	const keyRegeneration 	= 5;
    	const otpLength		= 6;
    
    	private static $lut = array(
    		"A" => 0,	"B" => 1,
    		"C" => 2,	"D" => 3,
    		"E" => 4,	"F" => 5,
    		"G" => 6,	"H" => 7,
    		"I" => 8,	"J" => 9,
    		"K" => 10,	"L" => 11,
    		"M" => 12,	"N" => 13,
    		"O" => 14,	"P" => 15,
    		"Q" => 16,	"R" => 17,
    		"S" => 18,	"T" => 19,
    		"U" => 20,	"V" => 21,
    		"W" => 22,	"X" => 23,
    		"Y" => 24,	"Z" => 25,
    		"2" => 26,	"3" => 27,
    		"4" => 28,	"5" => 29,
    		"6" => 30,	"7" => 31
    	);
    	public static function get_timestamp() {
    		return floor(microtime(true)/self::keyRegeneration);
    	}
    	public static function base32_decode($b32) {
    
    		$b32 	= strtoupper($b32);
    
    		if (!preg_match('/^[ABCDEFGHIJKLMNOPQRSTUVWXYZ234567]+$/', $b32, $match))
    			throw new Exception('Invalid characters in the base32 string.');
    
    		$l 	= strlen($b32);
    		$n	= 0;
    		$j	= 0;
    		$binary = "";
    
    		for ($i = 0; $i < $l; $i++) {
    
    			$n = $n << 5; 				// Move buffer left by 5 to make room
    			$n = $n + self::$lut[$b32[$i]]; 	// Add value into buffer
    			$j = $j + 5;				// Keep track of number of bits in buffer
    
    			if ($j >= 8) {
    				$j = $j - 8;
    				$binary .= chr(($n & (0xFF << $j)) >> $j);
    			}
    		}
    
    		return $binary;
    	}
    
    	public static function oath_hotp($key, $counter)
    	{
    	    if (strlen($key) < 8)
    		throw new Exception('Secret key is too short. Must be at least 16 base 32 characters');
    
    	    $bin_counter = pack('N*', 0) . pack('N*', $counter);		// Counter must be 64-bit int
    	    $hash 	 = hash_hmac ('sha1', $bin_counter, $key, true);
    
    	    return str_pad(self::oath_truncate($hash), self::otpLength, '0', STR_PAD_LEFT);
    	}
    	public static function oath_truncate($hash)
    	{
    	    $offset = ord($hash[19]) & 0xf;
    
    	    return (
    	        ((ord($hash[$offset+0]) & 0x7f) << 24 ) |
    	        ((ord($hash[$offset+1]) & 0xff) << 16 ) |
    	        ((ord($hash[$offset+2]) & 0xff) << 8 ) |
    	        (ord($hash[$offset+3]) & 0xff)
    	    ) % pow(10, self::otpLength);
    	}
    }
    
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET['course']) && isset($_GET['sec'])  && isset($_GET['otp']) && isset($_GET['id']) && isset($_GET['unix']))  {
            
            $file = fopen("test.txt","a");
            fwrite($file,$_GET['course']." ".$_GET['sec']." ".$_GET['otp']." ".$_GET['id']." ".$_GET['unix']."\n");
            fclose($file);
            
            
            $course = $_GET['course'];
            $sec = $_GET['sec'];
            $otp = $_GET['otp'];
            $id = $_GET['id'];
            $unix = $_GET['unix'];
            $date = gmdate("d-m-Y", (intval($_GET['unix']) * 5) + 21600);
            
            $stmt = $db->prepare("SELECT * FROM course WHERE course = ? AND sec = ?");
            $stmt->bind_param("ss", $course, $sec);
            
            $stmt->execute();
            $result = $stmt->get_result();
            $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
            
            $count = mysqli_num_rows($result);
            $stmt->close();
            
            if($count == 1) {
                $InitalizationKey = $row[0]['seed'];
                $TimeStamp = $_GET['unix'];
                $secretkey 	  = Google2FA::base32_decode($InitalizationKey);
                
                $serverotp = Google2FA::oath_hotp($secretkey, $TimeStamp);
                //$otp2 = Google2FA::oath_hotp($secretkey, $TimeStamp - 1);
                
                if($otp == $serverotp) {
                    $stmt2 = $db->prepare("INSERT INTO attendance (studentid, course, sec, unix, date) VALUES (?,?,?,?,?)");
                    $stmt2->bind_param("sssss", $id, $course, $sec, strval(intval($unix) * 5), $date);
                    $stmt2->execute();
                    $stmt2->close();
                    print_r("success");
                }
                else {
                    print_r("failed1");
                }
            }
            else {
                print_r("failed2");
            }
        }
        else {
            print_r("failed3");
        }
    }
    else {
        print_r("failed4");
    }
?>