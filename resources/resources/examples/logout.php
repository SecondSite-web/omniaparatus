<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:15 PM
 */

<?php

require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$email = "mbckchamathsilva@gmail.com";
$password = "ucsc@123!@#AB";
$repeatpassword = "ucsc@123!@#A";
echo '<pre>';
$result = $auth->logout($auth->getSessionHash());
var_dump($result);
//header('location: ../../../index.php');
echo '<br>';