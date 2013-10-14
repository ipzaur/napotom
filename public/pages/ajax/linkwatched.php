<?php
$error = array();

// проверяем наличие ID
if ( !isset($_POST['id']) || ($_POST['id'] == '') ) {
    $error[] = 'ERROR_WATCHEDLINK_NO_ID';
}

$engine->loadIface('link');
// небольшая проверка на наличие прав на ссылку с присланным ID, если пересылаем или редактируем
$getparam = array(
    'id' => $_POST['id'],
    'user_id' => $engine->auth->user['id']
);
$ourlink = $engine->link->get($getparam);
if ($ourlink == false) {
    $error[] = 'ERROR_WATCHEDLINK_NOTOWNER';
}

// если в процессе были ошибки, то отправим их
if (count($error) == 0) {
    $saveparam = array('watched' => 1);
    $whereparam = array('id' => $ourlink['id']);
    $engine->link->save($saveparam, $whereparam);
}
echo json_encode(array('error' => $error));

