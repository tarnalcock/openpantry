<?php

	/*	index.php
		@richard pianka

		checks for a specified module and if it exists, it's displayed,
		otherwise displays default welcome page	*/

	/* 	show all errors	*/
	error_reporting(6143); // E_ALL

	/*	include mandatory pre-load libraries	*/
    require_once('library/file_system.lib.php');
    require_once('library/util.lib.php');

	build_inc();
	build_lib();
	
	$css_include = build_css();
	$js_include = build_js();
	
	sql_wrap();
	if (!start_session_tracking()) {
		echo 'Your identity is suspect.  Please restart your browser and login before returning to this page.';
		return;
	}

	if (!isset($_GET['mod'])) $_GET['mod'] = 'login';

	global $render;
	
	$render['css_include'] = $css_include;
	$render['js_include'] = $js_include;

	require_once('core/body.core.php');
	require_once('core/header.core.php');
	require_once('core/footer.core.php');
	
	$page = new Template();
	$page->load('framework');
	$page->set_vars($render);
	$page->parse();
	
	echo $page->final;

?>