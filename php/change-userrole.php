<?php
require_once __DIR__ . "/../functions.php";
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/lock.php';
if($user['userrole'] == 'guest') {
header("Location: /login.php");
exit;
}

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('Userrole Change');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/account-status.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'userrole' => 'trim|sanitize_string',
            'user_id' => 'trim|sanitize_string'
        );
        $rules = array(
            'userrole' => 'required|alpha_numeric|max_len,20',
            'user_id' => 'required|alpha_numeric|max_len,20',
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
        $nonce_test = verify_nonce($_POST['nonce'], 'user_role'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $userrole = strtolower($_POST['userrole']);
        $user_id = $_POST['user_id'];

        $result = $setup->change_userrole($userrole, $user_id);

        $okMessage = 'Setting Updated!';
        $errorMessage = 'Update Failed';
        $responseArray = array('type' => 'success', 'message' => $okMessage);
        $log->addInfo($result['message'], array($_POST['user_id'], $_POST['userrole']));
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError($e->getMessage(), array($_POST['user_id'], $_POST['userrole']));
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
