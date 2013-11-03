<nav class="menu">
    <a class="menu_item{if:(sub_page:=links)} _cur{:fi}" href="{siteurl:}links/">ссылки</a>
    <a class="menu_item{if:(sub_page:=friends)} _cur{:fi}" href="{siteurl:}friends/">друзья</a>
    <a class="menu_item{if:(sub_page:=settings)} _cur{:fi}" href="{siteurl:}settings/">настройки</a>
</nav>

{if:(sub_page:=links)}{+profile/links:}{:fi}
{if:(sub_page:=friends)}{+profile/friends:}{:fi}
{if:(sub_page:=settings)}{+profile/settings:}{:fi}