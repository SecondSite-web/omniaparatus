<?php include("class_lib.php"); ?>
<?php
$stefan = new person(); // This is an object. Data is passed to the class through 'new'
$jimmy = new person(); // A new object has been created
$stefan->set_name("Stefan Mischook");
$jimmy->set_name("Nick Waddles");
echo "Stefan's full name: " . $stefan->get_name(); // best practice to get the object property through $object->function;
echo "Nick's full name: " . $jimmy->get_name();
?>
<?php
// This is the constructor method.
$stefan = new person("Stefan Mischook");
echo "Stefan's full name: ".$stefan->get_name();
?>
<?php
// Using our PHP objects in our PHP pages.
$stefan = new person("Stefan Mischook");
echo "Stefan's full name: " . $stefan->get_name();
// this is using the extended class
$james = new employee("Johnny Fingers");
echo "---> " . $james->get_name();
?>
