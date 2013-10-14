<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Оставьте ссылку на потом! Храните ссылки, обменивайтесь ими.</title>
    <meta charset="utf-8">
    <meta content="IE=9" http-equiv="X-UA-Compatible">
    <meta content="Персональное хранилище ссылок" name="description">
    <meta content="ссылки, ссылка, оставить, отложить, хранение, обмен, метки, тэги" name="keywords">
    <link href="{siteurl:}css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"></script>
</head>
<body>
    <div class="mainblock">
        <header>
            {if:(main_page:=profile)}
                <form class="auth_form-out" method="post" action="{siteurl:}auth/">
                    <input type="hidden" name="auth_type" value="out" />
                    <button title="Выход" type="submit">Выход</button>
                </form>
            {:fi}
            <div class="h_logo"></div>
            <h1 class="h_h1">
                <span class="h_title">оставьте ссылку</span>
                <a class="h_link" href="{siteurl:}" ref="nofollow">НАПОТОМ</a>
            </h1>
        </header>
        {if:(main_page:=intro)}{+intro:}{:fi}
        {if:(main_page:=profile)}{+profile:}{:fi}
        <footer>
        </footer>
    </div>
    <script type="text/javascript" src="/js/napotom.js" defer="defer"></script>
</body>