<?php
namespace PHPAuth;

use DB;
use PHPAuth\Auth as PHPAuth;
use PHPAuth\Config as PHPAuthConfig;


class bruteforce {
    protected $dbh;
    private static $autoclear = true;

    private function bf_setup() {
        define('bruteforce_set', true);
        $DB = new DB();
        $DB->query("CREATE TABLE IF NOT EXISTS `user_failed_logins` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` bigint(20) NOT NULL,
              `ip_address` int(11) unsigned DEFAULT NULL,
              `attempted_at` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;");
    }
	// array of throttle settings. # failed_attempts => response
    private static $default_throttle_settings = [
        3 => 200,            //delay in seconds
        6 => 400,            //delay in seconds
        8 => 'captcha'    //captcha
    ];
	
	//time frame to use when retrieving the number of recent failed logins from database
    private static $time_frame_minutes = 10;

	//add a failed login attempt to database. returns true, or error 
	public function addFailedLoginAttempt($dbh, $email_address){
        if ( ! defined('bruteforce_set')) {
            $this->bf_setup();
        }
        $config = new PHPAuthConfig($dbh);
        $auth = new PHPAuth($dbh, $config);
        $ip_address = $this->getIp();
        $user_id = $auth->getUID($email_address);
		//get current timestamp
		$timestamp = date('Y-m-d H:i:s');
		
		//attempt to insert failed login attempt
		try{
			$stmt = $dbh->query('INSERT INTO user_failed_logins SET user_id = '.$user_id.', ip_address = INET_ATON("'.$ip_address.'"), attempted_at = NOW()');
			//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return true;
		} catch(\PDOException $ex){
			//return errors
			return $ex;
		}
	}
	//get the current login status. either safe, delay, catpcha, or error
	public function getLoginStatus($dbh, $options = null){
        $autoclear = self::$autoclear;
        if ( ! defined('bruteforce_set')) {
            $this->bf_setup();
        }

		//setup response array
		$response_array = array(
			'status' => 'safe',
			'message' => null
		);
		
		//attempt to retrieve latest failed login attempts
		$stmt = null;
		$latest_failed_logins = null;
		$row = null;
		$latest_failed_attempt_datetime = null;
		try{
			$stmt = $dbh->query('SELECT MAX(attempted_at) AS attempted_at FROM user_failed_logins');
			$latest_failed_logins = $stmt->rowCount();
			$row = $stmt-> fetch();
			//get latest attempt's timestamp
			$latest_failed_attempt_datetime = (int) date('U', strtotime($row['attempted_at']));
		} catch(\PDOException $ex){
			//return error
			$response_array['status'] = 'error';
			$response_array['message'] = $ex;
		}
		
		//get local var of throttle settings. check if options parameter set
		if($options == null){
			$throttle_settings = self::$default_throttle_settings;
		}else{
			//use options passed in
			$throttle_settings = $options;
		}
		//grab first throttle limit from key
		reset($throttle_settings);
		$first_throttle_limit = key($throttle_settings);

		//attempt to retrieve latest failed login attempts
		try{
			//get all failed attempts within time frame
			$get_number = $dbh->query('SELECT * FROM user_failed_logins WHERE attempted_at > DATE_SUB(NOW(), INTERVAL '.self::$time_frame_minutes.' MINUTE)');
			$number_recent_failed = $get_number->rowCount();
			//reverse order of settings, for iteration
			krsort($throttle_settings);
			
			//if number of failed attempts is >= the minimum threshold in throttle_settings, react
			if($number_recent_failed >= $first_throttle_limit ){				
				//it's been decided the # of failed logins is troublesome. time to react accordingly, by checking throttle_settings
				foreach ($throttle_settings as $attempts => $delay) {
					if ($number_recent_failed > $attempts) {
						// we need to throttle based on delay
						if (is_numeric($delay)) {
							//find the time of the next allowed login
							$next_login_minimum_time = $latest_failed_attempt_datetime + $delay;
							
							//if the next allowed login time is in the future, calculate the remaining delay
							if(time() < $next_login_minimum_time){
								$remaining_delay = $next_login_minimum_time - time();
								// add status to response array
								$response_array['status'] = 'delay';
								$response_array['message'] = $remaining_delay;
							}else{
								// delay has been passed, safe to login
								$response_array['status'] = 'safe';
                                $response_array['message'] = 'It is safe to login';

							}
							//$remaining_delay = $delay - (time() - $latest_failed_attempt_datetime); //correct
							//echo 'You must wait ' . $remaining_delay . ' seconds before your next login attempt';

							
						} else {
							// add status to response array
							$response_array['status'] = 'captcha';
                            $response_array['message'] = 'Captcha Needed';
						}
						break;
					}
				}  
				
			}
			//clear database if config set
			if($autoclear == true){
				//attempt to delete all records that are no longer recent/relevant
				try{
					//get current timestamp
					$now = date('Y-m-d H:i:s');
					$stmt = $dbh->query('DELETE from user_failed_logins WHERE attempted_at < DATE_SUB(NOW(), INTERVAL '.(self::$time_frame_minutes * 2).' MINUTE)');
					$stmt->execute();
					
				} catch(\PDOException $ex){
					$response_array['status'] = 'error';
					$response_array['message'] = $ex;
				}
			}
			
		} catch(\PDOException $ex){
			//return error
			$response_array['status'] = 'error';
			$response_array['message'] = $ex;
		}
		
		//return the response array containing status and message 
		return $response_array;
	}
	
	//clear the database
	public function clearDatabase(){
		//attempt to delete all records
		try{
			$stmt = $this->dbh->query('DELETE from user_failed_logins');
			return true;
		} catch(\PDOException $ex){
			//return errors
			return $ex;
		}
	}

    private function getIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ipAddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipAddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipAddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipAddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipAddress = getenv('REMOTE_ADDR');
        } else {
            $ipAddress = '127.0.0.1';
        }

        return $ipAddress;
    }
}
