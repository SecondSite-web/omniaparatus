<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../php/connect-pdo.php';
// Root User Setup Settings -
use PHPAuth\Auth_ext as auth_ext;
$auth_ext = new auth_ext();
$siteurl = 'http://127.0.0.1'; // without trailing slash. this is added in functions.php
$sitename = 'Rent A Vehicle';

$firstname = 'Greg';
$lastname = 'Schoeman';
$rootemail = 'gregory@realhost.co.za';
$rootpassword = '8rnD076345tgLyhD78SF4S';
$allowRegister = '1';
$site_admin_dir =  'twig/'; // the admin directory name

// PHP Mailer
$debug = '0'; // for smtp mailer, excluding PHPAuth
$email = 'info@secondsite.xyz'; // SMTP account email
$emailname = 'Twig Mailer'; // From Name
$pass = 'vOw0nQDIL9A2bb8zTMv8EM1BZ';
$smtphost = 'rs13.cphost.co.za';
$smtpauth = 'true';
$smtpsecure = 'ssl';
$smtpport =  '465';
$subjectline = 'Website Form Submission';
$mailcc = '';
$mailbcc = '';

// PHP Auth User Authentication
$attack_mitigation_time =  '+30 minutes'; // default is +30 minutes. Must respect PHP's strtotime format.
$attempts_before_ban = '30'; // maximum amount of attempts to be made within attack_mitigation_time before temporally blocking the IP address. Default is 30
$attempts_before_verify =  '5'; // maximum amount of attempts to be made within attack_mitigation_time before requiring captcha. Default is 5
$bcrypt_cost = '10'; // the algorithmic cost of the bcrypt hashing function, can be changed based on hardware capabilities
$cookie_domain = NULL; // the domain of the session cookie, do not change unless necessary
$cookie_forget = '+30 minutes'; //the time a user will remain logged in when not ticking "remember me" on login. Must respect PHP's strtotime format.
$cookie_http = '0'; //the HTTP only protocol setting of the session cookie, do not change unless necessary
$cookie_name = 'phpauth_session_cookie'; // the name of the cookie that contains session information, do not change unless necessary
$cookie_path = '/'; // the path of the session cookie, do not change unless necessary
$cookie_remember = '+1 month'; // the time that a user will remain logged in for when ticking "remember me" on login. Must respect PHP's strtotime format.
$cookie_secure = '0'; //the HTTPS only setting of the session cookie, do not change unless necessary
$cookie_renew = '+5 minutes'; // the maximum time difference between session expiration and last page load before allowing the session to be renewed. Must respect PHP`s strtotime format.
$allow_concurrent_sessions = FALSE; //Allow a user to have multiple active sessions (boolean). If false (default), logging in will end any existing sessions.
$emailmessage_suppress_activation =  '0';
$emailmessage_suppress_reset = '0';
$mail_charset ='UTF-8';
$password_min_score =  '1'; //the minimum score given by zxcvbn that is allowed. Default is 3
$site_activation_page =  'twig/activate.php'; //the activation page name appended to the site_url in the activation email
$site_password_reset_page =  'twig/reset.php'; // the password reset page name appended to the site_url in the password reset email

$site_email =  $email; // the email address from which to send activation and password reset emails
$site_key =  'fghuior.)/!/jdUkd8s2!7HVHG7777ghg'; //a random string that you should modify used to validate cookies to ensure they are not tampered with
$site_name = $sitename; // the name of the website to display in the activation and password reset emails

$site_timezone = 'Africa/Johannesburg';
$site_url =  $siteurl; // the URL of the Auth root, where you installed the system, without the trailing slash, used for emails.
$site_language = 'en_GB';
$smtp =  '1'; // to use sendmail for emails, 1 to use SMTP
$smtp_debug =  '0'; //to disable SMTP debugging, 1 to enable SMTP debugging, useful when you are having email/smtp issues
$smtp_auth = '1'; //0 if the SMTP server doesn't require authentication, 1 if authentication is required
$smtp_host = $smtphost; // hostname of the SMTP server
$smtp_password = $pass;
$smtp_port = $smtpport;
$smtp_security = $smtpsecure; // NULL for no encryption, tls for TLS encryption, ssl for SSL encryption
$smtp_username = $email; //the username for the SMTP server
// Table names used in PHPAuth
$table_attempts =  'phpauth_attempts'; // name of table with all attempts (default is 'phpauth_attempts')
$table_requests =  'phpauth_requests'; // name of table with all requests (default is 'phpauth_requests')
$table_sessions =  'phpauth_sessions';
$table_users = 'phpauth_users';
$table_emails_banned = 'phpauth_emails_banned';
$table_translations = 'phpauth_translation_dictionary'; // name of table with translation for all messages

$verify_email_max_length = '100'; // maximum EMail length, default is 100
$verify_email_min_length = '8'; // minimum EMail length, default is 5
$verify_email_use_banlist =  '1'; //use banlist while checking allowed EMails (see /files/domains.json), default is 1 (true)
$verify_password_min_length =  '3'; // minimum password length, default is 3
$request_key_expiration = '+10 minutes';
$translation_source = 'php'; // source of translation, possible values: 'sql' (data from <table_translations> will be used), 'php' (default, translations will be loaded from languages/.php), 'ini' (will be used languages/.ini files)
$recaptcha_enabled = 0; // 1 for Google reCaptcha enabled, 0 - disabled (default)
$recaptcha_site_key = ''; // string, contains public reCaptcha key (for javascripts)
$recaptcha_secret_key = ''; // string, contains secret reCaptcha key
