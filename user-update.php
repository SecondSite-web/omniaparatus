<?php
/*
 *  Twig User Profile Page
 *  Author: Gregory Schoeman
*/
require_once __DIR__ . '/functions.php';
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/php/lock.php';

// Page Template details
$templatename = "user_update.twig";
$pagetitle = "User Profile Page";
$description = "User profile details page";
$pagepic = ""; // The featured image of the page default is a 1200 x 630 .png
$class = "profile";

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
