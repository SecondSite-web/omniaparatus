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
$log = new Logger('Status Change');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/account-status.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'user_status' => 'trim|sanitize_string',
            'id' => 'trim|sanitize_string'
        );
        $rules = array(
            'user_status' => 'required|alpha_numeric|max_len,50|min_len,4',
            'id' => 'required|alpha_numeric|max_len,30|min_len,1',
            'nonce' => 'required'
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
        $nonce_test = verify_nonce($_POST['nonce'], 'user_status'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $user_status = $_POST['user_status'];
        $id = $_POST['id'];
        if(($user_status == '0') or ($user_status == '1') ) {
            $result = $DB->query("UPDATE phpauth_users SET isactive = '{$user_status}' WHERE id = '{$id}'");
        } elseif($user_status == 'banned') {
            $result = $DB->query("UPDATE phpauth_users SET isactive = '0' WHERE id = '{$id}'");
            $result = $setup->change_userrole($user_status, $id);
        };


        $okMessage = 'User Status Changed!';
        $errorMessage = 'Update Failed';
        $responseArray = array('type' => 'success', 'message' => $okMessage);
        // $_POST = array();
        $log->addInfo($result['message'], array('UID',  $_POST['id'], $_POST['user_status']));
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError($e->getMessage(), array('UID',  $_POST['id'], $_POST['user_status']));
    }

    // if requested by AJAX request return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $encoded = json_encode($responseArray);
        header('Content-Type: application/json');
        echo $encoded;

    } // else just display the message
    else {
        echo $responseArray['message'];
    }
} else {
    header("Location: /");
}
