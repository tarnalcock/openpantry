<?php

	/*	client.lib.php
		@richard pianka
		
		contains functions to manipulate and retrieve from the client database	*/
	
	function get_all_financial_aids() {
		$s = q("select * from aid order by aid.name asc;");
		return rtoa($s);
	}
	
	function get_all_financial_aids_client($clientid) {
		$s = q("select * from aid left outer join (select * from family_to_aid where family_to_aid.clientid = '".clean_query($clientid)."') rel on aid.aidid = rel.aidid;");
		return rtoa($s);
	}
	
	function clear_financial_aids($clientid) {
		$s = q("delete from family_to_aid where family_to_aid.clientid = '".clean_query($clientid)."';");
	}
	
	function set_financial_aid($clientid, $aidid, $amount) {
		$s = q("insert into family_to_aid values('".clean_query($clientid)."', '".clean_query($aidid)."', '".clean_query($amount)."');");
		
		if (a() > 0)
			return true;
		
		return false;
	}
	
?>