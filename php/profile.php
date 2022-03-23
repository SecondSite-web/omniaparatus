<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/lock.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('Profile Update');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/profile.log', Logger::INFO));

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $rules = array(
        'firstname'   => 'required|alpha_numeric|max_len,100|min_len,3',
        'lastname'    => 'required|alpha_numeric|max_len,100|min_len,3',
        'email'       => 'required|valid_email',
        'phone'       => 'required|alpha_numeric|max_len,20|min_len,3',
        'userrole'    => "required|contains, 'root' 'admin' 'user' 'guest",
        'nonce'       => 'required',
        'uid'         => 'required',
        'business'=> 'required',
        'opening_date' => 'required',
        'address_street' => 'required',
        'city' => 'required',
        'country' => 'required',
        'industry' => 'required',
        'description' => 'required'


        );

        $filters = array(
            'firstname'   => 'trim|sanitize_string',
            'lastname'    => 'trim|sanitize_string',
            'email'       => 'trim|sanitize_email|lower_case',
            'phone'       => 'trim|sanitize_string|lower_case',
            'userrole'    => 'trim|sanitize_string|lower_case'
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
        $nonce_test = verify_nonce($_POST['nonce'], 'profile-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $params = array('firstname' => $firstname, 'lastname' => $lastname, 'phone' => $phone, 'dob' => 'a', 'business' => $_POST['business'], 'opening_date'=> $_POST['opening_date'], 'address_street'=> $_POST['address_street'],'city'=> $_POST['city'], 'country'=> $_POST['country'], 'industry'=> $_POST['industry'], 'description'=> $_POST['description']);

        // $uid= $auth->getCurrentUID();
        $uid = $_POST['uid'];
        $result = $auth->updateUser($uid, $params);

        if ($result['error'] == '1') {
            throw new \Exception($result['error']);
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