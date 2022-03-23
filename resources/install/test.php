<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../php/connect-pdo.php';
include 'variables.php';


$tableNames = array(
    'contact_form',
    'phpauth_attempts',
    'phpauth_requests',
    'phpauth_sessions',
); 
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

  <?php
        try {
          $sql = "CREATE TABLE IF NOT EXISTS `contact_form` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `firstname` varchar(255) NOT NULL,
              `lastname` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `honeypot` varchar(255) NOT NULL,
              `message` text NOT NULL,
              `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
          
          $stmt = $dbh->prepare($sql);
          $stmt->execute();
          echo '<div class="alert alert-success">' . "Table contact_form was created successfully". '</div>';
        } catch (PDOException $e) {
            $message = $e->getMessage();
            echo '<div class="alert alert-danger">'."Error removing table: " . $message. '</div>';
        }