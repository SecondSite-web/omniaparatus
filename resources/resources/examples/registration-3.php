<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 2:33 PM
 */

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