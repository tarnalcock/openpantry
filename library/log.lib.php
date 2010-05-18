<?php

	/*	transaction.lib.php
		@richardpianka
		
		handles all the transaction behavior	*/
	
	// in seconds
	define("register_time", 3600, true);
	define("login_time", 120, true);
	define("blog_time", 3600, true);
	define("comment_time", 120, true);
	define("auction_time", 3600, true);
	define("bid_time", 30, true);
	
	function do_log($action) {
		$s = q("insert into `log` values ('', '".clean_query(time())."', '".clean_query(get_ip())."', '".clean_query($action)."');");
	}
	
	function get_logs($action, $time) {
		$s = q("select uid from log where log.action = '".clean_query($action)."' and log.ip = '".clean_query(get_ip())."' and log.date > '".clean_query(time() - $time)."';");
		return n($s);
	}
	
	function can_register() {
		do_log('register');
		return get_logs('register', register_time) < 4;
	}
	
	function can_login() {
		do_log('login');
		return get_logs('login', login_time) < 6;
	}
	
	function can_blog() {
		do_log('blog');
		return get_logs('blog', blog_time) < 6;
	}
	
	function can_comment() {
		do_log('comment');
		return get_logs('comment', comment_time) < 6;
	}
	
	function can_auction() {
		do_log('auction');
		return get_logs('auction', auction_time) < 6;
	}
	
	function can_bid() {
		do_log('bid');
		return get_logs('bid', bid_time) < 6;
	}
	
?>