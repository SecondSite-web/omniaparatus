<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 2:59 PM
 */

require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$email = "mbcsdskchamathssilva@gmail.com";
$password = "cucsc@123!@#AB";
$repeatpassword = "cucsc@123!@#AB";
$key = "03AHJ_VusDysdsdsldk6nNgaBFahjAIlwHyrxod-1WIyiqWjmUmxVTkNCGxkA8y21CZyDiu_03sS0qwNRgLU-8sjNIAYcANipvcjBuWFgOee_FwU7rOL36eQLxJovDXXyUGgvVpLI7aPthpN_GuF7d7-qRDMwqzfUbQnDhzx0Dmdxl4jjDEen7NbtJ4Rs5SiFxme_ujF05jGy2e1x5GCT1M5AnPzCY7P7-_BEsP_RQw-Ja1J07pRVADq3e7KwMZZ027nmc-7PB8ehgWDBcG6rENnBj_KjjGKftZ-z7B1zZh1grI_gYMidPXnpP9reEcnLhu4fveoVBwqSZ1RyR0qhjV3RZZ2OxBBUpB-rEeVDxDwPHT4hhmZ-ceo4hWfacaRtoMe7x3IJlZr5EoTZv1g9vSTs52q0fPUuuc2QEHLz-ZUkMWzgSwxyYrV9xhE5qplrlvKs_4mszM3b70ZiWFR2TIS4";
$params = array("A" => "apple", "B" => "orange", "C" => "how");
echo '<pre>';
$result = $auth->register($email, $password, $repeatpassword, $params);
var_dump($result);
echo '<br>';