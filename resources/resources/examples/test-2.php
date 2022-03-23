<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:00 PM
 */

include "Config.php";
include "Auth.php";
$dbh = new PDO("mysql:host=localhost;dbname=user_login", "root", "root") or die("lolo");
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
var_dump($auth->getUser(5));
$email = "mbckchamathsilva@gmail.com";
$password = "ucsc@123!@#A";
$password2 = "ucsc@123!@#AB";
//var_dump($auth->resendActivation($email,1));
var_dump($auth->logout($auth->getSessionHash()));
//var_dump($auth->changePassword(5,$password,$password2,$password2));
if (!$auth->isLogged()) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";
    exit;
} else {
    echo "youhaveloginchamath SIlva";
}