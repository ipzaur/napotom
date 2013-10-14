<?php
echo '<form class="settings" method="post" action="';
if ( isset($this->tplvar['siteurl']) ) {
echo $this->tplvar['siteurl'];
}
echo 'settings/" enctype="multipart/form-data">
    <p class="setting"><label for="user_name" class="setting_label">Ваше имя</label><input id="user_name" class="setting_input" type="text" name="name" value="';
if ( isset($this->tplvar['name']) ) {
echo $this->tplvar['name'];
}
echo '" /></p>
    <p class="setting"><label for="user_avatar" class="setting_label">Ваша аватарка</label><input id="user_avatar" name="avatar" type="file" /><br /><img class="setting_avatar" src="';
if ( isset($this->tplvar['siteurl']) ) {
echo $this->tplvar['siteurl'];
}
echo '';
if ( isset($this->tplvar['avatar']) ) {
echo $this->tplvar['avatar'];
}
echo '" /></p>

    <p class="setting"><label for="user_pass1" class="setting_label">Сменить пароль</label><input id="user_pass1" class="setting_input" type="password" name="pass1" value="" /></p>
    <p class="setting"><label for="user_pass2" class="setting_label">Повторить пароль</label><input id="user_pass2" class="setting_input" type="password" name="pass2" value="" /></p>
    <p class="setting"><button type="submit" class="settings_save">Сохранить</button></p>
</form>';
