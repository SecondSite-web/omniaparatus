<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/16/2019
 * Time: 9:02 PM
 */

// when an extending class has a method with a change from the same function in the parent class
	class person
    {
        protected function set_name($new_name) {
            if ($new_name != "Jimmy Two Guns") {
                $this->name = strtoupper($new_name);
            }
        }
    }

	class employee extends person
    {
        protected function set_name($new_name) {
            if ($new_name == "Stefan Sucks") {
                $this->name = $new_name;
            }
        }
    }
?>