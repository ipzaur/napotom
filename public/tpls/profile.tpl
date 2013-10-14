<nav class="menu">
    <a class="menu_item{if:(sub_page:=links)} cur{:fi}" href="{siteurl:}links/">ссылки</a>
    <a class="menu_item{if:(sub_page:=friends)} cur{:fi}" href="{siteurl:}friends/">друзья</a>
    <a class="menu_item{if:(sub_page:=settings)} cur{:fi}" href="{siteurl:}settings/">настройки</a>
</nav>

{if:(sub_page:=links)}{+profile/links:}{:fi}
{if:(sub_page:=friends)}{+profile/friends:}{:fi}
{if:(sub_page:=settings)}{+profile/settings:}{:fi}