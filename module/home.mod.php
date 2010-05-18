<?php

	/*	home.mod.php
		@richard pianka
		
		http://localhost/pantry/home/

		contains the home page	*/
		
	if (!is_access(access_home) && !is_access(access_all)) {
		redirect('/pantry/error/no_access');
	}
	
	global $render;
	global $module_commands;
	
	$parameters = array();
	expand_get($parameters);
	
	$home_framework = new Template();
	$home_framework->load('home_framework');
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $home_framework_render;
		global $home_framework;
		global $render;
		
		$home_framework->set_vars($home_framework_render);
		$home_framework->parse();
		$render['tier_2'] = $home_framework->final;
	}
	
	render_all();
	
?>