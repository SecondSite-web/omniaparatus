<?php
require_once '../php/connect-pdo.php';
// sql to create table
    try {
    $sql = "CREATE TABLE departments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    department VARCHAR(30) NOT NULL,
    department_no VARCHAR(30) NOT NULL
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table MyGuests created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;