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

if (($_SERVER["REQUEST_METHOD"] == "POST") && (count($_FILES)>0)) {
    try {
        $rules = array(
            'profile-upload'   => 'required',
            'nonce'       => 'required',
            'uid' => 'required'
        );

        $validator = new GUMP();
        $whitelist = array_keys($rules);
        $_POST = $validator->sanitize( $_POST, $whitelist );
        $validated = $validator->validate($_POST, $rules);
        // $_POST = $validator->run($_POST);
        if($validated === FALSE)
        {
            throw new \Exception($validator->get_readable_errors(true));
        }

        $storage = new \Upload\Storage\FileSystem(__root_path__.'/uploads/profiles');
        $file = new \Upload\File('profile-upload', $storage);

        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName($new_filename);

        // Validate file upload
        // MimeType List => http://www.webmaster-toolkit.com/mime-types.shtml
        $file->addValidations(array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype(array('image/png', 'image/jpeg', 'image/gif')),
            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size('5M')
        ));

        // Access data about the file that has been uploaded
        $data = array(
            'name' => $file->getNameWithExtension(),
            'extension' => $file->getExtension(),
            'mime' => $file->getMimetype(),
            'size' => $file->getSize(),
            'md5' => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        // ////////////////////
        // $uid= $auth->getCurrentUID();
        $uid = $_POST['uid'];
        $file->upload();
        $setup->add_profilepic($data['name'], $uid);

        $responseArray = array('type' => 'success', 'message' => 'Upload Successful');
        $log->addInfo($responseArray['message']);
    } catch (\Exception $e) {
        $errors = $file->getErrors();
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
        $log->addError($responseArray['message']);

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