<?php
$error = array();

// проверяем наличие ID
if ( !isset($_POST['url']) || ($_POST['url'] == '') ) {
    $error[] = 'ERROR_GETTITLE_NO_URL';
}
if (!preg_match('~^.*?\:\/\/.*?\..{2,4}($|\/|\?)~', $_POST['url'])) {
    $error[] = 'ERROR_GETTITLE_WRONG_URL';
}

// проверяем на антиботство
if ( ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') || !preg_match('~^http://napotom.me/~', $_SERVER['HTTP_REFERER']) ) {
    $error[] = 'ERROR_GETTITLE_IS_BOT';
}

if (!session_id()) {
     session_start();
}
if ( isset($_SESSION['last_get_title']) && (time() - $_SESSION['last_get_title'] < 2) ) {
    $error[] = 'ERROR_GETTITLE_IS_BOT';
}

// если в процессе были ошибки, то отправим их
if (count($error) > 0) {
    echo json_encode(array('error' => $error));
    die();
}
$_SESSION['last_get_title'] = time();

$engine->loadIface('curl');
$content = $engine->curl->send($_POST['url'], false, array('with_info' => 1));
if ($content['info']['http_code'] != 200) {
    $error[] = 'ERROR_GETTITLE_E404';
    echo json_encode(array('error' => $error));
    die();
}
if (preg_match('~<title>(.*?)</title>~us', $content['content'], $title)) {
    $title = str_replace("\n", '', $title[1]);
}

echo json_encode(array('error' => $error, 'title' => $title));


