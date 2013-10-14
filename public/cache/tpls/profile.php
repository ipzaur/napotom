<?php
echo '<nav class="menu">
    <a class="menu_item';
if (isset($this->tplvar['sub_page']) && ($this->tplvar['sub_page']=='links')) {echo ' cur';
}echo '" href="';
if ( isset($this->tplvar['siteurl']) ) {
echo $this->tplvar['siteurl'];
}
echo 'links/">ссылки</a>
    <a class="menu_item';
if (isset($this->tplvar['sub_page']) && ($this->tplvar['sub_page']=='friends')) {echo ' cur';
}echo '" href="';
if ( isset($this->tplvar['siteurl']) ) {
echo $this->tplvar['siteurl'];
}
echo 'friends/">друзья</a>
    <a class="menu_item';
if (isset($this->tplvar['sub_page']) && ($this->tplvar['sub_page']=='settings')) {echo ' cur';
}echo '" href="';
if ( isset($this->tplvar['siteurl']) ) {
echo $this->tplvar['siteurl'];
}
echo 'settings/">настройки</a>
</nav>

';
if (isset($this->tplvar['sub_page']) && ($this->tplvar['sub_page']=='links')) {echo '';
include '/var/www/napotom.me/current/public/cache/tpls/profile=links.php';echo '';
}echo '
';
if (isset($this->tplvar['sub_page']) && ($this->tplvar['sub_page']=='friends')) {echo '';
include '/var/www/napotom.me/current/public/cache/tpls/profile=friends.php';echo '';
}echo '
';
if (isset($this->tplvar['sub_page']) && ($this->tplvar['sub_page']=='settings')) {echo '';
include '/var/www/napotom.me/current/public/cache/tpls/profile=settings.php';echo '';
}echo '';
