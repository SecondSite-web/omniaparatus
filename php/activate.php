<?php
require_once __DIR__ . '/../functions.php';
defined( '__root_path__' ) || exit;

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('Account Activation');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/register.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'key' => 'trim|sanitize_string'
        );
        $rules = array(
            'key' => 'required|alpha_numeric|max_len,50|min_len,8',
            'nonce' => 'required'
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
        $key = $_POST['key'];
        $nonce_test = verify_nonce($_POST['nonce'], 'activate-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failedOops, please refresh and try again :-(');
        }

        $result = $auth->activate($key);

        if ($result['error'] == 1) {
            throw new \Exception($result['message']);
        }
        $responseArray = array('type' => 'success', 'message' => $result['message']);
        $log->addInfo('Successful', array('Message',  $result['message']));
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError('Failed', array('Message', $e->getMessage()));
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $encoded = json_encode($responseArray);
        header('Content-Type: application/json');
        echo $encoded;
    }
}