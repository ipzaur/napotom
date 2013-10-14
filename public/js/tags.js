var tags = $('#tags');
if (tags.size() > 0) {
    /*
     * Поиск тэгов
     */
    function tagsSearch(tag_name)
    {
        if (tag_name == '') {
            tags.find('[data-tag]').removeClass('h');
            return true;
        }
        tags.find('[data-tag]').addClass('h');
        tags.find('[data-tag*="' + tag_name + '"]').removeClass('h');
    }

    tags.bind({
        'keyup' : function(ev) {
            var el = $(ev.target);
            if (el.attr('id') == 'search') {
                tagsSearch(el.val());
            }
        }
    });
}