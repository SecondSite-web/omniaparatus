<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
// Define PHP Class Namespaces

use PHPAuth\Config as PHPAuthConfig; // User Authentication
use PHPAuth\Auth as PHPAuth;
use Monolog\Logger; // Log events in ./logs
use Monolog\Handler\StreamHandler;
// $setup = new Setup($dbh);
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

$log = new Logger('User Login');
// test if logged in -> redirect to dashboard
if ($auth->isLogged()) {
    header("Location: /");
    exit;
}

// try to create the log object and open the file for writing.
$log->pushHandler(new StreamHandler(__root_path__ . '/logs/login.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Wixel Gump PHP Validate, Sanitize, Process, Filter, Whitelist for forms
        $filters = array(
            'email'      => 'trim|sanitize_email',
            'password'   => 'trim|sanitize_string'
        );
        $rules = array(
            'email'         => 'required|valid_email',
            'password'      => 'required|max_len,100|min_len,8',
            'nonce'         => 'required'
        );
        $validator = new GUMP();
        $whitelist = array_keys($rules); // Will block if there are any entries in $_POST that are not listed in $rules array
        $_POST = $validator->sanitize( $_POST, $whitelist );
        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);
        if($validated === FALSE)
        {
            $result['message'] = 'Rats in the belfry, please refresh and try again ;-)';
            throw new \Exception($validator->get_readable_errors(true));
        }

        // Nonce Test Elhardoum\nonce-php
        $nonce_test = verify_nonce($_POST['nonce'], 'login-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('Oops, please refresh and try again :-(');
        }
        // finally save $_POST entries into variables for sexiness
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Banned User Test
        $user = array();
        $uid = $auth->getUID($email);
        $user = $auth->getUser($uid);
        // print_r($user);
        if($user == 0) {
            throw new \Exception('No Account found with that email address');
        }
        if(array_key_exists("userrole", $user) && ($user['userrole'] == 'banned')) {
            $result['message'] = 'Please contact a site admin to reactivate your account';
            throw new \Exception('Please contact a site admin to reactivate your account');
        }
        $result = $auth->login($email, $password, $remember = true, $captcha_response = null); // Login Attempt

        if ($result['error'] == null) {
            setcookie('phpauth_session_cookie', $result["hash"], $result["expire"], '/'); // Cookie if successful
            $log->addInfo('User Login Success', array('Email Address',  $_POST['email']." ". $result["hash"])); // And make a note of it
        } else {
            throw new \Exception($result['message']); // Or throw an error
        }
        $responseArray = array('type' => 'success', 'message' => $result['message']); // And a success message
        // print_r($result);
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage()); // Error Message array for ajax
        $log->addError('User Login Failed', array('Email Address',  $_POST['email']." ". $e->getMessage())); // Log note of error
    }
    // if requested by AJAX request return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $encoded = json_encode($responseArray);
        header('Content-Type: application/json');
        echo $encoded;
    }
} else {
    header("Location: ./");
}