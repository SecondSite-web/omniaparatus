<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 2:52 PM
 */

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die;
}
// Data base connetion and Auth class
require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
if (isset($_FILES["FileInput1"]) && $_FILES["FileInput1"]["error"] == UPLOAD_ERR_OK) {
    //check if this is an ajax request
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        die;
    }
    //allowed file type Server side check
    switch (strtolower($_FILES['FileInput1']['type'])) {
        //allowed file types
        case 'text/plain':
            break;
        default:
            die('Unsupported File Please upload txt file!');
        //output error
    }
} else {
    die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}
set_error_handler('exceptions_error_handler');
function exceptions_error_handler($severity, $message, $filename, $lineno)
{
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
}
$UploadDirectory = '../../../data/uploads/';
$File_Name = strtolower($_FILES['FileInput1']['name']);
if (!file_exists($UploadDirectory)) {
    mkdir($UploadDirectory, 0755, true);
}
if (move_uploaded_file($_FILES['FileInput1']['tmp_name'], $UploadDirectory . $File_Name)) {
    //  die('Success! File Uploaded.');
} else {
    die('error uploading File!');
}
try {
    $current_line = 0;
    $readFile = fopen("{$UploadDirectory}/{$File_Name}", "r") or die("Unable to open file!");
    while (!feof($readFile)) {
        $current_line += 1;
        $line = fgets($readFile);
        if (trim($line) != '') {
            $line = explode(',', $line);
            $firstname = $line[0];
            $lastname = $line[1];
            $email = $line[2];
            $type = $line[3];
            $password = "ucsc@123123";
            $username = "You can chnage your deatiles current password {$password}";
            //echo $firtname." ".$secondname." ".$email." ".$type."<br>";
            $params = array("firstName" => "{$firstname}", "Lastname" => "{$lastname}", "username" => "{$username}", "type" => "{$type}");
            $result = $auth->register($email, $password, $password, $params);
            if ($result['error']) {
                // if registration not complete
                $output = json_encode(array("typee" => 1, "resultt" => $result['message']));
                echo $output . "<br>";
            } else {
                $uid = $auth->getUID($email);
                $db->query("INSERT INTO recentlesson (user_id,lesson_id) VALUES (:uid, '0')", array("uid" => $uid));
                $output = json_encode(array("typee" => 0, "resultt" => $result['message']));
            }
        }
    }
} catch (Exception $e) {
    echo "Some thing wrong with txt file,Pleace check near line {$current_line}";
}
echo "Registration completed..";