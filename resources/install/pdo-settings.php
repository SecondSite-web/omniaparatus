<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../php/connect-pdo.php';
include 'variables.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('User Registration');
$log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/register.log', Logger::INFO));

$params = array('firstname' => $firstname, 'lastname' => $lastname, 'userrole' => 'root');


$tableNames = array(
    'phpauth_users',
    'phpauth_config',
    'twig_settings',
    'rental_settings'
    );
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
        <h1>Installation Results</h1>
        <h3>Table Cleaning</h3>
        <p class="lead">All tables and Data are erased completely</p>
      <?php
            foreach ($tableNames as $key => $value) {
              try {
                    $sql = "DROP TABLE IF EXISTS $value";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    echo '<div class="alert alert-success">' . "Table $value was removed successfully". '</div>';
                  } catch (PDOException $e) {
                      $message = $e->getMessage();
                      echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
                  }
      } ?>
      <hr />
      <h3>Table Creation</h3>
      <p class="lead">New Tables are being Created and Settings are being Stored</p>
      <?php
      try {
        $sql = "CREATE TABLE IF NOT EXISTS `phpauth_users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `email` varchar(100) DEFAULT NULL,
          `password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
          `isactive` tinyint(1) NOT NULL DEFAULT '0',
          `firstname` varchar(100) DEFAULT NULL,
          `lastname` varchar(100) DEFAULT NULL,
          `phone` varchar(100) DEFAULT NULL,
          `userrole` varchar(100) DEFAULT NULL,
          `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $stmt = $dbh->prepare($sql);
            $stmt->execute();
              echo '<div class="alert alert-success">' . "Table phpauth_users was created successfully". '</div>';
            } catch (PDOException $e) {
              $message = $e->getMessage();
              echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
            }
            unset($sql);

            try {
            $sql = "CREATE TABLE IF NOT EXISTS `phpauth_config` (
              `setting` varchar(100) NOT NULL,
              `value` varchar(100) DEFAULT NULL,
              UNIQUE KEY `setting` (`setting`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

            $stmt = $dbh->prepare($sql);
            $stmt->execute();
              echo '<div class="alert alert-success">' . "Table phpauth_config was created successfully". '</div>';
            } catch (PDOException $e) {
              $message = $e->getMessage();
              echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
            }
            unset($sql);

            try {
            $sql = "CREATE TABLE IF NOT EXISTS `twig_settings` (
              `setting` varchar(100) NOT NULL,
              `value` varchar(100) DEFAULT NULL,
              UNIQUE KEY `setting` (`setting`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

            $stmt = $dbh->prepare($sql);
            $stmt->execute();
              echo '<div class="alert alert-success">' . "Table twig_settings was created successfully". '</div>';
            } catch (PDOException $e) {
              $message = $e->getMessage();
              echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
            }
            unset($sql);

      try {
          $sql = "CREATE TABLE IF NOT EXISTS `rental_settings` (
              `setting` varchar(100) NOT NULL,
              `value` varchar(100) DEFAULT NULL,
              `description` varchar(100) DEFAULT NULL,
              UNIQUE KEY `setting` (`setting`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

          $stmt = $dbh->prepare($sql);
          $stmt->execute();
          echo '<div class="alert alert-success">' . "Table rental_settings was created successfully". '</div>';
      } catch (PDOException $e) {
          $message = $e->getMessage();
          echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
      }
      unset($sql);

             ?>
            <hr />
              <h3>Writing Settings</h3>
              <p class="lead">Settings are being filed in the database</p>
              <?php
              try {
            $sql = "INSERT INTO `twig_settings` (`setting`, `value`) VALUES

            ('debug', '$debug'),
            ('email', '$email'),
            ('emailname', '$emailname'),
            ('pass', '$pass'),
            ('smtphost', '$smtphost'),
            ('smtpauth', '$smtpauth'),
            ('smtpsecure', '$smtpsecure'),
            ('smtpport', '$smtpport'),
            ('subjectline', '$subjectline'),
            ('mailcc', '$mailcc'),
            ('mailbcc', '$mailbcc'),
            ('siteurl', '$siteurl'),
            ('sitename', '$sitename'),
            ('allowRegister', '$allowRegister'),
            ('site_admin_dir', '$site_admin_dir');";

            $stmt = $dbh->prepare($sql);
            $stmt->execute();
              echo '<div class="alert alert-success">' . "Table twig_settings was created successfully". '</div>';
            } catch (PDOException $e) {
              $message = $e->getMessage();
              echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
            }
            unset($sql);

          try {
          $sql = "INSERT INTO `phpauth_config` (`setting`, `value`) VALUES
          ('attack_mitigation_time', '$attack_mitigation_time'),
          ('attempts_before_ban', '$attempts_before_ban'),
          ('attempts_before_verify', '$attempts_before_verify'),
          ('bcrypt_cost', '$bcrypt_cost'),
          ('cookie_domain', '$cookie_domain'),
          ('cookie_forget', '$cookie_forget'),
          ('cookie_http', '$cookie_http'),
          ('cookie_name', '$cookie_name'),
          ('cookie_path', '$cookie_path'),
          ('cookie_remember', '$cookie_remember'),
          ('cookie_secure', '$cookie_secure'),
          ('cookie_renew', '$cookie_renew'),
          ('allow_concurrent_sessions', '$allow_concurrent_sessions'),
          ('emailmessage_suppress_activation', '$emailmessage_suppress_activation'),
          ('emailmessage_suppress_reset', '$emailmessage_suppress_reset'),
          ('mail_charset', '$mail_charset'),
          ('password_min_score', '$password_min_score'),
          ('site_activation_page', '$site_activation_page'),
          ('site_email', '$site_email'),
          ('site_key', '$site_key'),
          ('site_name', '$site_name'),
          ('site_password_reset_page', '$site_password_reset_page'),
          ('site_timezone', '$site_timezone'),
          ('site_url', '$site_url'),
          ('site_language', '$site_language'),
          ('smtp', '$smtp'),
          ('smtp_debug', '$smtp_debug'),
          ('smtp_auth', '$smtp_auth'),
          ('smtp_host', '$smtp_host'),
          ('smtp_password', '$smtp_password'),
          ('smtp_port', '$smtp_port'),
          ('smtp_security', '$smtp_security'),
          ('smtp_username', '$smtp_username'),
          ('table_attempts', '$table_attempts'),
          ('table_requests', '$table_requests'),
          ('table_sessions', '$table_sessions'),
          ('table_users', '$table_users'),
          ('table_emails_banned', '$table_emails_banned'),
          ('table_translations', '$table_translations'),
          ('verify_email_max_length', '$verify_email_max_length'),
          ('verify_email_min_length', '$verify_email_min_length'),
          ('verify_email_use_banlist', '$verify_email_use_banlist'),
          ('verify_password_min_length', '$verify_password_min_length'),
          ('request_key_expiration', '$request_key_expiration'),
          ('translation_source', '$translation_source'),
          ('recaptcha_enabled', '$recaptcha_enabled'),
          ('recaptcha_site_key', '$recaptcha_site_key'),
          ('recaptcha_secret_key', '$recaptcha_secret_key');";

            $stmt = $dbh->prepare($sql);
            $stmt->execute();
              echo '<div class="alert alert-success">' . "Table phpauth_config was created successfully". '</div>';
            } catch (PDOException $e) {
              $message = $e->getMessage();
              echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
            }
          unset($sql);?>
          <hr />
          <h3>Writing Root User</h3>
          <p class="lead">Root User Being Created</p>
          <?php

              use PHPAuth\Config as PHPAuthConfig;
              use PHPAuth\Auth as PHPAuth;
              $config = new PHPAuthConfig($dbh);
              $auth = new PHPAuth($dbh, $config);
              $result = $auth->register($rootemail, $rootpassword, $rootpassword, $params);

              if ($result['error'] == 'true') {
                  echo '<div class="alert alert-warning">'.$result['message'].'</div>';
                  $log->addError($result['message'], array('Email Address',  'root'));
              } else {
                  echo '<div class="alert alert-success">'.$result['message'].'</div>';
                  $log->addInfo($result['message'], array('Email Address',  'root'));
              }

            ?>

        </div>
      </div>
      <div class="row text-center pb-2 mb-2">
          <div class="col-12 align-content-center text-center">
              <a href="pdo-email-banned.php" class="btn btn-primary btn-lg" target="_blank">Email Banned List</a>
              <br>
              <a href="create-rates.php" class="btn btn-primary btn-lg" target="_blank">Create the Rate Sheets List</a>
              <br>
              <a href="rental-settings.php" class="btn btn-primary btn-lg" target="_blank">Install Rental Settings</a>
              <br>
              <a href="test-data.php" class="btn btn-primary btn-lg" target="_blank">Install Rental Settings</a>
          </div>
      </div>
    </div>
  </body>
</html>