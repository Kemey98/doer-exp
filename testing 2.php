<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	
	<?php
	if(isset($_POST['submit'])) {
	
		echo '<script type="text/javascript">';
echo 'alert("Successfully Login ");';
echo 'window.location.href="wallet.php";';
	echo '</script>';
	}
	else{
		
		header('calculation.php');
	}
	?>
</body>
</html>