var auth_self = $('#auth_self');
if (auth_self.size() > 0) {
    var auth_self_type = 0;
    auth_self.bind('click', function(e){
        e = $(e.target);
        if ( e.data('auth_action') && (e.data('auth_action') == 'self') ) {
            e.prev().toggleClass('auth_fields-hidden');
        } else if (e.hasClass('link_fake')) {
            if (auth_self_type == 0) {
                auth_self.find('#auth_stars').addClass('h');
                e.next().text('восстановить');
                e.text('вспомнили?');
                auth_self_type = 1;
            } else {
                auth_self.find('#auth_stars').removeClass('h');
                e.next().text('войти');
                e.text('забыли пароль?');
                auth_self_type = 0;
            }
        } else if (e.attr('id') == 'auth_self_submit') {
            if (auth_self_type == 0) {
                auth_self[0].submit();
            }
        }
    });
}