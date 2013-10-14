<?php
// заберём наши тэги
$engine->loadIface('tag');
$getparam   = array('user_id' => $engine->auth->user['id']);
$groupparam = array('name');
$orderparam = array(
    'tag_count' => 'desc',
    'name' => 'asc'
);
$tags = $engine->tag->get($getparam, $orderparam, $groupparam);
$engine->tpl->addvar('tags', $tags);
$tags_count = $engine->tag->getCount($getparam);
$engine->tpl->addvar('tags_count', count($tags));


// заберём наши ссылки
$engine->loadIface('link');
$getparam = array('user_id' => $engine->auth->user['id']);
if (isset($engine->url[0])) {
    if ( ($engine->url[0] == 'tag') && isset($engine->url[1]) ) {
        $curtag = urldecode($engine->url[1]);
        $engine->tpl->addvar('curtag', $curtag);
        if ($curtag == '_new') {
            $getparam['watched'] = 0;
        } else {
            $getparam['tag'] = $curtag;
        }
    }
}
$orderparam = array(
    'watched' => 'asc',
    'create_date' => 'desc',
    'id' => 'desc'
);
$groupparam = array('id');
$links = $engine->link->get($getparam, $orderparam, $groupparam);
$engine->tpl->addvar('links', $links);
$engine->tpl->addvar('links_count', count($links));

$getparam = array(
    'user_id' => $engine->auth->user['id'],
    'watched' => 0
);
$engine->tpl->addvar('new_links_count', $engine->link->getCount($getparam));


// заберём наших друзей
$friends = array();
$friends[] = array(
    'id'     => 'self',
    'name'   => 'Себе',
    'avatar' => $engine->auth->user['avatar']
);
$engine->tpl->addvar('friends', $friends);
