<?php
/*
 *  Twig Admin Center Index Page
 *  Author: Gregory Schoeman
*/
require_once __DIR__ . '/functions.php';
defined( '__root_path__' ) || exit;
require_once __DIR__ . '/php/lock.php';

// Page Template details
$templatename = "sb_add.twig";
$pagetitle = "Make a reservation";
$description = "RAV online vehicle reservation system";
$pagepic = ""; // The featured image of the page default is a 1200 x 630 .png
$class = "sb_profile";
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
