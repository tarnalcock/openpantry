<?php

	/*	food_source.lib.php
		@richard pianka
		@ramsey abouzahra
		
		contains functions to manipulate and retrieve from the food_source and aid database	*/

	function get_all_food_sources() {
		$s = q("SELECT * FROM food_source ORDER BY name ASC;");
		if(a() > 0)
			return rtoa($s);
	}
	
	function get_bag_food_sources($bagid) {
		$s = q("select food_source.*, bag_to_food_source.* from bag_to_food_source, food_source  where bag_to_food_source.bagid = '".clean_query($bagid)."' and food_source.sourceid = bag_to_food_source.sourceid");
		return rtoa($s);
	}

	function get_food_source_by_id($id) {
		$s = q("select * from food_source where sourceid = '".clean_query($id)."';");
		if(a() > 0)
			return f($s);
	}

	function create_food_source($name) {
		$s = q("insert into food_source values('', '".clean_query($name)."');");
		if(a() > 0)
			return i();
		return false;
	}

	function edit_food_source($id, $name) {
		$s = q("update food_source set name = '".clean_query($name)."' where sourceid = '".clean_query($id)."' limit 1");
		if(a() > 0)
			return true;
		return false;
	}
	
	function delete_food_source($id) {
		$s = q("delete from food_source where sourceid = '".clean_query($id)."' limit 1;");
		if(a() > 0)
			return true;
		return false;
	}
	
	function get_all_aids() {
		$s = q("SELECT * FROM aid ORDER BY name ASC;");
		return rtoa($s);
	}
	
	function get_aid_by_id($aidid) {
		$s = q("SELECT * FROM aid WHERE aidid = '".clean_query($aidid)."' limit 1;");
		if(a() > 0)
			return f($s);
	}
	
	function get_aid_by_name($name) {
		$s = q("SELECT * FROM aid WHERE name = '".clean_query($name)."' limit 1;");
		if(a() > 0)
			return f($s);
	}
	
	function get_family_aids($clientid) {
		$s = q("select aid.*, family_to_aid.amount from aid, family_to_aid  where family_to_aid.clientid = '".clean_query($clientid)."' and aid.aidid = family_to_aid.aidid");
		return rtoa($s);
	}
	
	function get_family_usda_aids($clientid) {
		$s = q("select * from aid LEFT OUTER JOIN (SELECT * FROM family_to_aid WHERE clientid='".clean_query($clientid)."') as family_to_aid ON family_to_aid.aidid = aid.aidid WHERE aid.usda_qualifier = '1' ORDER BY aid.name ASC");
		return rtoa($s);
	}
	
	function create_aid($name) {
		$s = q("insert into aid values('','".clean_query($name)."','0');");
		if(a() > 0)
			return i();
		return false;
	}
	
	function edit_aid($id, $name, $usda_qualifier) {
		$s = q("update aid set name = '".clean_query($name)."', usda_qualifier='".clean_query($usda_qualifier)."' where aidid = '".clean_query($id)."' limit 1");
		if(a() > 0)
			return true;
		return false;
	}
	
	function delete_aid($id) {
		$s = q("delete from aid where aidid = '".clean_query($id)."' limit 1;");
		if(a() > 0)
			return true;
		return false;
	}
?>