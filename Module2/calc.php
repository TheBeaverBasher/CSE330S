<!doctype html>
<html>
	<head>
		<title>Calculator</title>
		<meta charset="utf-8"/>
	</head>
	<body>
		<?php
			$num1 = $_GET['num1'];
			$num2 = $_GET['num2'];
			$cal = $_GET['opt'];
			switch($cal) {
				case 'add':
				echo $num1+$num2;
				break;

				case 'sub':
				echo $num1-$num2;
				break;

				case 'mul':
				echo $num1*$num2;
				break;

				case 'div':
				if ($num2 ==0){
				echo "You can't divide by zero!";
				break;
				}
				echo $num1/$num2;
				break;
			}
		?>
	</body>
</html>
