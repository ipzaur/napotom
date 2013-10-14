<?php
if (isset($_POST) && isset($_POST['auth_type'])) {
    switch ($_POST['auth_type']) {
        case 'vk'   :
            $loginparam = array('auth_type' => 'vk');
            $engine->auth->login($loginparam);
            break;

        case 'fb'   :
            $loginparam = array('auth_type' => 'fb');
            $engine->auth->login($loginparam);
            break;

        case 'out'  :
            $engine->auth->logout();
        case 'self' :
            if (isset($_POST['email']) && isset($_POST['stars'])) {
                $loginparam = array(
                    'login'     => $_POST['email'],
                    'password'  => $_POST['stars'],
                    'auth_type' => 'self'
                );
                $errors = $engine->auth->login($loginparam);
            }
            break;
    }
}
header('Location: ' . $engine->siteurl);
die();
