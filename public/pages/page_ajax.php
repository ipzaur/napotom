<?php
if ($engine->auth->user['id'] == 0) {
    die();
}

$allow_gates = array('linksave', 'linkdelete', 'gettitle', 'linkwatched', 'gettags');
if (isset($engine->url[1])) {
    header("Content-type: text/html; charset=utf-8");
    if (in_array($engine->url[1], $allow_gates)) {
        include ('pages/ajax/' . $engine->url[1] . '.php');
    }
}
die();