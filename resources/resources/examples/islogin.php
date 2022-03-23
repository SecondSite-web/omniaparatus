<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:19 PM
 */

<?php

require "../../config/config.php";
require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
if (!$auth->isLogged()) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";
    exit;
} else {
    echo "ok";
}
// only work with vies/xx can't nested more than that