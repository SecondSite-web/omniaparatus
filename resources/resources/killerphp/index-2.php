<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/16/2019
 * Time: 9:13 PM
 */

    class person
    {
        // explicitly adding class properties are optional - but
        // is good practice
        var $name;
        function __construct($persons_name) {
            $this->name = $persons_name;
        }

        public function get_name() {
            return $this->name;
        }

        // protected methods and properties restrict access to
        // those elements.
        protected function set_name($new_name) {
            if ($this->name !=  "Jimmy Two Guns") {
                $this->name = strtoupper($new_name);
            }
        }
    }

	// 'extends' is the keyword that enables inheritance
	class employee extends person
    {   // override method
        protected function set_name($new_name) {
            if ($new_name ==  "Stefan Sucks") {
                $this->name = $new_name;
            }
            else if ($new_name ==  "Johnny Fingers") {
                person::set_name($new_name); // call to parent method
                parent::set_name($new_name); // same thing using parent shortcut
            }
        }

        function __construct($employee_name)
        {
            $this->set_name($employee_name);
        }
    }
