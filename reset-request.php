<?php
/*
 *  Template Controller page
 *  Author: Gregory Schoeman
*/
require_once __DIR__ . '/functions.php';
defined( '__root_path__' ) || exit;
// Page Template details
$templatename = "user_reset_request.twig";
$pagetitle = "Password Reset Request";
$description = "Request a password reset";
$class = "reset-request";
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