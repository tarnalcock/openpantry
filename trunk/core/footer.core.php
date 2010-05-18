<?php

	/*	footer.core.php
		@richard pianka

		contains all the footer logic	*/
	
	global $render;
	
	$render["page_end"] = microtime();
	
	/*	build footer template	*/
	$vars["load_time"] = abs($render["page_end"] - $render["page_start"]);
	
	$page = new Template();
	//$page->load("footer");
	$page->set_vars($vars);
	$page->parse();
	
	$render["tier_3"] = $page->final;

?>