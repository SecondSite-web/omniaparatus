<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../config.php';
// require_once __DIR__.'/../php/connect-pdo.php';
include 'variables.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('User Registration');
$log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/register.log', Logger::INFO));

$params = array('firstname' => 'James', 'lastname' => 'Brown', 'userrole' => 'admin');
$params2 = array('firstname' => 'test', 'lastname' => 'User', 'userrole' => 'admin');
$params3 = array('firstname' => 'Daniel', 'lastname' => 'Schoeman', 'userrole' => 'guest');
$params4 = array('firstname' => 'IP', 'lastname' => 'Freely', 'userrole' => 'guest');

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

<body class="bg-light">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-md-12 pt-2 pb-5">
          <hr />
          <h3>Writing Test User account with PHPAuth </h3>
          <p class="lead">5 Test user Accounts being written and a test contact form submission</p>
          <?php
              $testpass = '8nD076345LyhDSFS';
              use PHPAuth\Config as PHPAuthConfig;
              use PHPAuth\Auth as PHPAuth;
              $config = new PHPAuthConfig($dbh);
              $auth = new PHPAuth($dbh, $config);
              $result = $auth->register('info@secondsite.xyz', $testpass, $testpass, $params);
              $result = $auth->register('gregory@westafricaventure.com', $testpass, $testpass, $params2);
              $result = $auth->register('info@realhost.co.za', $testpass, $testpass, $params3);
              $result = $auth->register('test@email.com', $testpass, $testpass, $params4);

              if ($result['error'] == 'true') {
                  echo '<div class="alert alert-warning">'.$result['message'].'</div>';
                  $log->addError($result['message'], array('Email Address',  'root'));
              } else {
                  echo '<div class="alert alert-success">'.$result['message'].'</div>';
                  $log->addInfo($result['message'], array('Email Address',  'root'));
              }

            ?>
          <hr />
          <h3>Writing Test Contact Form Submissions </h3>
          <?php
          $DB = new Db();
          $values = array(null,"Gregory","Schoeman", "passed", "gregory@realhost.co.za", "Please contact me when you have a mo.");
          $DB->query("INSERT INTO contact_form(id,firstname,lastname,honeypot,email,message) VALUES(?,?,?,?,?,?)", $values);

          ?>

        </div>
      </div>
      <div class="row text-center pb-2 mb-2">
          <div class="col-12 align-content-center text-center">
              <a href="../../twig" class="btn btn-primary btn-lg" target="_self">To Twig Home Page</a>
              <br>
          </div>
      </div>
    </div>
  </body>
</html>