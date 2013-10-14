<article>
    <div class="menu-intro">
        <form class="auth_form" method="post" action="{siteurl:}auth/">
            <input type="hidden" name="auth_type" value="vk" />
            <button class="auth_but-vk" title="Авторизация с помощью контакта" type="submit"></button>
        </form>
        <form class="auth_form" method="post" action="{siteurl:}auth/">
            <input type="hidden" name="auth_type" value="fb" />
            <button class="auth_but-fb" title="Авторизация с помощью facebook" type="submit"></button>
        </form>
        <form id="auth_self" class="auth_form" method="post" action="{siteurl:}auth/">
            <input type="hidden" name="auth_type" value="self" />
            <div class="auth_fields auth_fields-hidden">
                <input id="auth_email" class="auth_field" name="email" value="" type="email" placeholder="e-mail" />
                <input id="auth_stars" class="auth_field" name="stars" value="" type="password" placeholder="пароль" />
                <p class="auth_send"><span class="link_fake">забыли пароль?</span> <button id="auth_self_submit" type="button">войти</button></p>
            </div>
            <button class="auth_but-self" title="Авторизация с помощью напотом" type="button" data-auth_action="self"></button>
        </form>
    </div>

    <div class="intros">
        <div class="intro">
            <div class="intro_pic-timer"></div>
            <p class="intro_title">Некогда посмотреть ссылку?</p>
            <p class="intro_text">Оставьте её <b>на потом</b>. И ничего, если Вы забудете про неё - мы напомним о ней в удобное для Вас время.</p>
        </div>
        <div class="intro">
            <div class="intro_pic-storage"></div>
            <p class="intro_title">Понравилась ссылка и хотите сохранить её?</p>
            <p class="intro_text">Добавьте ей тэги и Вы всегда сможете быстро найти её.</p>
        </div>
        <div class="intro">
            <div class="intro_pic-share"></div>
            <p class="intro_title">Захотелось поделиться интересной ссылкой?</p>
            <p class="intro_text">Просто отправьте её друзьям, и они смогут <b>потом</b> её посмотреть.</p>
        </div>
    </div>
</article>