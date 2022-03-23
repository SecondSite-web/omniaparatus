<?php

require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$userhash = $auth->getSessionHash();
$uid = $auth->getSessionUID($userhash);
$result = $auth->getUser($uid);
$email = $result['email'];
$firstname = $result['firstName'];
$lastname = $result['Lastname'];
$username = $result['username'];
?>