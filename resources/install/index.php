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
    <link href="../css/styles.min.css" rel="stylesheet">

</head>

<body class="bg-light" style="min-height: 100vh;">

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12 pt-2 pb-5">
            <h1>Installation Menu</h1>
            <h3>Process</h3>
            <p class="lead">Please run through the following process</p>
            <p class="text-warning">Please set your database settings mannually in the file '../config.php' and your settings in './install/variables.php'</p>
            <br />
            <strong>Select your Database Language</strong>
        </div>
        <div class="row">
            <div class="col-md-6 text-center">
                <h4>Use PDO</h4>
                <a class="btn btn-primary btn-lg m-4" href="pdo-create-db.php">Create DB</a><br />
                <a class="btn btn-primary btn-lg m-4" href="pdo-install.php">PDO</a>
            </div>
            <div class="col-md-6 text-center">
                <h4>Use MySqli</h4>
                <a class="btn btn-primary btn-lg m-4" href="pdo-create-db.php">Create DB</a><br />
                <a class="btn btn-primary btn-lg m-4" href="install.php">MySqli</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>