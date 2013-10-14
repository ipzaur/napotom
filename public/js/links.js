var links = $('#links');
if (links.size() > 0) {
    var link_edit_dummy = $('#link_edit_dummy');
    var link_dummy = $('#link_dummy');
    var link_edit_id = 0;


    /*
     * Закрытие редактирования ссылки
     */
    function linkEditClose()
    {
        if (link_edit_id === 0) {
            return true;
        }

        var edit_form = links.find('.link_edit[data-id="' + link_edit_id + '"]');
        edit_form.prev().removeClass('h');
        edit_form.remove();
        link_edit_id = 0;
    }


    /*
     * Открытие редактирования ссылки
     */
    function linkEditOpen(id, edit_type)
    {
        if (!id || (id == 0)) {
            id = 'add';
        }
        if (!edit_type) {
            edit_type = 'add';
        }

        if (link_edit_id !== 0) {
            linkEditClose();
        }

        link_edit_id = id;
        var edit_form = link_edit_dummy.clone().removeAttr('id').attr('data-id', link_edit_id).removeClass('h');
        var link = links.find('[data-id="' + link_edit_id + '"]');
        if (edit_type == 'edit') {
            edit_form.find('.link_edit_url').val(link.find('.link_a').attr('href'));
            edit_form.find('.link_edit_title').val(link.find('.link_a').text());
            var tag_dummy = edit_form.find('.tag_edit[data-tag_type="dummy"]');
            link.find('.tag').each(function(i, tag){
                var tag_edit = tag_dummy.clone().attr('data-tag_type', 'normal');
                tag_edit.find('.tag_edit_name').val($(tag).text());
                tag_dummy.before(tag_edit);
            });
            edit_form.find('[data-link_action="edit_submit"]').attr('data-edit_type', 'edit');
            edit_form.find('.friends').remove();
        } else {
            edit_form.find('[data-link_action="edit_submit"]').attr('data-edit_type', 'add');
        }
        link.addClass('h').after(edit_form);
    }


    /*
     * Сохранение ссылки
     */
    function linkSave(id, save_type)
    {
        if (!id || (id == 0)) {
            id = 'add';
        }
        if (!save_type) {
            save_type = 'add';
        }

        var edit_form = links.find('.link_edit[data-id="' + id + '"]');
        var post_data = [];

        if ( (save_type == 'add') || (save_type == 'edit') ) {
            var url = edit_form.find('.link_edit_url').val();
            if (url.length > 0) {
                post_data[post_data.length] = 'url=' + encodeURIComponent(url);
            }

            var title = edit_form.find('.link_edit_title').val();
            if (title.length > 0) {
                post_data[post_data.length] = 'title=' + encodeURIComponent(title);
            }

            var tags = [];
            edit_form.find('.tag_edit_name').each(function(i, tag){
                if (tag.value.length > 0) {
                    tags[tags.length] = 'tag[]=' + encodeURIComponent(tag.value);
                }
            });
            if (tags.length > 0) {
                post_data[post_data.length] = '&' + tags.join('&');
            }
        }

        if ( (save_type == 'add') || (save_type == 'send') ) {
            var friends = [];
            edit_form.find('.friend_input').each(function(i, friend){
                if ($(friend).is(':checked')) {
                    friends[friends.length] = 'friend[]=' + friend.value;
                }
            });
            if (friends.length > 0) {
                post_data[post_data.length] = '&' + friends.join('&');
            }
        }

        post_data[post_data.length] = 'id=' + id;
        post_data[post_data.length] = 'type=' + save_type;

        $.ajax({
            type     : 'POST',
            url      : '/ajax/linksave/',
            data     : post_data.join('&'),
            dataType : 'json',
            success  : function (json) {
                error = json.error;
                if (error.length > 0) {
                    return false;
                }
                if ( (save_type == 'add') || (save_type == 'edit') ) {
                    if (save_type == 'add') {
                        var link = link_dummy.clone().removeAttr('id').removeClass('h').data('id', json.result.id);
                    } else {
                        var link = links.find('.link[data-id="' + json.result.id + '"]');
                        link.find('.link_tags').empty();
                    }

                    var link_title =  ( title && (title.length > 0) ) ? title : json.result.url;
                    link.find('.link_a').attr({
                        'href'  : json.result.url,
                        'title' : link_title
                    }).text(link_title);

                    var tags = link.find('.link_tags');
                    edit_form.find('.tag_edit_name').each(function(i, tag){
                        if (tag.value.length > 0) {
                            $('<a />').attr({
                                'href'  : encodeURIComponent(tag.value),
                                'class' : 'tag'
                            }).text(tag.value).appendTo(tags);
                        }
                    });
                    if (save_type == 'add') {
                        link.addClass('new');
                        edit_form.after(link);
                    }
                }
                linkEditClose();
            }
        });
    }


    /*
     * Удаление ссылки
     */
    function linkDelete(id)
    {
        if (!id || (id == 0)) {
            return false;
        }

        $.ajax({
            type     : 'POST',
            url      : '/ajax/linkdelete/',
            data     : 'id=' + id,
            dataType : 'json',
            success  : function (json) {
                error = json.error;
                if (error.length > 0) {
                    return false;
                }
                links.find('.link[data-id="' + id + '"]').remove();
            }
        });
    }


    /*
     * узнаём тайтл у страницы
     */
    var get_title_timer = 0;
    function linkFillTitle(link)
    {
        clearTimeout(get_title_timer);
        if (!link || (link.data('id') == 0)) {
            return false;
        }

        var url_input = link.find('.link_edit_url');
        if (url_input.val().length < 5) {
            return false;
        }

        var title_input = url_input.next();
        if (title_input.val().length > 0) {
            return false;
        }

        get_title_timer = setTimeout(function(){
            $.ajax({
                type     : 'POST',
                url      : '/ajax/gettitle/',
                data     : 'url=' + encodeURIComponent(url_input.val()),
                dataType : 'json',
                success  : function (json) {
                    error = json.error;
                    if (error.length > 0) {
                        return false;
                    }
                    title_input.val(json.title);
                }
            });
        }, 500);
    }


    /*
     * найдём похожие тэги
     */
    var get_tags_timer = 0;
    var get_tags_list = $('<div />').attr('class', 'autosuggest');
    function linkGetTags(input)
    {
        input = $(input);
        get_tags_list.addClass('h');
        clearTimeout(get_tags_timer);
        var tag_name = input.val();
        if (tag_name.replace(' ', '').length == 0) {
            return false;
        }

        get_tags_timer = setTimeout(function(){
            $.ajax({
                type     : 'POST',
                url      : '/ajax/gettags/',
                data     : 'name=' + encodeURIComponent(tag_name),
                dataType : 'json',
                success  : function (json) {
                    error = json.error;
                    if (error.length > 0) {
                        return false;
                    }
                    var tag = json.result;
                    get_tags_list.empty();
                    for (var i in tag) {
                        $('<p />').attr({
                            'class'     : 'autosuggest_item' + ((i == 0) ? ' cur' : ''),
                            'data-name' : tag[i].name
                        }).html(tag[i].name.replace(tag_name, '<b>' + tag_name + '</b>')).appendTo(get_tags_list);
                    }
                    get_tags_list.removeClass('h').appendTo(input.parent());
                }
            });
        }, 500);
    }


    /*
     * пометка о просмотренности
     */
    var link_clicked_id = 0;
    function linkMarkWatched(id)
    {
        if (!id || (id == 0)) {
            return false;
        }

        var link = links.find('.link[data-id="' + id + '"]');

        if ( (link.size() == 0) || !link.hasClass('new') ) {
            return false;
        }

        $.ajax({
            type     : 'POST',
            url      : '/ajax/linkwatched/',
            data     : 'id=' + id,
            dataType : 'json',
            success  : function (json) {
                error = json.error;
                if (error.length > 0) {
                    return false;
                }
                link.removeClass('new');
            }
        });
    }

    links.bind({
        'click' : function(ev){
            var el = $(ev.target);
            if (el.data('link_action')) {
                if (el.data('link_action') == 'edit_cancel') {
                    linkEditClose();

                } else if (el.data('link_action') == 'edit_submit') {
                    var link_id = el.closest('.link_edit').data('id');
                    var edit_type = el.data('edit_type');
                    linkSave(link_id, edit_type);

                } else if (el.data('link_action') == 'edit') {
                    var link_id = el.parent().data('id');
                    var edit_type = (link_id == 'add') ? 'add' : 'edit';
                    linkEditOpen(link_id, edit_type);

                } else if (el.data('link_action') == 'delete') {
                    var link_id = el.parent().data('id');
                    linkDelete(link_id);
                }

            } else if (el.hasClass('tag_edit_del')) {
                if (el.parent().data('tag_type') != 'dummy') {
                    el.parent().remove();
                }

            } else if ( el.closest('.autosuggest_item').size() > 0 ) {
                el.closest('.tag_edit').find('.tag_edit_name').val(el.closest('.autosuggest_item').data('name'));
                get_tags_list.addClass('h');
            }

            if (!get_tags_list.hasClass('h')) {
                get_tags_list.addClass('h');
            }
        },
        'mousedown' : function(ev){
            var el = $(ev.target);
            link_clicked_id = 0;
            if ( el.hasClass('link_a') && (ev.which == 1) || (ev.which == 2) ) {
                link_clicked_id = el.parent().data('id');
            }
        },
        'mouseup' : function(ev){
            var el = $(ev.target);
            if ( el.hasClass('link_a') && (ev.which == 1) || (ev.which == 2) ) {
                if ( (link_clicked_id > 0) && (el.parent().data('id') == link_clicked_id) ){
                    linkMarkWatched(link_clicked_id);
                }
            }
            link_clicked_id = 0;
        },
        'mouseover' : function(ev) {
            var el = $(ev.target);
            if (el.closest('.autosuggest_item')) {
                get_tags_list.find('.autosuggest_item').removeClass('cur');
                el.closest('.autosuggest_item').addClass('cur');
            }
        },
        'mouseout' : function(ev) {
            var el = $(ev.target);
            if (el.closest('.autosuggest_item')) {
                el.closest('.autosuggest_item').removeClass('cur');
            }
        },
        'keydown' : function(ev) {
            var el = $(ev.target);
            if (el.hasClass('tag_edit_name')) {
                if ( (ev.keyCode == 38) || (ev.keyCode == 40) ) {
                    if (get_tags_list.hasClass('h')) {
                        return false;
                    }
                    var tag_list = get_tags_list.find('.autosuggest_item');
                    var cur_tag  = get_tags_list.find('.autosuggest_item.cur');

                    if (cur_tag.size() == 0) {
                        tag_list.first().addClass('cur');
                        return true;
                    }
                    if ( (ev.keyCode == 38) && (cur_tag.prev().hasClass('autosuggest_item')) ) {
                        cur_tag.prev().addClass('cur');
                        cur_tag.removeClass('cur');
                    } else if ( (ev.keyCode == 40) && (cur_tag.next().hasClass('autosuggest_item')) ) {
                        cur_tag.next().addClass('cur');
                        cur_tag.removeClass('cur');
                    }
                    return true;
                }
            }
        },
        'keyup' : function(ev) {
            var el = $(ev.target);
            if (el.hasClass('tag_edit_name')) {
                if ( (el.parent().data('tag_type') == 'dummy') && (el.val().length > 1) ) {
                    var new_tag = el.parent().clone().attr('data-tag_type', 'normal');
                    el.parent().before(new_tag);
                    var tag_name = new_tag.find('.tag_edit_name');
                    tag_name.val(el.val()).focus();
                    tag_name[0].setSelectionRange(tag_name.val().length, tag_name.val().length);
                    el.val('');
                } else {
                    if ( (ev.keyCode == 38) || (ev.keyCode == 40) ) {
                        return false;
                    } else if (ev.keyCode == 13) {
                        if (get_tags_list.hasClass('h')) {
                            return false;
                        }
                        var cur_tag = get_tags_list.find('.autosuggest_item.cur');
                        if (cur_tag.size() == 0) {
                            return false;
                        }

                        el.val(cur_tag.data('name'));
                        get_tags_list.addClass('h');
                        return true;
                    }

                    linkGetTags(el);
                }
            } else if ( el.hasClass('link_edit_url') ) {
                linkFillTitle(el.closest('.link_edit'));
            }
        },
        'focusout' : function(ev) {
            var el = $(ev.target);
            if ( el.hasClass('tag_edit_name') && (el.parent().data('tag_type') == 'normal') && (el.val() == '') ) {
                el.parent().remove();
            }
        }
    });

    if (links.find('.link').size() <= 1) {
        linkEditOpen();
    }
}