<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:20 PM
 */

// Data base connetion and Auth class
require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$firstname = filter_var($_POST["First_Name"], FILTER_SANITIZE_STRING);
$lastname = filter_var($_POST["Last_Name"], FILTER_SANITIZE_STRING);
$username = filter_var($_POST["regUser_Name"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["E_mail"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["regPassword"], FILTER_SANITIZE_STRING);
$passwordconform = filter_var($_POST["password_again"], FILTER_SANITIZE_STRING);
$tems = filter_var(isset($_POST["terms"]));
$key = $_POST['g-recaptcha-response'];
$params = array("firstName" => "{$firstname}", "Lastname" => "{$lastname}", "username" => "{$username}", "type" => '1');
$result = $auth->register($email, $password, $passwordconform, $params, $sendmail = true);
if ($result['error']) {
    // if registration not complete
    $output = json_encode(array("typee" => 1, "resultt" => $result['message']));
} else {
    $uid = $auth->getUID($email);
    $db->query("INSERT INTO recentlesson (user_id,lesson_id) VALUES (:uid, '0')", array("uid" => $uid));
    $output = json_encode(array("typee" => 0, "resultt" => $result['message']));
}
//$output = json_encode(array("typee" => 1, "resultt" => "$key--$firstname -- $lastname --  $username --  $email -- $password -- $passwordconform -- $tems "));
die($output);