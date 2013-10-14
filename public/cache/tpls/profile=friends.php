<?php
echo '<div id="friends" class="friends">
    <p class="friend_search"><input id="search" class="wide" type="text" placeholder="Найти друга"></p>

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
echo '" class="friend_input" />
            <label class="friend" for="friend_';
if ( isset($friends_value['id']) ) {
echo $friends_value['id'];
}
echo '">
                <img class="friend_ava" src="';
if ( isset($friends_value['siteurl']) ) {
echo $friends_value['siteurl'];
}
echo 'include/avatar/';
if ( isset($friends_value['id']) ) {
echo $friends_value['id'];
}
echo '.png" />
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
</div>';
