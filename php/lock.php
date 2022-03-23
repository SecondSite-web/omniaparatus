<?php
defined( '__root_path__' ) || exit;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

if ((!$auth->isLogged()) or ($user['isactive'] == '0') or ($user['userrole'] == 'banned')  ) {
    header("Location: ../login.php");
    exit;
}
