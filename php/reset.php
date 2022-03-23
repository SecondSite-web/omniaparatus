<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('Reset Password');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/password.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'key' => 'trim|sanitize_string',
            'password'    => 'trim|sanitize_string',
            'confirm_password' => 'trim|sanitize_string'
        );
        $rules = array(
            'key' => 'required|alpha_numeric|max_len,50|min_len,10',
            'password'  => 'required|max_len,100|min_len,8',
            'confirm_password'  => 'equalsfield,password',
            'nonce'     => 'required'
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
        $nonce_test = verify_nonce($_POST['nonce'], 'reset-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $key = $_POST['key'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['confirm_password'];
        $result = $auth->resetPass($key, $password, $repeatpassword);

        if ($result['error'] == '1') {
            throw new \Exception($result['error']);
        }
        $responseArray = array('type' => 'success', 'message' => $result['message']);
        $log->addInfo('Password reset Successful', array('Message',  $result['message']));
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError('Password reset Failed', array('Message', $e->getMessage()));
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
