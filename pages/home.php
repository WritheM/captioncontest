<?php


$page->smarty->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');
$page->meta_title = "Home";
$page->meta_keywords = "Home";
$page->meta_description = "Home";
$page->content = $page->smarty->fetch('home.tpl');
$page->render();