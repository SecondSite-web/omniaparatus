<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:02 PM
 */

<?php

require "../DB/Db.class.php";
$db = new Db();
//var_dump($db->getPurePodo());
$dbh = $db->getPurePodo();
include "Config.php";
include "Auth.php";
//$dbh = new PDO("mysql:host=localhost;dbname=user_login", "root", "root") or Die("lolo");
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$email = "mbckchamathsilva@gmail.com";
$password = "ucsc@123!@#AB";
$repeatpassword = "ucsc@123!@#A";
$params = array("A" => "apple", "B" => "orange", "C" => "how");
var_dump($params);
//var_dump($auth->register($email,$password,$repeatpassword ,$params));
echo '<br>';
$temp = $auth->login($email, $password);
var_dump($temp);
echo '<br>';
//echo $temp;
//setcookie("authID", "", time() - 360000000);
setcookie('authID', $temp["hash"], $temp["expire"]);
