<?php

	/*	header.core.php
		@richard pianka

		contains all the header logic	*/
	
	global $render;
	$render["page_start"] = microtime();
	$render["page_title"] = "Pantry IQP";
	
	/*	build tab strip 	*/
	//$tab_strip = build_tabs();
	
	/*	build header template	*/
	$vars["place_holder"] = "empty";
	
	$access = 0;
	$temp = get_session('user');
	$user_entry = (strlen($temp) > 0 ? unserialize($temp) : null);
	if ($user_entry != null) {
		$access = $user_entry['access'];
	}
	
	$page = new Template();
	if ($access > 0 && strtolower(get('mod')) != 'login')
		$page->load("header_menu");
	$page->set_vars($vars);
	$page->parse();
	
	$render["tier_1"] = $page->final;

?>