<?php
require_once __DIR__ . "/../functions.php";
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/lock.php';
$DB = new DB();
use rental\Rental;
$rental = new Rental($dbh);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// if (!empty($_POST['setting'])) {
    try {
        $filters = array(
            'setting' => 'trim|sanitize_string',
            'value' => 'trim|sanitize_string',
            'description' => 'trim|sanitize_string'

        );
        $rules = array(
            'setting' => 'required|alpha_numeric|max_len,50|min_len,5',
            'value' => 'required|alpha_numeric|max_len,50|min_len,5',
            'description' => 'required|alpha_numeric|max_len,50|min_len,5',
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
        $nonce_test = verify_nonce($_POST['nonce'], 'settings-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $setting = $_POST['setting'];
        $value = $_POST['value'];
        $description = $_POST['description'];
        $rental->new_setting($_POST['setting'], $_POST['value'], $_POST['description']);

        $okMessage = 'Setting Updated!';

        // If something goes wrong, we will display this message.
        $errorMessage = 'Update Failed';
        $responseArray = array('type' => 'success', 'message' => $okMessage);
        // $_POST = array();

    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
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
