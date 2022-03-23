<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/lock.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('User Registration');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/password.log', Logger::INFO));

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'currpass'      => 'trim|sanitize_string',
            'newpass'       => 'trim|sanitize_string',
            'repeatnewpass' => 'trim|sanitize_string'
        );
        $rules = array(
            'currpass'      => 'required|max_len,100|min_len,8',
            'newpass'       => 'required|max_len,100|min_len,8',
            'repeatnewpass' => 'equalsfield,newpass',
            'nonce'         => 'required'
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
        $nonce_test = verify_nonce($_POST['nonce'], 'password-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $currpass = $_POST['currpass'];
        $newpass = $_POST['newpass'];
        $repeatnewpass = $_POST['repeatnewpass'];

        $uid= $auth->getCurrentUID();
        $result = $auth->changePassword($uid, $currpass, $newpass, $repeatnewpass);
        if ($result['error'] == '1') {
            throw new \Exception($result['error']);
        }
        $responseArray = array('type' => 'success', 'message' => $result['message']);
        $log->addInfo($result['message'], array('Email Address',  $auth->getCurrentUser()));
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError($e->getMessage(), array('Email Address',  $auth->getCurrentUser()));
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