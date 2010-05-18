<?php

	/*	file_system.lib.php
		@richard pianka

		contains functions dealing with the file system, duh	*/

	global $g;

	function read_dir($dir) {
		$array = array();
	   	$d = dir($dir);
   		while (false !== ($entry = $d->read())) {
       		//if($entry!='.' && $entry!='..') {
			if (substr($entry, 0, 1) != '.') {
           		$entry = $dir.'/'.$entry;
           		if(is_dir($entry)) {
               		$array[] = $entry;
               		$array = array_merge($array, read_dir($entry));
           		} else {
               		$array[] = $entry;
           		}
       		}
   		}
   		$d->close();
   		return $array;
	}

?>