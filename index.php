<?php
require_once("config.php");
require('lib/smarty/Smarty.class.php');

$smarty = new Smarty;

//$smarty->force_compile = true;
//$smarty->debugging = true;

require_once(WWW_DIR."/lib/page.php");
$page = new Page;

switch($page->page) {
	case 'index':
	case 'home':
		include(WWW_DIR.'pages/'.$page->page.'.php');
	break;
	default:
		$page->show404();
	break;
}
