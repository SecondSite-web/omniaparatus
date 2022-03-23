<?php

// Create connection
$conn = new mysqli(DBHost, DBUser, DBPassword, DBName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>