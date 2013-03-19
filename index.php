<?php
require_once("config.php");
require_once(WWW_DIR."/lib/page.php");

$page = new Page();

if (!defined('DEBUG')) {
    define('DEBUG', false);
}
$page->smarty->debugging = DEBUG;

switch($page->page) {
	case 'index':
	case 'home':
		include(WWW_DIR.'pages/'.$page->page.'.php');
	break;
	default:
		$page->show404();
	break;
}