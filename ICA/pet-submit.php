<?php
    $error = FALSE;
    if (isset($_POST['species'])){
        echo "Error: Pet species was not set!";
        $error = TRUE;
    }
    if (isset($_POST['name'])){
        echo "Error: Pet name was not set!";
        $error = TRUE;
    }
    if (isset($_POST['weight'])){
        echo "Error: Pet weight was not set!";
        $error = TRUE;
    }
    if (isset($_POST['description'])){
        echo "Error: Pet description was not set!";
        $error = TRUE;
    }
    $filename = basename($_FILES['picture']['name']);
	if( !preg_match('/^[\w_\.\-]+$/', $filename) ){			#filtering
        echo "Invalid filename";
        $error = TRUE;
	}
    if ($error) exit();
    
    $species = $_POST['species'];
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $description = $_POST['descritpion'];
    $full_path = sprintf("/home/bflynn/ICApics/%s%s%s", $species, $name, $filename);
    
    if (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) {
        echo "Transfer fail...";
        exit();
    }
    $mysqli = new mysqli('localhost', 'root', 'Xboxlive1', 'petdb');
 
    if($mysqli->connect_errno) {
        printf("Connection Failed: %s\n", $mysqli->connect_error);
        exit;
    }
    
    $stmt = $mysqli->prepare("insert into pets (species, name, weight, description, filename) values (?, ?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit();
    }

    $stmt->bind_param('ssdss', $species, $name, $weight, $description, $full_path);
 
    $stmt->execute();
 
    $stmt->close();
    
    header("Location: pet-listings.php"); 
    exit();

?>