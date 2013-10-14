<?php
$debug = true;

mb_language("ru");
mb_internal_encoding("UTF-8");
require_once '../config.php';
require_once 'iface/iface.core.php';
$engine = new iface_core();

if ( ($debug == false) && (file_exists('js/napotom.js')) ) {
    echo file_get_contents('js/napotom.js');
    die();
}

$js_files = scandir('js/');
$napotom_js = fopen('js/napotom.js', 'w');
fwrite($napotom_js, "window.setTimeout(function(){");
fwrite($napotom_js, "var SITEURI = '" . $engine->siteurl . "';");
foreach ($js_files AS $file) {
    if ( (mb_strpos($file, '.js') > 0) && ($file != 'napotom.js') ) {
        fwrite($napotom_js,  file_get_contents('js/' . $file) . "\n");
    }
}
fwrite($napotom_js, "},1);");
fclose($napotom_js);
echo file_get_contents('js/napotom.js');
die();