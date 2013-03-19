<?php
require_once(WWW_DIR."/lib/contest.php");

$current = new Contest();
$previous = new Contest();
$contest = array(
    'current' => $current->loadCurrent(),
    'previous' => $previous->loadPrevious()
);

$page->smarty->assign('contest', $contest);

$page->smarty->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');
$page->title = "Home";
$page->meta_title = "Home";
$page->meta_keywords = "Home";
$page->meta_description = "Home";
$page->content = $page->smarty->fetch('home.tpl');
$page->render();