<?php
defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER') ? null : define ("DB_USER", "root") ;
defined('DB_PASS') ? null : define("DB_PASS","");
defined('DB_NAME') ? null : define("DB_NAME", "alumni_db") ;

$this_file = str_replace('\\', '/', __File__) ;
$doc_root = $_SERVER['DOCUMENT_ROOT'];

$webRoot =  str_replace (array($doc_root, "include/config.php") , '' , $this_file);
$srvRoot = str_replace ('config/config.php' ,'', $this_file);


define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
?>
