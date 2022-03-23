<?php

/**
 * Creates and returns the nonce
 * @return \Nonce\Nonce
 */
// Custom twig function to trigger nonce generation from the client to buffer nonce headers and set CSPR headers to mark scripts
$nonce_function = new \Twig\TwigFunction('call_nonce', function ($action_name, $script = false) {
    ob_start();
    $nonceUtil = nonce_init();
    $nonce = $nonceUtil->create( $action_name );
    ob_end_flush();
    return $nonce;
});

