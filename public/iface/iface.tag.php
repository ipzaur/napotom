<?php
/**
 * Interface Tag
 * Интерфейс для работы с тэгами
 * @author Alexey iP Subbota
 * @version 1.0
 */
class iface_tag extends iface_base_entity
{
    public $engine = NULL;

    protected $order_fields = array('link_id', 'name', 'tag_count' => '');
    protected $group_fields = array('name');
    protected $get_fields = array(
        'link_id' => array('type' => 'integer', 'notnull' => 1),
        'name'    => array('type' => 'string',  'notnull' => 1),
        'user_id' => array('type' => 'integer', 'notnull' => 1, 'join' => array(
            'table'    => 'link',
            'key_main' => 'link_id',
            'key_join' => 'id',
            'field'    => 'user_id'
        ))
    );

    protected $save_fields = array(
        'name' => array('type' => 'string', 'notnull' => 1),
        'link_id' => array('type' => 'integer', 'notnull' => 1)
    );
    protected $table_name = 'tag';



    /**
     * Начало запроса к БД
     * @result string - строку с началом запроса
     */
    protected function getQuery()
    {
        return  'SELECT tag.*, count(tag.name) AS tag_count FROM tag';
    }

    /**
     * Начало запроса к БД для подсчёта
     * @result string - строку с началом запроса
     */
    protected function getCountQuery()
    {
        return  'SELECT tag.* FROM tag';
    }

    public function __construct()
    {
    }
}
