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
		if($_SESSION['loginstatus'] == 1) {
			header("location: course");
		}
	}
	
    if($_SERVER["REQUEST_METHOD"] == "POST") {
		
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $count = mysqli_num_rows($result);
        
        $hash = $row['password'];
		
        if($count == 1 && password_verify($password, $hash)) {
            
			$_SESSION['loginstatus'] = 1;
            $_SESSION['name'] = $row['name'];
			$_SESSION['initials'] = $row['initials'];
			$_SESSION['dept'] = $row['dept'];
			$_SESSION['title'] = $row['title'];
                
            //setcookie("PHPSESSID", $_COOKIE["PHPSESSID"], time() + (86400 * 7), "/");
                
            header("location: course");
			$error = "";
        }
        else {
            $_SESSION['loginstatus'] = 0;
            $error = "Your Login Name or Password is invalid";
        }
    }
?>


<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================--
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================--
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic">
					<img src="images/EAS.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="" method="post">
					<span class="login100-form-title">
						Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: example@gmail.com">
						<input class="input100" type="text" name="username" placeholder="Email">
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
						<br><br>
						<span class="txt2" style="color: #FF0000;">
							<?php echo $error; ?>
						</span>

					</div>
					<div class="text-center p-t-136">
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================--
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================--
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================--
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>