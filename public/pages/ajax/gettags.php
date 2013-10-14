<?php
$error = array();

// проверяем наличие ID
if ( !isset($_POST['name']) || ($_POST['name'] == '') ) {
    $error[] = 'ERROR_GETTAGS_NO_NAME';
}

if (count($error) > 0) {
    echo json_encode(array('error' => $error));
}

$engine->loadIface('tag');
// небольшая проверка на наличие прав на ссылку с присланным ID, если пересылаем или редактируем
$getparam = array(
    'name' => '%' . $_POST['name'] . '%',
    'user_id' => $engine->auth->user['id']
);
$groupparam = array('name');
$orderparam = array('name' => 'asc');
$tags = $engine->tag->get($getparam, $orderparam, $groupparam);
if ($tags == false) {
    $error[] = 'ERROR_GETTAGS_EMPTY';
}

echo json_encode(array('error' => $error, 'result' => $tags));
