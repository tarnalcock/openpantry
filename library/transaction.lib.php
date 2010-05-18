<?php

function new_bag_transaction($clientid) {
	$client = get_family_by_id($clientid);
	$s = q("insert into transaction values('', '".clean_query($clientid)."', ".clean_query($client['delivery']).", CURDATE());");

	if (a() == 0) 
		return false;
	
	$id = i();
	$sources = get_all_bag_food_sources($client['bagid']);
	foreach ($sources as $source) {
		$s = q("insert into transaction_to_food_source values('".$id."', '".$source['sourceid']."', '".$source['weight']."', '".$source['price']."');");
	}
	
	if (a() == 0) {
		$s = q("delete from transaction where transaction.transactionid = '".clean_query($clientid)."' limit 1;");
		return false;
	}
	
	return true;
}

function new_dropoff_transaction() {
	$s = q("insert into transaction values('', NULL, '', CURDATE());");

	if (a() > 0) 
		return i();
	
	return false;
}

function new_dropoff_transaction_food_source($transid, $sourceid, $weight, $price) {
	$s = q("insert into transaction_to_food_source values('".$transid."', '".$sourceid."', '".$weight."', '".$price."');");

	if (a() > 0) 
		return true;
		
	return false;
}

?>