<?php
/*
 *  Index Page Template Controller
 *  Author: Gregory Schoeman
*/

require_once __DIR__.'/functions.php';

defined( '__root_path__' ) || exit;
require_once __DIR__ . '/php/lock.php';
$pagetitle = "OMNIA PARATAS Admin"; // https://www.wordstream.com/blog/ws/2009/08/05/seo-title-tag-formulas
$description = "Website Data Portal. ";  // https://www.wordstream.com/meta-description,
$pagepic = "img/banner.png"; // The featured image of the page default is a 1200 x 630 .png
$class = "home";

$templatename = "sb_profile.twig";
$pageurl = $setup->current_url();

// Feeds variables to the html template
$values = array(
	'page' => array(
	    'url'           => $pageurl,
		'title' 		=> $pagetitle,
		'description' 	=> $description,
		'class' 		=> $class,
		'pic' 			=> $pagepic
 	)
);
echo $twig->render($templatename, $values);