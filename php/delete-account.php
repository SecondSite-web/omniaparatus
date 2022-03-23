<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/lock.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);
$DB = new Db();
// create a log channel
$log = new Logger('User De-Activate');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/account-status.log', Logger::INFO));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'email'      => 'trim|sanitize_email',
            'password'   => 'trim|sanitize_string'
        );
        $rules = array(
            'email'       => 'required|valid_email',
            'password'     => 'required|max_len,100|min_len,8'
        );
        $validator = new GUMP();
        $whitelist = array_keys($rules);
        $_POST = $validator->sanitize( $_POST, $whitelist );
        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);
        // $_POST = $validator->run($_POST);
        if($validated === FALSE)
        {
            throw new \Exception($validator->get_readable_errors(true));
        }
        $nonce_test = verify_nonce($_POST['nonce'], 'delete-account-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $email = $_POST['email'];
        $uid = $auth->getUID($email);
        $password = $_POST['password'];

        // $result = $auth->deleteUser($uid, $password, $captcha_response = null);
        $result = $DB->query("UPDATE phpauth_users SET isactive = '0' WHERE id = '{$uid}'");
        if ($result['error'] == '1') {
            throw new \Exception($result['error']);
        }
        $responseArray = array('type' => 'success', 'message' => $result['message']);
        $log->addInfo($result['message'], array('Email',  $_POST['email']));
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError($e->getMessage(), array('Email',  $_POST['email']));
    }

    // if requested by AJAX request return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $encoded = json_encode($responseArray);
        header('Content-Type: application/json');
        echo $encoded;
    }
    else {
        echo $responseArray['message'];
    }
} else {
        header("Location: /");
    }