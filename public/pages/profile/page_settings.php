<?php
$auth_refresh = false;
if (!empty($_POST)) {
    $saveparam = array('name' => $_POST['name']);
    $whereparam = array('id' => $engine->auth->user['id']);
    $engine->user->save($saveparam, $whereparam);
    $auth_refresh = true;
}
if (!empty($_FILES)) {
    $engine->user->saveAvatar($engine->auth->user['id'], $_FILES['avatar']['tmp_name']);
    $auth_refresh = true;
}

if ($auth_refresh == true) {
    $engine->auth->refresh();
}

$engine->tpl->addvar('name', $engine->auth->user['name']);
$engine->tpl->addvar('avatar', $engine->auth->user['avatar']);
