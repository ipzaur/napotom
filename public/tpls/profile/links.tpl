{if:(tags_count:>0)}
    <div id="tags" class="tags">
        <h2 class="tags_header">Поиск по тэгам:</h2>
        <div class="tags_list">
            <p><input id="search" class="wide" type="text" value="" placeholder="введите тэг"></p>
            {if:(new_links_count:>0)}<p class="" data-tag=""><a class="tag new{if:(curtag:=_new)} cur{:fi}" href="{siteurl:}tag/_new/">Новые</a> {new_links_count:}</p>{:fi}
            {tags:}<p data-tag="{name:}"><a class="tag{if:(name:=^curtag:)} cur{:fi}" href="{^siteurl:}tag/{name:}/">{name:}</a> {tag_count:}</p>{:tags}
        </div>
    </div>
{:fi}

<div class="content">
    <div id="links">
        <p class="link_add" data-id="add"><span class="link_fake" data-link_action="edit">Добавить ссылку</span></p>

        {links:}
            <div class="link{if:(watched:=0)} new{:fi}" data-id="{id:}">
                <a class="link_a" href="{url:}" target="_blank" title="{title:}">{title:}</a>
                <div class="link_tags">{tag:}<a class="tag{if:(name:=^curtag:)} cur{:fi}" href="{^siteurl:}tag/{name:}/">{name:}</a>{:tag}</div>
                <div class="link_but link_but-edit" title="Редактировать ссылку" data-link_action="edit"></div><div class="link_but link_but-delete" title="Удалить ссылку" data-link_action="delete"></div>
            </div>
        {:links}


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
                    {friends:}
                        <input id="friend_{id:}" type="checkbox" name="friend[]" value="{id:}" class="friend_input">
                        <label class="friend" for="friend_{id:}">
                            <img class="friend_ava" src="{^siteurl:}{avatar:}">
                            <p class="friend_name">{name:}</p>
                        </label>
                    {:friends}
                </div>
            </div>

            <p class="link_edit_send"><span class="link_fake-white" data-link_action="edit_cancel">отменить</span> или <button type="button" data-link_action="edit_submit">Добавить</button></p>
        </div>

        <div id="link_dummy" class="link h">
            <a class="link_a" href="" target="_blank"></a>
            <div class="link_tags"></div>
        </div>
    </div>
</div>