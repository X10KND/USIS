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
	
		$stmt = $db->prepare("SELECT * FROM course WHERE course = ? AND sec = ?");
		$stmt->bind_param("ss", $_GET['course'], $_GET['sec']);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$row = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);
		
		if($count == 1) {
			$course = $row[0]['course'];
			$sec = $row[0]['sec'];
			$seed = $row[0]['seed'];
		}
		else {
		    print_r("Course not found");
		    $course = "";
		    $sec = "";
		    $seed = "";
		}
	}
	
?>


<html><head>
<style>
    body {
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/crypto-js.min.js"></script>
<script type="text/javascript" src="js/qrcode.js"></script>

</head>

<body style="width: 45em;">

<br><br><br>

<h2 >Please scan the code using the app</h2>

<br>

<!--<img src="" id="qr"></img>-->
<div id="qrcode" style="width:400px; height:400px; margin-top:0px;"></div>
<h2 id="code-1"></h2>
<h2 id="code-2"></h2>
<p id="ticker"></p>
<p id="time"></p>

<a href="../attendance?<?php echo "course=" . $_GET['course'] . "&sec=" . $_GET['sec']; ?>">See Attendance</a>



<script src="dist/jsOTP.js"></script>
<script src="dist/MD5.js"></script>
<script>
$ = function(sel) {
  return document.querySelector(sel);
};

var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 400,
	height : 400
});

function makeCode (s) {		
	qrcode.makeCode(s);
}

function aesEncrypt(data) {
   let key = 'EAS2020EAS2020EAS2020EAS20202020';
   let iv = '2020202020202020';
   let cipher = CryptoJS.AES.encrypt(data, CryptoJS.enc.Utf8.parse(key), {
       iv: CryptoJS.enc.Utf8.parse(iv),
       padding: CryptoJS.pad.Pkcs7,
       mode: CryptoJS.mode.CBC
   });

   return cipher.toString();

}

var secret = <?php echo "\"".$seed."\"" ?>
//$('#secret').innerText = "Secret: " + secret;

var totp = new jsOTP.totp();
var code = totp.getOtp(secret);

var courseName = <?php echo "\"".$course."\"" ?>;
var courseSec = <?php echo "\"".$sec."\"" ?>;

var epoch = <?php echo round(microtime(true)) ?>;

var updateTicker = function(tick, el) {
  el.innerText = tick;
}
var updateTotp = function(secret, el, i) {
  code = totp.getOtp(secret, epoch * 1000);
  //el.innerText = code;
  //+ md5(course + epoch)
  //i.src = "https://chart.googleapis.com/chart?cht=qr&chl=" + courseName + "_" + courseSec + "_" + code + "_" + Math.floor(epoch/5) + "&chs=400x400&chld=H|0";
  //makeCode(aesEncrypt(courseName + "_" + courseSec + "_" + code + "_" + Math.floor(epoch/5)));
  makeCode(courseName + "_" + courseSec + "_" + code + "_" + Math.floor(epoch/5));
}

updateTotp(secret, $('#code-1'), $('#qr'));
updateTicker(courseName + " Sec: " + courseSec, $('#code-2'));

var timeLoop = function() {
  epoch += 1;//Math.round(new Date().getTime() / 1000.0); Using server time
  var countDown = 5 - (epoch % 5);
  //updateTicker(countDown, $('#ticker'));
  //updateTicker(epoch, $('#time'));
  if (epoch % 5 == 0) updateTotp(secret, $('#code-1'), $('#qr'));
}

setInterval(timeLoop, 1000);

</script>


</body></html>
