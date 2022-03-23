<?php
 /*
  * Setup class to load settings from db
  */

 use PHPAuth\Auth as PHPAuth;
 use PHPAuth\Config as PHPAuthConfig;

 class Setup
{
    private $dbh;
    private $auth;
    private $setup;
    private $setup_table = 'twig_settings';
    private $DB;

     /**
      * Setup constructor.
      * @param PDO $dbh
      */
     public function __construct(\PDO $dbh)
    {
        $this->setup = array();
        $this->dbh = $dbh;
        // determine setup table
        $this->setup_table = 'twig_settings';

        // $this->first_setup($dbh); // remove comment and refresh to rewrite settings and tables.
        // This function runs the first setup routine
        if (!$this->dbh->query("SHOW TABLES LIKE '{$this->setup_table}'")->fetchAll()) {
           $this->first_setup($dbh); // Creates twig_settings table
        };

        // load setup
        $this->setup = $this->dbh->query("SELECT `setting`, `value` FROM {$this->setup_table}")->fetchAll(\PDO::FETCH_KEY_PAIR);
        $dbh = null;
    }

    /**
     * Setup::__get()
     *
     * @param mixed $setting
     * @return string
     */
    public function __get($setting)
    {
        return array_key_exists($setting, $this->setup) ? $this->setup[$setting] : NULL;
    }


    /**
     * Setup::__set()
     *
     * @param mixed $setting
     * @param mixed $value
     * @return bool
     */
    public function __set($setting, $value)
    {
        $query_prepared = $this->dbh->prepare("UPDATE {$this->setup_table} SET value = :value WHERE setting = :setting");

        if ($query_prepared->execute(['value' => $value, 'setting' => $setting])) {
            $this->setup[$setting] = $value;
            return true;
        }
        return false;
    }

     /**
      * @return array
      */
     public function setup_globals() {
        $siteurl = $this->siteurl.'/';
        $year = date("Y");
        $allowRegister = $this->allowRegister;
        $sitename = $this->sitename;
        $site_admin_dir = $this->site_admin_dir;
        $return = array(
            'url' => $siteurl,
            'year' => $year,
            'allowRegister' => $allowRegister,
            'name' => $sitename,
            'admin' => $siteurl.$site_admin_dir
        );
        return $return;
    }

     /**
      * @param $dbh
      * @return array
      */
     public function get_user($dbh) {
         $config = new PHPAuthConfig($dbh);
         $auth = new PHPAuth($dbh, $config);
        if ($auth->isLogged()) {
            $uid= $auth->getCurrentUID();
            $result = $auth->getUser($uid);
            return $result;
        } else {
            $result = array('user'=>0);
            return $result;
        }
    }

    public function add_profilepic($new_filename, $uid) {
        $DB = new DB();
        $DB->query("UPDATE phpauth_users SET profilepic = ? WHERE id = ?", array("{$new_filename}","{$uid}"));
    }

     /**
      * @param $DB
      * @param $userrole
      * @param $user_id
      * @return bool
      */
     public function change_userrole($userrole, $user_id) {
         $DB = new DB();
         $DB->query("UPDATE phpauth_users SET userrole =? where id =?", array($userrole, $user_id));
         $DB = null;
         return true;
     }

     /**
      * @param $dbh
      * @return bool
      */
     public function loggedIn($dbh) {
        $config = new PHPAuthConfig($dbh);
        $auth = new PHPAuth($dbh, $config);
         return $auth->isLogged();
    }

     /**
      * @return string
      */
     public function current_url() {
         ob_start();
         if(!isset($_SERVER['HTTP_HOST'])) {
             $_SERVER = array('HTTPS' => 'off', 'HTTP_HOST' => '127.0.0.1', 'REQUEST_URI' => '/');
         }
         $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
         ob_end_flush();
         return $link;
     }

     /**
      * @param $email
      * @return array|int|null
      */
     public function get_userrole($email)
     {
         $DB = new DB();
         $userrole = $DB->query("SELECT userrole FROM phpauth_users WHERE email =?", array($email));
         return $userrole;
     }

