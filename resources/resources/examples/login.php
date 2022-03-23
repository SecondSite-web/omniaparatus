<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 2:38 PM
 */

<?php

require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$email = "alex@gmail.com";
$password = "Dope1992104silva";
$repeatpassword = "Dope1992104silva";
$remember = "0";
echo '<pre>';
$result = $auth->login($email, $password, $remember);
//if login deatile correct create session
if (!$result['error']) {
    setcookie('authIDD', $result["hash"], $result["expire"], '/');
}
var_dump($result);
echo '<br>';