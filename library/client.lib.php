<?php

	/*	client.lib.php
		@richard pianka
		
		contains functions to manipulate and retrieve from the client database	*/
	
	function get_all_families() {
		$s = q("select * from family, client where client.clientid = family.clientid order by family.active desc, client.last_name asc;");
		return rtoa($s);
	}

	function get_active_families() {
		$s = q("select * from family, client where client.clientid = family.clientid and family.active = '1' order by family.active desc, client.last_name asc;");
		return rtoa($s);
	}
	
	function get_all_adults($clientid) {
		$min_dob = mktime(0, 0, 0, date('m'), date('d'), date('Y')-64);
		$max_dob = mktime(0, 0, 0, date('m'), date('d'), date('Y')-18);
		$min_dob = date('Y-m-d', $min_dob);
		$max_dob = date('Y-m-d', $max_dob);
		$s = q("select * from client where client.familyid = '".clean_query($clientid)."' AND dob >= '".clean_query($min_dob)."' AND dob <= '".clean_query($max_dob)."' order by client.first_name asc;");
		return rtoa($s);
	}
	
	function get_all_seniors($clientid) {
		$max_dob = mktime(0, 0, 0, date('m'), date('d'), date('Y')-65);
		$max_dob = date('Y-m-d', $max_dob);
		$s = q("select * from client where client.familyid = '".clean_query($clientid)."' AND dob <= '".clean_query($max_dob)."' order by client.first_name asc;");
		return rtoa($s);
	}
	
	function get_all_children($clientid) {
		$min_dob = mktime(0, 0, 0, date('m'), date('d'), date('Y')-17);
		$min_dob = date('Y-m-d', $min_dob);
		$s = q("select * from client where client.familyid = '".clean_query($clientid)."' AND dob >= '".clean_query($min_dob)."' order by client.first_name asc;");
		return rtoa($s);
	}
	
	function get_client_transactions($clientid) {
		$s = q("SELECT * FROM transaction WHERE clientid = '".clean_query($clientid)."' ORDER BY date DESC;");
		return rtoa($s);
	}
	
	function get_all_client_transactions($start_date, $end_date) {
		$s = q("SELECT * FROM transaction as t LEFT JOIN family as f ON t.clientid = f.clientid WHERE t.clientid IS NOT NULL AND t.date >= '".clean_query($start_date)."' AND t.date <= '".clean_query($end_date)."';");
		return rtoa($s);
	}
	
	function get_pickup_transactions($start_date, $end_date) {
		$s = q("SELECT * FROM transaction as t LEFT JOIN family as f ON t.clientid = f.clientid WHERE t.clientid IS NOT NULL AND t.delivery='0' AND t.date >= '".clean_query($start_date)."' AND t.date <= '".clean_query($end_date)."';");
		return rtoa($s);
	}
	
	function get_delivery_transactions($start_date, $end_date) {
		$s = q("SELECT * FROM transaction as t LEFT JOIN family as f ON t.clientid = f.clientid WHERE t.clientid IS NOT NULL AND t.delivery ='1' AND t.date >= '".clean_query($start_date)."' AND t.date <= '".clean_query($end_date)."';");
		return rtoa($s);
	}
	
	function get_pickup_families() {
		$s = q("select * from family, client where client.clientid = family.clientid and family.active = '1' and family.delivery = '0' order by family.active desc, client.last_name asc;");
		return rtoa($s);
	}
	
	function get_delivery_families() {
		$s = q("select * from family, client where client.clientid = family.clientid and family.active = '1' and family.delivery = '1' order by family.active desc, client.last_name asc;");
		return rtoa($s);
	}
	
	function get_all_family_members($clientid) {
		$s = q("select * from client where client.familyid = '".clean_query($clientid)."' order by client.first_name asc;");
		return rtoa($s);
	}
	
	function get_family_by_id($clientid) {
		$s = q("select * from family, client where client.clientid = family.clientid and family.clientid = '".clean_query($clientid)."';");
		if (n($s) > 0)
			return f($s);
		
		return null;
	}
	
	function create_family($clientid, $bagid, $address, $telephone, $fuel, $usda, $delivery, $dietary, $second, $fourth, $cooking, $start, $comments) {
		$s = q("insert into family values('".clean_query($clientid)."', '".clean_query($bagid)."', '1', '".clean_query($address)."', '".clean_query($telephone)."', '".($fuel ? '1' : '0')."', '".($usda ? '1' : '0')."', '".($delivery ? '1' : '0')."', '".($dietary ? '1' : '0')."', '".($second ? '1' : '0')."', '".($fourth ? '1' : '0')."', '".($cooking ? '1' : '0')."', '".clean_query($start)."', '".clean_query($comments)."');");
		if (a() > 0)
			return $clientid;
			
		return false;
	}
	
	function edit_family($clientid, $bagid, $active, $address, $telephone, $fuel, $usda, $delivery, $dietary, $second, $fourth, $cooking, $start, $comments) {
		$s = q("update family set family.bagid = '".clean_query($bagid)."', family.active = '".($active ? '1' : '0')."', family.address = '".clean_query($address)."', family.telephone = '".clean_query($telephone)."', family.fuel_assistance = '".($fuel ? '1' : '0')."', family.usda_assistance = '".($usda ? '1' : '0')."', family.delivery = '".($delivery ? '1' : '0')."', family.dietary = '".($dietary ? '1' : '0')."', family.pickup_second = '".($second ? '1' : '0')."', family.pickup_fourth = '".($fourth ? '1' : '0')."', family.cooking_facilities = '".($cooking ? '1' : '0')."', family.start_date = '".clean_query($start)."', family.comments = '".clean_query($comments)."' where family.clientid = '".clean_query($clientid)."' limit 1;");
		if (a() > 0)
			return true;
			
		return false;
	}
	
	function create_client($familyid, $first, $last, $gender, $dob) {
		$family_str = "'".$familyid."'";
		if ($familyid == null)
			$family_str = 'NULL';
		
		$s = q("insert into client values('', ".$family_str.", '".clean_query($first)."', '".clean_query($last)."', '".clean_query($gender)."', '".clean_query($dob)."')");
		if (a() > 0)
			return i();
		
		return false;
	}
	
	function delete_client($clientid) {
		$s = q("delete from client where client.clientid = '".clean_query($clientid)."' and client.familyid is not null limit 1;");
		if (a() > 0)
			return true;
			
		return false;
	}
	
	function edit_client($clientid, $first, $last, $gender, $dob) {
		$s = q("update client set client.first_name = '".clean_query($first)."', client.last_name = '".clean_query($last)."', client.gender = '".($gender ? '1' : '0')."', client.dob = '".clean_query($dob)."' where client.clientid = '".clean_query($clientid)."';");
		if (a() > 0)
			return true;
			
		return false;
	}
	
	/** import family information from csv version of the excel master database
	  */
	function import_family($last_name, $first_name, $dob, $address, $telephone, $family_size, $seniors, $adults, $children, $delivery, $dietary, $second_fourth_both, $wages, $unemployment, $wic, $welfare, $head_start, $afdc, $veterans_aid, $social_security, $ssi, $other, $fuel, $food_stamps, $cooking, $start, $comments, $name2, $dob2, $name3, $dob3, $name4, $dob4, $name5, $dob5, $name6, $dob6, $name7, $dob7, $name8, $dob8, $name9, $dob9, $name10, $dob10, $sep2009, $oct2009, $nov2009, $dec2009, $jan2010, $feb2010, $mar2010, $apr2010) {
		$root = create_client(null, $first_name, $last_name, '0', convert_date($dob));
		
		$second = false;
		$fourth = false;
		if ($second_fourth_both == '2nd')
			$second = true;
		else if ($second_fourth_both == '4th')
			$fourth = true;
		else if ($second_fourth_both == 'Both')
			$second = $fourth = true;
		
		// Create Family
		$fid = create_family($root, $family_size, $address, $telephone, $fuel == 'Y', false, $delivery == 'Y', $dietary == 'Y', $second, $fourth, $cooking == 'Y', convert_date($start), $comments);
		
		// Import Family Members
		for ($i = 2; $i < 11; $i++) {
			$name_var = 'name'.$i;
			$dob_var = 'dob'.$i;
			$name = $$name_var;
			$dob = $$dob_var;
			
			if ($name == '')
				break;
				
			create_client($fid, $name, '', true, convert_date($dob));
		}
		
		// Add Family Financial Aids
		// $wages, $unemployment, $wic, $welfare, $head_start, $afdc, $veterans_aid, $social_security, $ssi, $other, $fuel, $food_stamps
		$aids = get_all_aids();
		$aidid = '-1'; $amount = '0';
		foreach($aids as $aid) {
			switch($aid['name']) {
				case 'Wages':	
					$amount = $wages;
					break;
				case 'Unemployment':
					$amount = $unemployment;
					break;
				case 'WIC':
					$amount = $wic;
					break;
				case 'Welfare':
					$amount = $welfare;
					break;
				case 'Head Start':
					$amount = $head_start;
					break;
				case 'AFDC':
					$amount = $afdc;
					break;
				case 'Veterans Aid':
					$amount = $veterans_aid;
					break;
				case 'Social Security':
					$amount = $social_security;
					break;
				case 'SSI':
					$amount = $ssi;
					break;
				case 'Other Amount':
					$amount = $other;
					break;
				case 'Fuel Assistance':
					$amount = $fuel;
					break;
				case 'Food Stamps':
					$amount = $food_stamps;
					break;
				default:
					$amount = '0';
					break;
			}
			if($amount == 'Y') $amount = "0";
			if(is_numeric(trim($amount,"$")))
				set_financial_aid($fid, $aid['aidid'], trim($amount,"$"));
		}
		
		$members = get_all_family_members($fid);
		$import_size = count($members)+1;
		if($import_size != $family_size)
			echo "Missed family members for family " . $fid." and name: ".$last_name." imported ".$import_size." and there were ".$family_size."<br/>";
	}
	
?>