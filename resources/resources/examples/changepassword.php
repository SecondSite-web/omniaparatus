<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:00 PM
 */

<?php

require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$uid = $auth->getSessionUID($auth->getSessionHash());
$password = "ucsc@123!@#AB";
$password2 = "ucsc@123!@#AB";
$result = $auth->changePassword($uid, $currpass, $newpass, $repeatnewpass);
echo '<pre>';
var_dump($result);
echo '<br>';