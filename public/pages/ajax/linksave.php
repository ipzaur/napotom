<?php
$error = array();

// проверяем наличие ID
if ( !isset($_POST['id']) || ($_POST['id'] == '') ) {
    $error[] = 'ERROR_SAVELINK_NO_ID';
}
if ( ($_POST['id'] != 'add') && !($_POST['id'] > 0) ) {
    $error[] = 'ERROR_SAVELINK_WRONG_ID';
}

// узнаём тип сохранения ссылки (добавление, передача, редактирование)
$allow_save_type = array('add', 'send', 'edit');
if ( !isset($_POST['type']) || !in_array($_POST['type'], $allow_save_type) ) {
    $error[] = 'ERROR_SAVELINK_NO_SAVETYPE';
}

$engine->loadIface('link');
$saveparam = array();
// небольшая проверка на наличие прав на ссылку с присланным ID, если пересылаем или редактируем
if ( ($_POST['type'] == 'edit') || ($_POST['type'] == 'send') ) {
    $getparam = array(
        'id' => $_POST['id'],
        'user_id' => $engine->auth->user['id']
    );
    $ourlink = $engine->link->get($getparam);
    if ($ourlink == false) {
        $error[] = 'ERROR_SAVELINK_NOTOWNER';
    }
}

// если мы пересылаем кому-то нашу ссылку
if ($_POST['type'] == 'send') {
    // то сначала вытащим её из нашей коллекции ссылок, чтобы заполнить поле url и title
    $saveparam['url'] = $ourlink['url'];
    $saveparam['title'] = $ourlink['title'];
}

$result = array();
// если же мы редактируем или создаём ссылку, то обработаем введённую инфу
if ( ($_POST['type'] == 'edit') || ($_POST['type'] == 'add') ) {
    if ( !isset($_POST['url']) || ($_POST['url'] == '') ) {
        $error[] = 'ERROR_SAVELINK_NO_URL';
    } else {
        // узнаем, указан ли протокол у ссылки или нет. в случае "нет" добавим http
        if (!preg_match('~^(http://)|(ftp://)|(https://)~us', $_POST['url'], $match)) {
            $_POST['url'] = 'http://' . $_POST['url'];
        }
        $saveparam['url']   = $_POST['url'];
        $saveparam['title'] = ( isset($_POST['title']) && ($_POST['title'] != '') ) ? $_POST['title'] : $_POST['url'];

        $result['url']   = $saveparam['url'];
        $result['title'] = $saveparam['title'];
    }
}

// если в процессе были ошибки, то отправим их
if (count($error) > 0) {
    echo json_encode(array('error' => $error));
    die();
}

// иначе начнём сохранение
$engine->loadIface('tag');
$links_id = array();
// отправитель - это по-любому мы
$saveparam['user_from_id'] = $engine->auth->user['id'];

// если отправляем или добавляем, то проверим указаны ли получатели и разошлём по ним
if ( ($_POST['type'] == 'send') || ($_POST['type'] == 'add') ) {
    if ( !isset($_POST['friend']) || (count($_POST['friend']) == 0) ) {
        $error[] = 'ERROR_SAVELINK_NO_FRIENDS';
    } else {
        foreach ($_POST['friend'] AS $friend_id) {
            $saveparam['user_id'] = ($friend_id == 'self') ? $engine->auth->user['id'] : intval($friend_id);
            $links_id[] = $engine->link->save($saveparam);
            if ( ($friend_id == 'self') && ($_POST['type'] == 'add') ){
                $result['id'] = $links_id[count($links_id) - 1];
            }
        }
    }

// если редактируем, то просто обновим инфу
} else if ($_POST['type'] == 'edit') {
    $whereparam = array('id' => $_POST['id']);
    $engine->link->save($saveparam, $whereparam);
    $links_id[] = $_POST['id'];
    $result['id'] = $_POST['id'];
}

// если мы добавляем или редактируем и у нас есть тэги, то сохраним их
if ( (($_POST['type'] == 'add') || ($_POST['type'] == 'edit')) && isset($_POST['tag']) ) {
    foreach ($links_id AS $link_id) {
        if ($_POST['type'] == 'edit') {
            $tag_deleteparam = array('link_id' => $link_id);
            $engine->tag->delete($tag_deleteparam);
        }
        foreach ($_POST['tag'] AS $tag_name) {
            if ($tag_name != '') {
                $tag_saveparam = array(
                    'link_id' => $link_id,
                    'name'    => $tag_name
                );
                $engine->tag->save($tag_saveparam);
            }
        }
    }
}

echo json_encode(array('error' => $error, 'result' => $result));

