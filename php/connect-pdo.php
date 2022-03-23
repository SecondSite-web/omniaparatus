<?php

try {
    $dbh = new PDO("mysql:host=".DBHost.";dbname=".DBName."", DBUser, DBPassword);
    // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

