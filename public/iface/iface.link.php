<?php
/**
 * Interface Link
 * Интерфейс для работы со ссылками
 * @author Alexey iP Subbota
 * @version 1.0
 */
class iface_link extends iface_base_entity
{
    public $engine = NULL;

    protected $order_fields = array('id', 'url', 'create_date', 'watched');
    protected $group_fields = array('id');
    protected $get_fields = array(
        'id'      => array('type' => 'integer', 'many' => 1, 'check_single' => 1, 'notnull' => 1),
        'user_id' => array('type' => 'integer', 'notnull' => 1),
        'watched' => array('type' => 'integer'),
        'tag'     => array('type' => 'string',  'join' => array(
            'table'    => 'tag',
            'key_main' => 'id',
            'key_join' => 'link_id',
            'field'    => 'name'
        ))
    );
    protected $save_fields = array(
        'url' => array('type' => 'string', 'notnull' => 1),
        'title' => array('type' => 'string'),
        'user_id' => array('type' => 'integer', 'notnull' => 1),
        'user_from_id' => array('type' => 'integer', 'notnull' => 0),
        'watched' => array('type' => 'integer'),
        'create_date' => array('type' => 'datetime')
    );
    protected $table_name = 'link';


    /**
     * Дополнительная функция по выборке ссылок
     * @param array links - результат выборки. в процессе вернётся изменённый массив с подцепленными тэгами
     */
    protected function getAfter(&$links = array())
    {
        if (isset($links['id'])) {
            $getparam = array('link_id' => $links['id']);
            $groupparam = array('name');
            $links['tag'] = $this->engine->tag->get($getparam, false, $groupparam);
        } else {
            foreach ($links AS &$link) {
                $getparam = array('link_id' => $link['id']);
                $groupparam = array('name');
                $link['tag'] = $this->engine->tag->get($getparam, false, $groupparam);
            }
        }
    }


    public function start()
    {
        $this->engine->loadIface('tag');
    }


    public function __construct()
    {
    }
}
