<div id="friends" class="friends">
    <p class="friend_search"><input id="search" class="wide" type="text" placeholder="Найти друга"></p>

    <div>
        {friends:}
            <input id="friend_{id:}" type="checkbox" name="friend[]" value="{id:}" class="friend_input" />
            <label class="friend" for="friend_{id:}">
                <img class="friend_ava" src="{siteurl:}include/avatar/{id:}.png" />
                <p class="friend_name">{name:}</p>
            </label>
        {:friends}
    </div>
</div>