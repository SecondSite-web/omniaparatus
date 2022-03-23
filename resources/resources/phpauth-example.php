<?php 
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($auth->isLogged()) {
        $userId = $auth->getSessionUID($_COOKIE[$authConfig->cookie_name]);
        echo json_encode([
                    'userId' => $userId,
                ]);
        die();
    }

    $login = $auth->login($email, $password, true);

    if($login['error']) {
        die($login['message']);
    } else {
        $userId = $auth->getSessionUID($login['hash']);
        echo json_encode([
                    'userId' => $userId,
                ]);
        die();
    }
} else {
    die('Error');
}