<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 8/14/2019
 * Time: 10:07 PM
 */
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/../php/lock.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('User Login');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/login.log', Logger::INFO));

if ($auth->isLogged()) {

    //$result = $auth->logout($auth);
    $log->addInfo('User Logout', array('Email Address',  $auth->getCurrentUser()));
    $uid = $auth->getUID($email);
    $auth->logoutAll($uid);
    header("Location: /");
} else {
        header("Location: /");
    }