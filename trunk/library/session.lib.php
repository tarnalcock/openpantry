<?php

	/*	session.lib.php
		@richard pianka

		contains all session logic	*/
		
	/* stores session statistics */
	class session_stats {
		var $total_users;
		var $logged_in_users;
		var $guest_users;
		var $user_list;
		
		function session_stats() {
			$this->user_list = array();
			$this->total_users = 0;
			$this->logged_in_users = 0;
			$this->guest_users = 0;
		}
	}
	
	/* someone is hijacking us, fuck them up */
	/*function handle_hijacking() {
		$unban = time() + (60*60*12); // twelve hour ip ban
		// ban user by ip
		ban_ip($_SERVER['REMOTE_ADDR'], 0, $unban, "[automatic] session hijack detected");
	}*/
	
	/* builds session statistics into object */
	/*function get_session_stats() {
		$stats = new session_stats;
		$s = q("select userid from `vb_session`;");
		while ($r = f($s)) {
			$stats->total_users++;
			if ($r["userid"] > 0) {
				$stats->logged_in_users++;
				array_push($stats->user_list, get_user_entry_by_id($r["userid"]));
			} else {
				$stats->guest_users++;
			}
		}
		return $stats;
	}*/
	
	/* clean sessions (allowed for 15 minutes) */
	function clean_session_db() {
		$s = q("delete from `session` where `activity` < '".(time() - 60*15)."'");
	}
		
	/* initiate sessions and assert entry in table session */
	function start_session_tracking() {
		session_start();
		return true;
		
		clean_session_db();
		
		error_reporting(E_ALL);
		
		$sessionhash = md5(get_session_id());
		$idhash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
		
		// see: mysql.lib.php
		$s = q("select * from `session` where `hash` = '".clean_query($sessionhash)."' limit 1;");
		if (n($s) == 0) {
			$s = q("insert into `session` values('', '0', '".clean_query($sessionhash)."', '".clean_query($idhash)."', '".clean_query(time())."');");

			if (a() == 1) {
				// success
				return true;
			} else {
				// failure
				return false;
			}
		} else {
			while ($r = f($s)) {
			//4c5b06225553e12bed914e6836ff4859
				if ($r["identity"] != $idhash) {
					return false;
				}
			
				$s = q("update `session` set `activity` = '".clean_query(time())."' where `hash` = '".clean_query($sessionhash)."' limit 1;");
				return true;
				
				/*if (a() == 1) {
					// success
					return true;
				} else {
					// failure
					return false;
				}*/
			}
		}

		return false;
	}
	
	/*function update_location() {
		$s = q("update `vb_session` set `location` = '".clean_query($_SERVER['REQUEST_URI'])."' where `sessionhash` = '".clean_query(get_session_hash())."' limit 1;");
	}*/
	
	/* set session variable */
	function set_session($field, $value) {
		$_SESSION[$field] = $value;
	}
	
	/* return session variable */
	function get_session($field) {
		if (!isset($_SESSION[$field])) {
			return '';
		}
		return $_SESSION[$field];
	}
	
	/* return php session id */
	function get_session_id() {
		return session_id();
	}
	
?>