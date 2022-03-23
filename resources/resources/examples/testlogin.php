<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 2:43 PM
 */



session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    //check if its an ajax request, exit if not
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        //exit script outputting json data
        $output = json_encode(array("typee" => 1, "resultt" => 'Sorry Request must be Ajax POST'));
        die($output);
    }
    // Data base connetion and Auth class
    require "../../models/DB/Db.class.php";
    $db = new Db();
    $dbh = $db->getPurePodo();
    include "../../models/PHPAuth/Config.php";
    include "../../models/PHPAuth/Auth.php";
    $config = new PHPAuth\Config($dbh);
    $auth = new PHPAuth\Auth($dbh, $config);
    //Sanitize input data using PHP filter_var().
    $email = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $remember = isset($_POST["remember"]);
    $result = $auth->login($email, $password, $remember);
    // 1 - error
    // 0 - ok
    if ($result['error']) {
        $output = json_encode(array("typee" => 1, "resultt" => $result['message']));
    } else {
        setcookie('authIDD', $result["hash"], $result["expire"], '/');
        $uid = $auth->getSessionUID($result["hash"]);
        $result = $auth->getUser($uid);
        $type = $result['type'];
        //////////////////////////////////////
        //Temporary use only
        //$_SESSION["user"] = $uid;
        /////////////////////////////////////
        //  99 - admin
        //  1 - general user
        //  2 - ucsc user
        //  3 - bit user
        if ($type == 99) {
            $output = json_encode(array("typee" => 0, "resultt" => 'application/views/admin/adminHome.php'));
        } elseif ($type == 1) {
            $output = json_encode(array("typee" => 0, "resultt" => 'application/views/user/userhomeOld.php'));
        } elseif ($type == 2) {
            $output = json_encode(array("typee" => 0, "resultt" => 'application/views/user/ucsc.php'));
        } elseif ($type == 3) {
            $output = json_encode(array("typee" => 0, "resultt" => 'application/views/user/bit.php'));
        } else {
            // somthing wrong #2
            $output = json_encode(array("typee" => 1, "resultt" => 'Something wrong #2'));
        }
    }
    die($output);
} else {
    // somthing wrong #1
    $output = json_encode(array("typee" => 1, "resultt" => 'Something wrong Try again later #1'));
    die($output);
}