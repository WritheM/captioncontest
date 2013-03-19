<?php
require_once(WWW_DIR."/lib/contest.php");

$contest = new Contest();

$page->smarty->assign('contest', $contest->loadCurrent());

$page->smarty->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');
$page->title = "Home";
$page->meta_title = "Home";
$page->meta_keywords = "Home";
$page->meta_description = "Home";
$page->content = $page->smarty->fetch('home.tpl');
$page->render();