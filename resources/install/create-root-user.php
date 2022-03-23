<?php
require_once __DIR__ . "/functions.php";
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);
$firstname = 'Greg';
$lastname = 'Schoeman';
$rootemail = 'gregory@realhost.co.za';
$rootpassword = '8rnD076345tgLyhD78SF4S';

$params = array('firstname' => $firstname, 'lastname' => $lastname, 'userrole' => 'admin');
$result = $auth->register($rootemail, $rootpassword, $rootpassword, $params);



