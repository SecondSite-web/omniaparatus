<?php

/*
 *  Template Controller page
 *  Author: Gregory Schoeman
*/
require_once __DIR__ . '/functions.php';
defined('__root_path__') || exit;
require_once __DIR__ . '/php/lock.php';
if ($user['userrole'] == 'guest') {
    header("Location: /login.php");
    exit;
}
$DB = new DB();
// Page Template details
$templatename = "sb_cf_table.twig";
$pagetitle = "Contact form submissions";
$description = "Tabled view of all contact form submissions";
$pagepic = ""; // The featured image of the page default is a 1200 x 630 .png
$class = "cf-tables";
$pageurl = $setup->current_url();
$thead = $DB->table_headings('contact_form');
$tbody = $DB->fetch_table('contact_form');

$values = array(
    'page' => array(
        'url' => $pageurl,
        'title' => $pagetitle,
        'description' => $description,
        'class' => $class,
        'pic' => $pagepic
    ),
    'tbody' => $tbody,
    'thead' => $thead
);
echo $twig->render($templatename, $values);
