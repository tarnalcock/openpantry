<?php

	/*	mysql.lib.php
		@richard pianka

		contains mysql functions	*/

	global $g;

	function sql_connect() {
		global $g;

		$sql_server = $g["sql"]["server"];
		$sql_username = $g["sql"]["username"];
		$sql_password = $g["sql"]["password"];

		if(!($sql_link = mysql_pconnect($sql_server, $sql_username, $sql_password))) die(mysql_error());

		return $sql_link;

	}

	function sql_select() {
		global $g;

		$sql_database = $g["sql"]["database"];

		if(!($result = mysql_select_db($sql_database))) die(mysql_error());

		return $result;

	}


	function sql_select_d($db) {
		global $g;

		$sql_database = $db;

		if(!($result = mysql_select_db($sql_database))) die(mysql_error());

		return $result;

	}

	function sql_wrap() {
		global $g;
		//if ($g["sql"]["connected"] == "true") return;
		//$g["sql"]["connected"] = "true";

		sql_connect();
		sql_select();

		return 0;

	}

	function sql_query($query) {

		$result = mysql_query($query);

		global $sqlQueryCount;

		if (isset($sqlQueryCount) == TRUE) {
			$sqlQueryCount++;
		} else {
			$sqlQueryCount = 0;
			$sqlQueryCount++;
		}

		return $result;

	}

	function sql_table_exists($table) {

		$result = mysql_query("select 1 from $table limit 0;");

		if ($result) {
			return true;
		} else {
			return false;
		}

	}
	
	function sql_result_to_array($mysqlresult) {
		$entries = Array(); $i = 0;
		while ($r = f($mysqlresult)) {
			$entries[$i] = $r;
			$i++;
		}
		return $entries;
	}

	/*	Quick Functions	*/

	function rtoa($result) { return sql_result_to_array($result); }
	function q($query) { return sql_query($query); }
	function f($sql) { return mysql_fetch_array($sql); }
	function n($sql) {
		if ($sql == false)
			return 0;
			
		return mysql_num_rows($sql);
	}
	function a() { return mysql_affected_rows(); }
	function i() { return mysql_insert_id(); }

?>