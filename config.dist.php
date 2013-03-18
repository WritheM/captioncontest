<?php

//=========================
// Config you must change
//=========================
define('DB_TYPE', 'mysql');
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');
define('DB_PCONNECT', false);

//==========================
// Automatically generating directory information, change only if you know what you're doing
//==========================
$www_top = str_replace("\\","/",dirname( $_SERVER['PHP_SELF'] ));
if(strlen($www_top) == 1)
	$www_top = "";

//
// used everywhere an href is output, includes the full path to the cc install
//
define('WWW_TOP', $www_top);

//
// used to refer to the /lib class files
//
define('WWW_DIR', realpath(dirname(__FILE__)).'/');

//
// path to smarty files
//
define('SMARTY_DIR', WWW_DIR.'lib/smarty/');

