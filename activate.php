<?php
/*
 *  Template Controller page
 *  Author: Gregory Schoeman
*/
require_once __DIR__ . '/functions.php';
defined( '__root_path__' ) || exit;
// Page Template details
$templatename = "user_activate.twig";
$pagetitle = "User Activation";
$description = "Activate your user account here";
$class = "activate";
$pageurl = $setup->current_url();
$pagepic = ""; // The featured image of the page default is a 1200 x 630 .png

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