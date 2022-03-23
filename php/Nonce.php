<?php

/**
 * @return \Nonce\Nonce
 */
function nonce_init(){
    $nonceConfig = new \Nonce\Config\Config;
    $nonceCookie = new \Nonce\HashStore\Cookie;
    $nonceConfig->setConfig('COOKIE_PATH', '/' );
    $nonceConfig->setConfig('COOKIE_DOMAIN', '127.0.0.1' );
    $nonceConfig->setConfig('CSRF_COOKIE_NAME', 'CSRF');
    $nonceConfig->setConfig('CSRF_COOKIE_TTL', 7200); // 2 hrs
    $nonceConfig->setConfig('RANDOM_SALT', 'TjxA$b,Lo$mjqU|T#x?HdnJ1.dREjkM|'); // 32 bit SALT returns 256char hash
    $nonceConfig->setConfig('NONCE_HASH_CHARACTER_LIMIT',22);
    $nonceConfig->setConfig('TOKEN_HASHER_ALGO', 'sha512');
    $nonceConfig->setConfig('NONCE_DEFAULT_TTL', 600); // 10 min
    $nonceConfig->setConfig('HASH_ID_CHARACTER_LIMIT', 11);
    $nonceUtil = new \Nonce\Nonce($nonceConfig, $nonceCookie);
    return $nonceUtil;
};

/**
 * @param $nonce
 * @param $action
 * @return mixed
 */
function verify_nonce($nonce, $action) {
    $nonceUtil = nonce_init();
    $nonce_test = $nonceUtil->verify($nonce, $action);
    $nonceUtil->delete($action);
    return $nonce_test;
};
