<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myGuest"; 

try {  
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Connected to the database successfully!<br>";    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
