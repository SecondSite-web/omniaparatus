<?php
require_once __DIR__ . "/../functions.php";
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/lock.php';

$DB = new Db();
use rental\Rental;
$rental = new Rental($dbh);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $filters = array(
            'rental_id' => 'trim|sanitize_string',
            'status' => 'trim|sanitize_string'
        );
        $rules = array(
            'rental_id' => 'required|alpha_numeric|max_len,20',
            'status' => 'required|alpha_numeric|max_len,20',
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
        $nonce_test = verify_nonce($_POST['nonce'], 'status-form'); // Initiate Nonce Utility
        if($nonce_test != 1) {
            $result['message'] = 'Oops, please refresh and try again :-(';
            throw new \Exception('The nonce test has failed');
        }
        $rental_id = $_POST['rental_id'];
        $status = strtolower($_POST['status']);
        $rental->update_status($status, $rental_id);

        $okMessage = 'Setting Updated!';
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
