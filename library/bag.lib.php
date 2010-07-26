<?php

	/*	bag.lib.php
		@richard pianka
		@ramsey abouzahra
		
		contains functions to manipulate and retrieve from the bag database	*/
	
	function get_all_bags() {
		$s = q("select * from bag order by bag.bagid asc;");
		return rtoa($s);
	}
	
	function get_bag_contents($bagid) {
		$s = q("SELECT bp.productid, product.name, bp.quantity, bp.choice, bp.notes FROM bag LEFT JOIN bag_to_product as bp ON bag.bagid = bp.bagid LEFT JOIN product ON product.productid = bp.productid WHERE bp.bagid = '".clean_query($bagid)."' order by choice asc, name asc;");
		return rtoa($s);
	}
	
	function get_all_bag_food_sources($bagid) {
		$s = q("select * from food_source left outer join (select * from bag_to_food_source where bag_to_food_source.bagid = '".clean_query($bagid)."') rel on food_source.sourceid = rel.sourceid;");
		return rtoa($s);
	}
	
	function get_bag_clients($bagid) {
		$s = q("SELECT * FROM family WHERE bagid = '".clean_query($bagid)."';");
		return rtoa($s);
	}
	
	function get_bag_transactions($bagid, $start_date, $end_date) {
		$s = q("SELECT * FROM transaction as t LEFT JOIN family as f ON t.clientid = f.clientid WHERE t.clientid IS NOT NULL AND f.bagid = '".clean_query($bagid)."' AND t.date >= '".clean_query($start_date)."' AND t.date <= '".clean_query($end_date)."';");
		return rtoa($s);
	}
	
	function edit_bag_food_source($bagid, $sourceid, $weight, $price) {
		$s = q("UPDATE bag_to_food_source SET weight ='".clean_query($weight)."', price = '".clean_query($price)."' WHERE bagid = '".clean_query($bagid)."' AND sourceid = '".clean_query($sourceid)."';"); 
		if(a() > 0)
			return true;
		return create_bag_food_source($bagid, $sourceid, $weight, $price);
	}
	
	function create_bag_food_source($bagid, $sourceid, $weight, $price) {
		$s = q("INSERT INTO bag_to_food_source VALUES('".clean_query($sourceid)."', '".clean_query($bagid)."', '".clean_query($weight)."', '".clean_query($price)."');"); 
		if(a() > 0)
			return true;
		return false;
	}
		
	function get_bag_by_id($bagid) {
		$s = q("select * from bag where bag.bagid = '".clean_query($bagid)."';");
		if(n($s) > 0)
			return f($s);
		return false;
	}
	
	function get_bag_by_name($name) {
		$s = q("select * from bag where bag.name = '".clean_query($name)."';");
		if(n($s) > 0)
			return f($s);
		return false;
	}
		
	function create_bag($name, $source_bagid) {
		$s = q("insert into bag values('', '".clean_query($name)."')");
		if (a() == 0)
			return false;
		
		$bagid = i();

		if($source_bagid != 'none') {
			copy_bag_contents($source_bagid, $bagid);
		}
		return $bagid;
	}
	
	function copy_bag_contents($srcbid, $destbid) {
		$s = q("INSERT INTO bag_to_food_source (sourceid, bagid, weight, price) (SELECT sourceid, '".$destbid."', weight, price FROM bag_to_food_source WHERE bagid = '".$srcbid."')");
		$s = q("INSERT INTO bag_to_product (bagid, productid, quantity, choice, notes) (SELECT '".$destbid."', productid, quantity, choice, notes FROM bag_to_product WHERE bagid = '".$srcbid."')");
	}
	
	function edit_bag($bagid, $name) {
		$s = q("update bag set bag.name = '".clean_query($name)."' where bag.bagid = '".clean_query($bagid)."' limit 1;");
		if (a() > 0)
			return true;
			
		return false;
	}
	
	function delete_bag($bagid){
		$s = q("delete from bag where bag.bagid = '".clean_query($bagid)."' limit 1;");
		if(a() > 0)
			return true;
		return false;
	}
	
	function create_bag_content($bagid, $productid, $quantity, $choice, $notes) {
		$s = q("insert into bag_to_product values('".clean_query($bagid)."', '".clean_query($productid)."', '".clean_query($quantity)."', '".clean_query($choice)."', '".clean_query($notes)."');");
		if (a() > 0)
			return true;
		
		return false;
	}
	
	function edit_bag_content($bagid, $productid, $quantity, $choice, $notes) {
		$s = q("update bag_to_product set quantity = '".clean_query($quantity)."', choice = '".clean_query($choice)."', notes = '".clean_query($notes)."' WHERE bagid = '".clean_query($bagid)."' and productid ='".clean_query($productid)."' LIMIT 1;");
		if (a() > 0)
			return true;
		return false;
	}
	
	function delete_bag_content($bagid, $productid) {
		$s = q("delete from bag_to_product where bagid = '".clean_query($bagid)."' and productid = '".clean_query($productid)."' limit 1;");
		if (a() > 0)
			return true;
			
		return false;
	}
	
	
	/** import bag information from csv version of the excel bag contents
	  */
	  
	function import_bag_content($bagid, $name, $quantity, $notes) {
		
		// Create product in inventory
		$productid = create_product($name, '');
		if(!$productid) {
			$product = get_product_by_name($name);
			$productid = $product['productid'];
		}
		echo "bag: ".$bagid." product: ".$productid." <br/>";
		create_bag_content($bagid, $productid, $quantity, '0', $notes);
	}
?>