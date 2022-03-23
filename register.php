<?php
/*
 *  Template Controller page
 *  Author: Gregory Schoeman
*/
require_once __DIR__ . '/functions.php';
defined( '__root_path__' ) || exit;
if ($setup->allowRegister === '0') {
    header("Location: /login.php");
}
// Page Template details
$templatename = "user_register.twig";
$pagetitle = "User Registration";
$description = "User Registration Page";
$class = "register";
$pageurl = $setup->current_url();
$pagepic = "";

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