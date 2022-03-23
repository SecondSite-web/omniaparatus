<?php
/**
 * Webroot Main PHP Functions
 * Author: Gregory Schoeman
 */

if ( ! defined('__root_path__')) {
    require_once __DIR__ . '/config.php'; // Database settings
}

require_once __root_path__ . '/vendor/autoload.php'; // composer autoload for ./vendor files
require_once __root_path__ . '/php/connect-pdo.php'; // create the $dbh object
require_once __root_path__ . '/php/classes.php'; // PHP classes
require_once __root_path__ . '/php/Nonce.php'; // Nonce functions
require_once __root_path__ . '/php/twig-functions.php'; // Functions lib not used as methods

$setup = new setup($dbh); // Creates the $setup object
$twig_globals = $setup->setup_globals(); // load global settings data from db and pass to twig 'addGlobal'
$user = $setup->get_user($dbh); // User info from $auth class to `addGlobal` (render in templates {{ user.etc }})
$loggedIn = $setup->loggedIn($dbh); // checks if a user is logged in
// Template directories
$templateDir1 = __root_path__ ."/templates"; // Front Face html
$templateDir2 = __root_path__ ."/templates/dashboard"; // Backend html
$templateDir3 = __root_path__ ."/templates/auth"; // Authentication pages html

$loader = new \Twig\Loader\FilesystemLoader([$templateDir1, $templateDir2, $templateDir3]);
$twig = new \Twig\Environment($loader, array(
    'debug' => true,
    # 'cache' => 'cache',
));

$twig->addFunction($nonce_function);
$twig->addGlobal('user', $user);
$twig->addGlobal('loggedIn', $loggedIn);
$twig->addGlobal('site', $twig_globals);
$twig->addExtension(new \Twig\Extension\DebugExtension());