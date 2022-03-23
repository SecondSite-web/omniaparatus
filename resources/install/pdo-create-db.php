<?php
require_once __DIR__ . '/../config.php';
$host=DBHost;

$root=DBUser;
$root_password=DBPassword;

$user=DBUser;
$pass=DBPassword;
$db=DBName;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Twig Template Standalone Installation</title>

    <!-- Custom styles for this template-->
    <link href="../../css/styles.min.css" rel="stylesheet">

</head>

<body class="bg-light" style="min-height: 100vh;">

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12 pt-2 pb-5">
            <h1>Database Creation</h1>
            <?php
                try {
                    $dbh = new PDO("mysql:host=$host", $root, $root_password);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $dbh->exec("CREATE DATABASE `$db`;
                            CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                            GRANT ALL ON `$db`.* TO '$user'@'localhost';
                            FLUSH PRIVILEGES;");
                    echo '<div class="alert alert-success">' . "DATABASE".DBName." was creted successfully". '</div>';

                } catch (PDOException $e) {
                    $message = $e->getMessage();
                    echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
                }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a class="btn btn-primary btn-lg" href="pdo-install.php">Create Tables</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>