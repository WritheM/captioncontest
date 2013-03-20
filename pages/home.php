<?php
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/contest.php");

$db = new DB();
$cm = new ContestManager($db);
$contest = array(
    'current' => $cm->loadCurrent(),
    'previous' => $cm->loadPrevious()
);

$page->smarty->assign('contest', $contest);

$page->smarty->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');
$page->title = "Home";
$page->meta_title = "Home";
$page->meta_keywords = "Home";
$page->meta_description = "Home";
$page->content = $page->smarty->fetch('home.tpl');
$page->render();