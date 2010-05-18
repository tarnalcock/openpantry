<?php

	/*	template.lib.php
		@richard pianka

		contains the template manager	*/

	global $g;
		
	class Template {
	
		var $html;
		var $variables;
		var $final;
		
		function Template() {
			$this->html = "";
			$this->variables = array();
			$this->final = "";
		}

		function load($file) {
			ob_start();
			include('template/'.$file.'.tmp.php');
			$this->html = ob_get_contents();
			ob_end_clean();
		}

		function set_vars($vars) {
			global $g;
			$vars["ABSURL"] = $g["abs_url"];
			$this->variables = $vars;
		}

		function parse() {
			$this->final = $this->html;

			foreach ($this->variables as $name => $value) {
				$this->final = str_replace("<%%".$name."%%>", $value, $this->final);
			}

			return $this->final;
		}

	}

?>