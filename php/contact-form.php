<?php

require_once __DIR__ . "/functions.php";
defined( '__root_path__' ) || exit;
$cf = new cf($dbh); // Call the contact form class
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('Contact Form');
$log->pushHandler(new StreamHandler(__root_path__.'/logs/contact-form.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_POST['nonce'])) {
            throw new \Exception('missing nonce');
        }
        $nonce_test = $setup->verify_nonce($_POST['nonce'], 'contact-form'); // Initiate Nonce Utility
        if($nonce_test = false) {
            throw new \Exception('Aw, something went wrong :-( please refresh the page to submit again');
        }
        // the honeypot test first
        if (!empty($_POST['phone'])) {
            throw new \Exception('I could not send the email.');
        }
        // the empty form test
        if (empty($_POST['firstname']) or empty($_POST['lastname'])) {
            throw new \Exception('The form has not been filled in completely');
        }
        // Wixel Gump clean the $_POST array form input string santitisation to prevent code injection
        $filters = array(
            'firstname' => 'trim|sanitize_string',
            'lastname' => 'trim|sanitize_string',
            'phone' => 'trim|sanitize_string',
            'telephone' => 'trim|sanitize_string',
            'email' => 'trim|sanitize_email',
            'message' => 'trim|sanitize_string',
        );
        // Gump rules for the input fields
        $rules = array(
            'firstname' => 'required|alpha_numeric|max_len,25|min_len,3',
            'lastname' => 'required|alpha_numeric|max_len,25|min_len,3',
            'phone' => 'max_len,1',
            'telephone' => 'required|alpha_numeric|max_len,25|min_len,3',
            'email' => 'required|valid_email',
            'message' => 'required',
            'status' => 'required',
            'nonce' => 'required'
        );
        $validator = new GUMP(); // initialize gump
        $whitelist = array_keys($rules); // whitelisted $_POST array fields taken from fields in $rules array
        $_POST = $validator->sanitize($_POST, $whitelist); // sanitise $_POST and whitelist
        $_POST = $validator->filter($_POST, $filters); // filter inputs
        $validated = $validator->validate($_POST, $rules); // check if inputs conform to rules

        if ($validated === FALSE) {
            throw new \Exception($validator->get_readable_errors(true));
        }
        // messages for the response
        $okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
        $errorMessage = 'There was an error while submitting the form. Please try again later';

        $mailer_result = $cf->cf_mailer($_POST); // Mail the response using cf-class
        if($mailer_result == false) {
            throw new Exception('Email Sending Failed');
        }

        $responseArray = array('type' => 'success', 'message' => $okMessage);
        $log->addInfo('Successful', $_POST);

        $cf->cf_db($dbh, $_POST); // Save submission to the database
        $_POST = array();
    } catch (\Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError('Failed', array($_POST, $e->getMessage()));
        $_POST = array();
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