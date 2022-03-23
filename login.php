<?php
/*
 *  Login Controller Page Controller page
 *  Author: Gregory Schoeman
 *
*/
require_once __DIR__ . '/functions.php';
defined( '__root_path__' ) || exit;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

if ($auth->isLogged()) {
    header("Location: /");
    exit;
}
// Page Template details
$templatename = "user_login.twig";
$pagetitle = "User Login";
$description = "User Login Page";
$class = "login";
$pagepic = "";
$pageurl = $setup->current_url();

$values = array(
	'page' => array(
		'url' 			=> $pageurl,
		'title' 		=> $pagetitle,
		'description' 	=> $description,
		'class' 		=> $class,
		'pic' 			=> $pagepic
 	)
);
echo $twig->render($templatename, $values);