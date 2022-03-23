<?php
// Use classes to create functions in pairs to get and set data
// Constructors
// All objects can have a special built-in method called a ‘constructor’.Â Constructors allow you to initialise your object’s properties (translation:Â give your properties values,) when you instantiate (create) an object.
// Note: If you create a __construct() function (it is yourÂ choice,) PHP will automatically call the __construct() method/functionÂ when you create an object from your class.
// The ‘construct’ method starts with two underscores (__) and the word ‘construct’.

// ‘Public’ is the default modifier.
    class person {
        var $name; // properties
        // Modifiers ‘encapsulation’
        public $height;
        protected $social_insurance; // 0 inheritance hierarchy
        private $pinn_number; // only the same class can access the variable
        // constuctor method
        function __construct($persons_name) {
            $this->name = $persons_name;
        }
        // method Setter
        function set_name($new_name) {
            $this->name = $new_name;
        }
        // method Getter
        function get_name() {
            return $this->name;
        }
    }
    // 'extends' is the keyword that enables inheritance
    class employee extends person {
        function __construct($employee_name) {
            $this->set_name($employee_name);
        }
    }
