<?php
define('ROOT',str_replace("\\",'/',dirname(__FILE__)));
define('PATH', ROOT == $_SERVER['DOCUMENT_ROOT']
    ?'' :substr(ROOT,strlen($_SERVER['DOCUMENT_ROOT']))
);
?>
