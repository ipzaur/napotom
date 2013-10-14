<?php
$sub_page = 'links';
if (isset($engine->url[0])) {
    if ($engine->url[0] == 'friends') {
        $sub_page = 'friends';
    } else if ($engine->url[0] == 'settings') {
        $sub_page = 'settings';
    }
}
$engine->tpl->addvar('sub_page', $sub_page);

include 'profile/page_' . $sub_page . '.php';
