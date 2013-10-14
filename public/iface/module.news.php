<?php
/**
 * Module News
 * Модуль для работы с новостями
 * @author Alexey iP Subbota
 * @version 1.0
 */
class module_news
{
    /**
     * Конструктор
     */
    public function __construct()
    {
    }

    public function getNews($page_id = 0, $limit = 5)
    {
        $query = 'SELECT id, title, content, date_create FROM news ORDER BY date_create DESC LIMIT ' . ( intval($page_id) * intval($limit) ) . ', ' . intval($limit);
        return module_core::$db->query($query, 'list');
    }
}