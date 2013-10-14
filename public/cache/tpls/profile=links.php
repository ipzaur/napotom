<?php
echo '';
if (isset($this->tplvar['tags_count']) && ($this->tplvar['tags_count']>'0')) {echo '
    <div id="tags" class="tags">
        <h2 class="tags_header">Поиск по тэгам:</h2>
        <div class="tags_list">
            <p><input id="search" class="wide" type="text" value="" placeholder="введите тэг"></p>
            ';
if (isset($this->tplvar['new_links_count']) && ($this->tplvar['new_links_count']>'0')) {echo '<p class="" data-tag=""><a class="tag new';
if (isset($this->tplvar['curtag']) && ($this->tplvar['curtag']=='_new')) {echo ' cur';
}echo '" href="';
if ( isset($this->tplvar['siteurl']) ) {
echo $this->tplvar['siteurl'];
}
echo 'tag/_new/">Новые</a> ';
if ( isset($this->tplvar['new_links_count']) ) {
echo $this->tplvar['new_links_count'];
}
echo '</p>';
}echo '
            ';
if ( isset($this->tplvar['tags']) && is_array($this->tplvar['tags']) ) {
foreach ($this->tplvar['tags'] AS $tags_key=>$tags_value) {
echo '<p data-tag="';
if ( isset($tags_value['name']) ) {
echo $tags_value['name'];
}
echo '"><a class="tag';
if (isset($tags_value['name']) && isset($this->tplvar['curtag']) && ($tags_value['name']==$this->tplvar['curtag'])) {echo ' cur';
}echo '" href="';
if ( isset($this->tplvar['siteurl'])) {
echo $this->tplvar['siteurl'];
}
echo 'tag/';
if ( isset($tags_value['name']) ) {
echo $tags_value['name'];
}
echo '/">';
if ( isset($tags_value['name']) ) {
echo $tags_value['name'];
}
echo '</a> ';
if ( isset($tags_value['tag_count']) ) {
echo $tags_value['tag_count'];
}
echo '</p>';
}
}
echo '
        </div>
    </div>
';
}echo '

<div class="content">
    <div id="links">
        <p class="link_add" data-id="add"><span class="link_fake" data-link_action="edit">Добавить ссылку</span></p>

        ';
if ( isset($this->tplvar['links']) && is_array($this->tplvar['links']) ) {
foreach ($this->tplvar['links'] AS $links_key=>$links_value) {
echo '
            <div class="link';
if (isset($links_value['watched']) && ($links_value['watched']=='0')) {echo ' new';
}echo '" data-id="';
if ( isset($links_value['id']) ) {
echo $links_value['id'];
}
echo '">
                <a class="link_a" href="';
if ( isset($links_value['url']) ) {
echo $links_value['url'];
}
echo '" target="_blank" title="';
if ( isset($links_value['title']) ) {
echo $links_value['title'];
}
echo '">';
if ( isset($links_value['title']) ) {
echo $links_value['title'];
}
echo '</a>
                <div class="link_tags">';
if ( isset($links_value['tag']) && is_array($links_value['tag']) ) {
foreach ($links_value['tag'] AS $tag_key=>$tag_value) {
echo '<a class="tag';
if (isset($tag_value['name']) && isset($this->tplvar['curtag']) && ($tag_value['name']==$this->tplvar['curtag'])) {echo ' cur';
}echo '" href="';
if ( isset($this->tplvar['siteurl'])) {
echo $this->tplvar['siteurl'];
}
echo 'tag/';
if ( isset($tag_value['name']) ) {
echo $tag_value['name'];
}
echo '/">';
if ( isset($tag_value['name']) ) {
echo $tag_value['name'];
}
echo '</a>';
}
}
echo '</div>
                <div class="link_but link_but-edit" title="Редактировать ссылку" data-link_action="edit"></div><div class="link_but link_but-delete" title="Удалить ссылку" data-link_action="delete"></div>
            </div>
        ';
}
}
echo '


        <div id="link_edit_dummy" class="link_edit h">
            <input class="link_edit_url" type="url" value="" placeholder="адрес ссылки" title="Введите или вставьте сюда ссылку. Например: http://napotom.me/">
            <input class="link_edit_title" type="text" value="" placeholder="заголовок страницы" title="Укажите комментарий к ссылке. Например: сервис для ссылок">
            <div class="link_edit_tags">
                <div class="tag_edit" data-tag_type="dummy">
                    <input class="tag_edit_name" type="text" value="" placeholder="тэг" title="Добавьте тэг для ссылки. Например: ссылочный сервис">
                    <div class="tag_edit_del" title="удалить этот тэг"></div>
                </div>
            </div>

            <div class="friends">
                <p class="link_edit_owners">Получатели ссылки:</p>
                <div>
                    ';
if ( isset($this->tplvar['friends']) && is_array($this->tplvar['friends']) ) {
foreach ($this->tplvar['friends'] AS $friends_key=>$friends_value) {
echo '
                        <input id="friend_';
if ( isset($friends_value['id']) ) {
echo $friends_value['id'];
}
echo '" type="checkbox" name="friend[]" value="';
if ( isset($friends_value['id']) ) {
echo $friends_value['id'];
}
echo '" class="friend_input">
                        <label class="friend" for="friend_';
if ( isset($friends_value['id']) ) {
echo $friends_value['id'];
}
echo '">
                            <img class="friend_ava" src="';
if ( isset($this->tplvar['siteurl'])) {
echo $this->tplvar['siteurl'];
}
echo '';
if ( isset($friends_value['avatar']) ) {
echo $friends_value['avatar'];
}
echo '">
                            <p class="friend_name">';
if ( isset($friends_value['name']) ) {
echo $friends_value['name'];
}
echo '</p>
                        </label>
                    ';
}
}
echo '
                </div>
            </div>

            <p class="link_edit_send"><span class="link_fake-white" data-link_action="edit_cancel">отменить</span> или <button type="button" data-link_action="edit_submit">Добавить</button></p>
        </div>

        <div id="link_dummy" class="link h">
            <a class="link_a" href="" target="_blank"></a>
            <div class="link_tags"></div>
        </div>
    </div>
</div>';
