<?php
    $mysqli = new mysqli('localhost', 'root', 'Xboxlive1', 'petdb');
 
    if($mysqli->connect_errno) {
        printf("Connection Failed: %s\n", $mysqli->connect_error);
        exit;
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Pet Listings</title>
		<style type="text/css">
			body{
				width: 760px; /* how wide to make your web page */
				background-color: teal; /* what color to make the background */
				margin: 0 auto;
				padding: 0;
				font:12px/16px Verdana, sans-serif; /* default font */
			}
			div#main{
				background-color: #FFF;
				margin: 0;
				padding: 10px;
			}
		</style>
	</head>
	<body><div id="main">
		<h1>Pet Listings</h1>
		<?php
			$stmt = $mysqli->prepare("select count(species) as numspec, species from pets");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit();
			}
			$stmt->execute();
 
			$stmt->bind_result($numspec, $species);
			
			echo "We have <br><ul>\n";
			while($stmt->fetch()){
				printf("\t<li>%s %s</li>\n",
					htmlspecialchars($numspec),
					htmlspecialchars($species)
				);
			}
			echo "</ul>\n";
			
			$stmt->close();
			$stmt = $mysqli->prepare("select species, name, weight, description, filename from pets");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit();
			}
			
			$stmt->execute();
			
			$stmt->bind_result($species, $name, $weight, $description, $filename);
			
			echo "<ul>\n";
			while($stmt->fetch()){
				printf("\t<li><img id=%s src=%s alt='birthday1'>
					   
					   
					   </li>\n",
					htmlspecialchars($numspec),
					htmlspecialchars($species)
				);
			}
			echo "</ul>\n";
			
		?>
	</div></body>
</html>