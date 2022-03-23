<?php 

/** Debug Mode */
define( 'TWIG_DEBUG', true );

/** The name of the database */
define( 'DBName', 'twig-master' );

/** MySQL database username */
define( 'DBUser', 'root' );

/** MySQL database password */
define( 'DBPassword', '' );

/** MySQL hostname */
define( 'DBHost', 'localhost' );

/** MySQL port */
define('DBPort', 3306);

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

define('DBDriver', 'mysql:host='.DBHost.';dbname='.DBName);
/** The Database Collate type. Don't change this if in doubt. */
// define( 'DB_COLLATE', '' );

if ( ! defined('__root_path__')) {
    define('__root_path__', dirname(__FILE__));
}
