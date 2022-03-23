<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('User Registration');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/register.log', Logger::INFO));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'firstname'   => 'trim|sanitize_string',
            'lastname'    => 'trim|sanitize_string',
            'email'       => 'trim|sanitize_email|lower_case',
            'phone'       => 'trim|sanitize_string|lower_case',
            'password'    => 'trim|sanitize_string',
            'confirm_password' => 'trim|sanitize_string'
        );
        $rules = array(
            'firstname'   => 'required|alpha_numeric|max_len,100|min_len,3',
            'lastname'    => 'required|alpha_numeric|max_len,100|min_len,3',
            'email'       => 'required|alpha_numeric|max_len,100|min_len,3',
            'phone'       => 'required|valid_email',
            'password'    => 'required|max_len,100|min_len,8',
            'confirm_password' => 'equalsfield,password',
            'nonce'         => 'required'
        );

        $validator = new GUMP();
        $whitelist = array_keys($rules);
        $_POST = $validator->sanitize( $_POST, $whitelist );
        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);
        if($validated === FALSE)
        {
            throw new \Exception($validator->get_readable_errors(true));
        }
        $nonce_test = verify_nonce($_POST['nonce'], 'registration-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['confirm_password'];
        $userrole = strtolower('guest');
        $params = array('firstname' => $firstname, 'lastname' => $lastname, 'userrole' => $userrole, 'phone' => $phone);

        $result = $auth->register($email, $password, $repeatpassword, $params, $captcha_response = null, $use_email_activation = true);
        if ($result['error'] == '1') {
            throw new \Exception($result['message']);
        }
        $responseArray = array('type' => 'success', 'message' => $result['message']);
        $log->addInfo($result['message'], array('Email',  $_POST['email']." | User: ".$_POST['firstname']." ".$_POST['lastname']));

    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError($e->getMessage(), array('Email',  $_POST['email']." | User: ".$_POST['firstname']." ".$_POST['lastname']));
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