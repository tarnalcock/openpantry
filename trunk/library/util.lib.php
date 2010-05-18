<?php

	/*	util.lib.php
		@richard pianka

		contains helper functions and general utilities	*/

	function is_ie() {
		if (isset($_SERVER['HTTP_USER_AGENT']) && 
		   (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
	        return true;
	    else
	        return false;
	}
	
	function get($index) {
		if (!isset($_GET[$index]))
			return '';
		return $_GET[$index];
	}
	
	function post($index) {
		if (!isset($_POST[$index]))
			return '';
		return $_POST[$index];
	}
	
	function get_ip() {
		return $_SERVER["REMOTE_ADDR"];
	}
	
	function make_seed() {
  		list($usec, $sec) = explode(' ', microtime());
  		return (float) $sec + ((float) $usec * 100000);
	}
	
	function redirect($url) {
		header("Location: ".$url);
		exit();
	}
	
	function send_mail($to, $subject, $message) {
		$to      = $to;
		$subject = $subject;
		$message = $message;
		$headers = 'From: no-reply@artxchange.com' . "\r\n" .
				   'Reply-To: no-reply@artxchange.com' . "\r\n";
				   
		mail($to, $subject, $message, $headers);
	}
	
	function convert_date($date) {
		$el = explode('/', $date);
		$month = $el[0];
		$day = $el[1];
		$year = $el[2];
		
		return $year . '-' . $month . '-' . $day;
	}
	
	function expand_get($parameters) {
		$i = 1;
		foreach($parameters as $parameter) {
			if (isset($_GET['v'.$i])) {
				global $$parameter;
				$$parameter = $_GET['v'.$i];
			}
			$i++;
		}
	}
	
	function clean_query($query) {
		if(get_magic_quotes_gpc())
			$query = stripslashes($query);
		if (phpversion() >= '4.3.0')
			$query = mysql_real_escape_string($query);
		else
			$query = mysql_escape_string($query);
		return $query;
	}
	
	function clean_url($string) {
		return str_replace(' ', '-', strtolower(preg_replace("/[^a-zA-Z0-9\s]/", "", $string)));
	}
	
	function build_inc($parent = ".") {
		$filelist = read_dir($parent."/include");

		for ($i = 0; $i < count($filelist); $i++) {
			if (!is_array($filelist[$i])) {
				require_once($filelist[$i]);
			}
		}
	}
	
	function build_lib($parent = ".") {
		$filelist = read_dir($parent."/library");

		for ($i = 0; $i < count($filelist); $i++) {
			if (!is_array($filelist[$i])) {
				require_once($filelist[$i]);
			}
		}
	}
	
	function build_css() {
		global $g;
		
		$filelist = read_dir("css");
		$css_include = "";
		for ($i = 0; $i < count($filelist); $i++) {
			if (!is_array($filelist[$i])) {
				$css_include .= "		<link rel=\"stylesheet\" type=\"text/css\" href=\"".$g["abs_url"]."/".$filelist[$i]."\">\n";
			}
		}
		
		return $css_include;
	}
	
	function build_js() {
		global $g;
		
		$filelist = read_dir("script");
		$js_include = "";
		for ($i = 0; $i < count($filelist); $i++) {
			if (!is_array($filelist[$i])) {
				$js_include .= "		<script language=\"javascript\" src=\"".$g["abs_url"]."/".$filelist[$i]."\"><!-- //--></script>\n";
			}
		}
		
		return $js_include;
	}
	
		function check_email_address($email) {
	  // First, we check that there's one @ symbol, 
	  // and that the lengths are right.
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters 
		// in one section or wrong number of @ symbols.
		return false;
	  }
	  // Split it into sections to make life easier
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++) {
		if
	(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
	?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
	$local_array[$i])) {
		  return false;
		}
	  }
	  // Check if domain is IP. If not, 
	  // it should be valid domain name
	  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
		  if
	(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
	?([A-Za-z0-9]+))$",
	$domain_array[$i])) {
			return false;
		  }
		}
	  }
	  return true;
	}
	
	function rand_str($size = 6,$feed = "abcdefghjkmnpqrstuvwxyz0123456789ABCDEFGHJKLMNPQRTUVWXYZ") {
		$rand_str = '';
		for ($i=0; $i < $size; $i++) {
			$rand_str .= substr($feed, rand() % strlen($feed), 1);
		}
		return $rand_str;
	}

?>