     /**
      * @param $setting
      * @param $value
      */
     public function set_setting($setting, $value) {
         $DB = new DB();
         $DB->query("REPLACE INTO twig_settings (setting, value) VALUES(?,?)", array($setting,$value));
         $DB = null;
     }
     /**
      * @param $setting
      * @param $value
      * @param $description
      */
     public function phpauth_setting($setting, $value, $description)
     {
         $DB = new DB();
         $DB->query("REPLACE INTO phpauth_config (setting, value, description) VALUES(?,?,?)", array($setting, $value, $description));
     }

     /**
      * Installs PHPAuth, PHPMailer and Twig custom DB entries on first run only
      * @param $dbh
      */
     private function first_setup($dbh) {
         // Call custom PHPAuth class for table setup
         $DB = new DB();
         $DB->query("CREATE TABLE IF NOT EXISTS `twig_settings` (
          `setting` varchar(100) NOT NULL,
          `value` varchar(100) DEFAULT NULL,
          UNIQUE KEY `setting` (`setting`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


         // Definitions to write to $DB
         $debug = '0'; // for smtp mailer, excluding PHPAuth
         $email = 'admin@omniaparatus.org'; // SMTP account email
         $emailname = 'OMNIA ARATUS Mailer'; // From Name
         $pass = 'vWk0dm1AqDJbVAjcjiJm';
         $smtphost = 'rs13.cphost.co.za';
         $smtpauth = 'true';
         $smtpsecure = 'ssl'; // PHPMailer::ENCRYPTION_STARTTLS
         $smtpport =  '465';
         $subjectline = 'Website Form Submission';
         $mailcc = '';
         $mailbcc = '';
         $siteurl = 'http://127.0.0.1'; // without trailing slash. this is added in functions.php
         $sitename = 'OMNIA PARATUS Admin';
         $allowRegister = '1';
         $site_admin_dir =  '/';
         // Set initial twig settings
         $this->set_setting('debug', $debug);
         $this->set_setting('email', $email);
         $this->set_setting('emailname', $emailname);
         $this->set_setting('pass', $pass);
         $this->set_setting('smtphost', $smtphost);
         $this->set_setting('smtpauth', $smtpauth);
         $this->set_setting('smtpsecure', $smtpsecure);
         $this->set_setting('smtpport', $smtpport);
         $this->set_setting('subjectline', $subjectline);
         $this->set_setting('mailcc', $mailcc);
         $this->set_setting('mailbcc', $mailbcc);
         $this->set_setting('siteurl', $siteurl);
         $this->set_setting('sitename', $sitename);
         $this->set_setting('allowRegister', $allowRegister);
         $this->set_setting('site_admin_dir', $site_admin_dir);
         $this->phpauth_tables(); // creates PHPAuth tables
         $this->phpauth_setting('attack_mitigation_time', '+30 minutes', "Default is +30 minutes. Must respect PHP strtotime format.");
         $this->phpauth_setting('attempts_before_ban', '30', 'Maximum amount of attempts to be made within attack_mitigation_time before temporally blocking the IP addressDefault is 30');
         $this->phpauth_setting('attempts_before_verify', '5', 'Maximum amount of attempts to be made within attack_mitigation_time before requiring captcha. Default is 5');
         $this->phpauth_setting('bcrypt_cost', '10', 'The algorithmic cost of the bcrypt hashing function, can be changed based on hardware capabilities');
         $this->phpauth_setting('cookie_domain', NULL, 'The domain of the session cookie, do not change unless necessary');
         $this->phpauth_setting('cookie_forget', '+30 minutes', 'The time a user will remain logged in when not ticking "remember me" on login. Must respect PHPs strtotime format.');
         $this->phpauth_setting('cookie_http', '0', 'the HTTP only protocol setting of the session cookie, do not change unless necessary');
         $this->phpauth_setting('cookie_name', 'phpauth_session_cookie', ' the name of the cookie that contains session information, do not change unless necessary');
         $this->phpauth_setting('cookie_path', '/', ' the path of the session cookie, do not change unless necessary');
         $this->phpauth_setting('cookie_remember', '+1 month', ' the time that a user will remain logged in for when ticking "remember me" on login. Must respect PHP strtotime format.');
         $this->phpauth_setting('cookie_secure', '0', 'the HTTPS only setting of the session cookie, dont change unless necessary');
         $this->phpauth_setting('cookie_renew', '+5 minutes', 'Maximum time difference between session expiration and last page load before allowing the session to be renewed. Must respect PHPs strtotime format.');
         $this->phpauth_setting('allow_concurrent_sessions', FALSE, 'Allow a user to have multiple active sessions (boolean). If false (default), logging in will end any existing sessions.');
         $this->phpauth_setting('emailmessage_suppress_activation', '0', '');
         $this->phpauth_setting('emailmessage_suppress_reset', '0', '');
         $this->phpauth_setting('mail_charset', 'UTF-8', '');
         $this->phpauth_setting('password_min_score', '1', 'the minimum score given by zxcvbn that is allowed. Default is 3');
         $this->phpauth_setting('site_activation_page', 'dashboard/activate.php', 'the activation page name appended to the site_url in the activation email');
         $this->phpauth_setting('site_password_reset_page', 'dashboard/reset.php', ' the password reset page name appended to the site_url in the password reset email');
         $this->phpauth_setting('site_email', $email, 'The email address from which to send activation and password reset emails');
         $this->phpauth_setting('site_key', 'fghuior.)/!/jdUkd8s2!7HVHG7777ghg', 'a random string that you should modify used to validate cookies to ensure they are not tampered with');
         $this->phpauth_setting('site_name', $sitename, 'the name of the website to display in the activation and password reset emails');
         $this->phpauth_setting('site_timezone', 'Africa/Johannesburg', '');
         $this->phpauth_setting('site_url', $siteurl, ' the URL of the Auth root, where you installed the system, without the trailing slash, used for emails.');
         $this->phpauth_setting('site_language', 'en_GB', '');
         $this->phpauth_setting('smtp', '1', ' to use sendmail for emails, 1 to use SMTP');
         $this->phpauth_setting('smtp_debug', $debug, 'to disable SMTP debugging, 1 to enable SMTP debugging, useful when you are having email/smtp issues');
         $this->phpauth_setting('smtp_auth', '1', '0 if the SMTP server doesnt require authentication, 1 if authentication is required');
         $this->phpauth_setting('smtp_host', $smtphost, 'hostname of the SMTP server');
         $this->phpauth_setting('smtp_password', $pass, '');
         $this->phpauth_setting('smtp_port', $smtpport, '');
         $this->phpauth_setting('smtp_security', $smtpsecure, ' NULL for no encryption, tls for TLS encryption, ssl for SSL encryption');
         $this->phpauth_setting('smtp_username', $email, 'the username for the SMTP server Table names used in PHPAuth');
         $this->phpauth_setting('table_attempts', 'phpauth_attempts', ' name of table with all attempts (default is phpauth_attempts)');
         $this->phpauth_setting('table_requests', 'phpauth_requests', ' name of table with all requests (default is phpauth_requests)');
         $this->phpauth_setting('table_sessions', 'phpauth_sessions', '');
         $this->phpauth_setting('table_users', 'phpauth_users', '');
         $this->phpauth_setting('table_emails_banned', 'phpauth_emails_banned', '');
         $this->phpauth_setting('table_translations', 'phpauth_translation_dictionary', ' name of table with translation for all messages');
         $this->phpauth_setting('verify_email_max_length', '100', ' maximum EMail length, default is 100');
         $this->phpauth_setting('verify_email_min_length', '8', ' minimum EMail length, default is 5');
         $this->phpauth_setting('verify_email_use_banlist', '1', 'use banlist while checking allowed EMails (see /files/domains.json), default is 1 (true)');
         $this->phpauth_setting('verify_password_min_length', '3', ' minimum password length, default is 3');
         $this->phpauth_setting('request_key_expiration', '+10 minutes', '');
         $this->phpauth_setting('translation_source', 'php', 'source of translation, possible values: - sql - data from table_translations will be used, - php - default, translations will be loaded from $this->phpauth_settinglanguages/.php)');
         $this->phpauth_setting('recaptcha_enabled', 0, ' 1 for Google reCaptcha enabled, 0 - disabled (default)');
         $this->phpauth_setting('recaptcha_site_key', '', ' string, contains public reCaptcha key (for javascripts)');
         $this->phpauth_setting('recaptcha_secret_key', '', ' string, contains secret reCaptcha key');
         $config = new PHPAuthConfig($dbh);
         $auth = new PHPAuth($dbh, $config);
         $greg = array('firstname' => 'Gregory', 'lastname' => 'Schoeman', 'userrole' => 'admin', 'phone' => '0799959818', 'dob'=>'12/15/1997', 'business' => '', 'opening_date'=>'', 'address_street'=>'','city'=>'', 'country'=>'', 'industry'=>'', 'description'=>'');
         $auth->register('gregory@realhost.co.za','5d^hd$ffTHPqqMNB', '5d^hd$ffTHPqqMNB', $greg, $captcha_response = false, $use_email_activation = false);
         $kate = array('firstname' => 'Kate', 'lastname' => 'Damad', 'userrole' => 'admin', 'phone' => '', 'dob'=>'', 'business' => '', 'opening_date'=>'', 'address_street'=>'','city'=>'', 'country'=>'', 'industry'=>'', 'description'=>'');
         $auth->register('kate@switchboardcollaboration.com','qNWnBL8=Pc+m', 'qNWnBL8=Pc+m', $kate, $captcha_response = false, $use_email_activation = false);
         $lesley = array('firstname' => 'User', 'lastname' => 'Name', 'userrole' => 'admin', 'phone' => '', 'dob'=>'', 'business' => '', 'opening_date'=>'', 'address_street'=>'','city'=>'', 'country'=>'', 'industry'=>'', 'description'=>'');
         $auth->register('lesley@switchboardcollaboration.com','M5?2.*SNwV=[', 'M5?2.*SNwV=[', $lesley, $captcha_response = false, $use_email_activation = false);

     }

     /**
      * Writes PHPAuth datatables
      */
     public function phpauth_tables() {
         $DB = new DB();
         $DB->query("CREATE TABLE IF NOT EXISTS `phpauth_config` (
              `setting` varchar(100) NOT NULL,
              `value` varchar(100) DEFAULT NULL,
              `description` varchar(100) DEFAULT NULL,
              UNIQUE KEY `setting` (`setting`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
         $DB->query("CREATE TABLE IF NOT EXISTS `phpauth_attempts` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `ip` char(39) NOT NULL,
              `expiredate` datetime NOT NULL,
              PRIMARY KEY (`id`),
              KEY `ip` (`ip`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
         $DB->query("CREATE TABLE IF NOT EXISTS `phpauth_requests` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uid` int(11) NOT NULL,
              `token` CHAR(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
              `expire` datetime NOT NULL,
              `type` ENUM('activation','reset') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
              PRIMARY KEY (`id`),
              KEY `type` (`type`),
              KEY `token` (`token`),
              KEY `uid` (`uid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
         $DB->query("CREATE TABLE IF NOT EXISTS `phpauth_sessions` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uid` int(11) NOT NULL,
              `hash` char(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
              `expiredate` datetime NOT NULL,
              `ip` varchar(39) NOT NULL,
              `device_id` varchar(36) DEFAULT NULL,
              `agent` varchar(200) NOT NULL,
              `cookie_crc` char(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
         $DB->query("CREATE TABLE IF NOT EXISTS `phpauth_users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `email` varchar(100) DEFAULT NULL,
          `password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
          `isactive` tinyint(1) NOT NULL DEFAULT '0',
          `firstname` varchar(100) DEFAULT NULL,
          `lastname` varchar(100) DEFAULT NULL,
          `phone` varchar(100) DEFAULT NULL,
          `dob` varchar(100) DEFAULT NULL,
          `business` varchar(100) DEFAULT NULL,
          `opening_date` varchar(100) DEFAULT NULL,
          `address_street` varchar(100) DEFAULT NULL,
          `city` varchar(100) DEFAULT NULL,
          `country` varchar(100) DEFAULT NULL,
          `industry` varchar(100) DEFAULT NULL,
          `description` varchar(100) DEFAULT NULL,
          `userrole` varchar(100) DEFAULT NULL,
          `profilepic` varchar(100) DEFAULT NULL,
          `bannerpic` varchar(100) DEFAULT NULL,
          `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
         $DB->query("CREATE TABLE IF NOT EXISTS `phpauth_emails_banned` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `domain` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
         $DB->query("CREATE TABLE IF NOT EXISTS `contact_form` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `firstname` varchar(255) NOT NULL,
                `lastname` varchar(255) NOT NULL,
                `email` varchar(255) NOT NULL,
                `honeypot` varchar(255) NULL,
                `telephone` varchar(255) NULL,
                `message` text NOT NULL,
                `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `status` varchar(20) NOT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
         $DB = null;
     }
}