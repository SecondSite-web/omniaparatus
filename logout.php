<?php

require_once __DIR__.'/functions.php';
defined( '__root_path__' ) || exit;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('User Login');
$log->pushHandler(new StreamHandler(__root_path__ . '/logs/login.log', Logger::INFO));

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

    try {

        $result =  $auth->logout($_COOKIE['phpauth_session_cookie']);

        header("Location: ./");

        if (!$result['error'] == 'true') {

            $responseArray = array('type' => 'success', 'message' => $result['message']);
            $log->addInfo('User Logout', array('User Logout Successful', $_COOKIE['phpauth_session_cookie']));
        } else {
            throw new \Exception($result['error']);
        }
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $result['message']);
        $log->addError('User Logout Failed', array('User Logout Successful'));
    }