<?php

	/*	inventory.lib.php
		@richard pianka
		@ramsey abouzahra
		
		contains functions to manipulate and retrieve from the inventory database	*/
	
	function get_all_products() {
		$s = q("select * from product order by name;");
		return rtoa($s);
	}
	
	function get_product_by_id($productid) {
		$s = q("select * from product where productid = '".clean_query($productid)."' limit 1;");
		if(n($s) > 0)
			return f($s);
		return false;
	}
	
	function get_product_by_name($name)
	{
		$s = q("select * from product where name = '".clean_query($name)."' limit 1;");
		if(a($s) > 0)
			return f($s);
		return false;
	}
	
	function create_product($name, $quantity) {
		$s = q("insert into product values('', '".$name."', '".$quantity."');");
		if(a() > 0)
			return i();
		return false;
	}
	
	function edit_product($productid, $name, $quantity) {
		$s = q("UPDATE product SET name = '".clean_query($name)."', quantity = '".clean_query($quantity)."' WHERE productid = '".clean_query($productid)."';");
		if(a() > 0)
			return true;
		return false;
	}
	
	function delete_product($productid) {
		$s = q("delete from product where productid = '".clean_query($productid)."' limit 1;");
		$a = a();
		$s = q("delete from bag_to_product where productid = '".clean_query($productid)."' limit 1;");
		if($a > 0 || a() > 0)
			return true;
		return false;
	}
?>