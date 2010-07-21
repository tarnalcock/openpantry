<?php

	/*	client.mod.php
		@richard pianka
		
		http://localhost/pantry/client/module_command/something/something/

		contains the client pages	*/
	
	if (!is_access(access_client) && !is_access(access_all)) {
		redirect('/pantry/error/no_access');
	}
	
	global $render;
	global $module_commands;
	$module_commands = array('family', 'dropoffs', 'pickups', 'deliveries', 'new', 'edit', 'render', 'ajax');
	$render_commands = array('family_members');
	$ajax_commands = array('family_members');
	
	$parameters = array('module_command', 'client_command', 'action_command');
	expand_get($parameters);
	
	$client_framework = new Template();
	$client_framework->load('client_framework');
	$client_framework_render['message'] = '';
	$client_framework_render['content'] = '';
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $client_framework_render;
		global $client_framework;
		global $render;
		
		$client_framework->set_vars($client_framework_render);
		$client_framework->parse();
		$render['tier_2'] = $client_framework->final;
	}
	
	function render_all_families($families, $comments_hide) {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		if ($families == null) {
			$client_framework_render['message'] = 'There are no families to display.<br />';
			render_all();
			return;
		}
		$content = "";
		
		$client_list = new Template();
		$client_list->load('client_list');
		if($comments_hide)
			$client_list_render['comments_hide_show'] = " <a href='/pantry/client/family/' style='font-size:10px'> (show)</a>";
		else
			$client_list_render['comments_hide_show'] = " <a href='/pantry/client/family/hide' style='font-size:10px'> (hide)</a>";
		$client_list_render['families'] = '';
		
		$client_family_row = new Template();
		$client_family_row->load('client_family_row');
		$client_family_row_render['class'] = '';
		$client_family_row_render['id'] = '';
		$client_family_row_render['size'] = '';
		$client_family_row_render['first'] = '';
		$client_family_row_render['last'] = '';
		$client_family_row_render['address'] = '';
		$client_family_row_render['telephone'] = '';
		$client_family_row_render['start'] = '';
		$client_family_row_render['comments'] = '';
		foreach ($families as $family) {
			$client_family_row_render['class'] = '';
			if ($family['active'] == '0')
				$client_family_row_render['class'] = '" style="background-color: red';
			elseif ($family['delivery'] == '1')
				$client_family_row_render['class'] = '" style="background-color: #FFFF88';
			elseif ($family['dietary'] == '1')
				$client_family_row_render['class'] = '" style="background-color: #6BBA70';
			
			$client_family_row_render['id'] = $family['clientid'];
			$client_family_row_render['size'] = count(get_all_family_members($family['clientid'])) + 1;
			$client_family_row_render['first'] = $family['first_name'];
			$client_family_row_render['last'] = $family['last_name'];
			$client_family_row_render['address'] = $family['address'];
			$client_family_row_render['telephone'] = $family['telephone'];
			$client_family_row_render['start'] = $family['start_date'];
			if(!$comments_hide)
				$client_family_row_render['comments'] = $family['comments'];
			$client_family_row->set_vars($client_family_row_render);
			$client_family_row->parse();
			$content .= $client_family_row->final;
		}
		
		$client_list_render['families'] = $content;
		$client_list->set_vars($client_list_render);
		$client_list->parse();
		
		$client_framework_render['content'] = $client_list->final;
		render_all();
	}
	
	function render_pickups($families) {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		if ($families == null) {
			$client_framework_render['message'] = 'There are no families to display.<br />';
			render_all();
			return;
		}
		$content = '';
		
		$client_pickups_list = new Template();
		$client_pickups_list->load('client_pickups_list');
		$client_pickups_list_render['families'] = '';
		
		$client_pickups_family_row = new Template();
		$client_pickups_family_row->load('client_pickups_family_row');
		$client_pickups_family_row_render['class'] = '';
		$client_pickups_family_row_render['id'] = '';
		$client_pickups_family_row_render['size'] = '';
		$client_pickups_family_row_render['first'] = '';
		$client_pickups_family_row_render['last'] = '';
		$client_pickups_family_row_render['address'] = '';
		$client_pickups_family_row_render['telephone'] = '';
		$client_pickups_family_row_render['start'] = '';
		$client_pickups_family_row_render['comments'] = '';
		foreach ($families as $family) {
			$client_pickups_family_row_render['class'] = '';
			if ($family['active'] == '0')
				$client_pickups_family_row_render['class'] = '" style="background-color: red';
			elseif ($family['delivery'] == '1')
				$client_pickups_family_row_render['class'] = '" style="background-color: #FFFF88';
			elseif ($family['dietary'] == '1')
				$client_pickups_family_row_render['class'] = '" style="background-color: #6BBA70';
			
			$client_pickups_family_row_render['id'] = $family['clientid'];
			$client_pickups_family_row_render['size'] = count(get_all_family_members($family['clientid'])) + 1;
			$client_pickups_family_row_render['first'] = $family['first_name'];
			$client_pickups_family_row_render['last'] = $family['last_name'];
			$client_pickups_family_row_render['address'] = $family['address'];
			$client_pickups_family_row_render['telephone'] = $family['telephone'];
			$client_pickups_family_row_render['start'] = $family['start_date'];
			$client_pickups_family_row_render['comments'] = $family['comments'];
			$client_pickups_family_row->set_vars($client_pickups_family_row_render);
			$client_pickups_family_row->parse();
			$content .= $client_pickups_family_row->final;
		}
		
		$client_pickups_list_render['families'] = $content;
		$client_pickups_list->set_vars($client_pickups_list_render);
		$client_pickups_list->parse();
		
		$client_framework_render['content'] = $client_pickups_list->final;
		render_all();
	}

	function render_pickups_go($clientid) {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$family = get_family_by_id($clientid);
		$content = '';
		$bag_list = '';
		$bags = get_all_bags();
		$bagname = '';
		
		foreach ($bags as $bag) {
			if ($bag['bagid'] == $family['bagid']) {
				$bagname = $bag['name'];
			}
		}
		
		$toggle = true;
		$aids = '';
		
		$client_pickups_aid = new Template();
		$client_pickups_aid->load('client_pickups_aid');
		
		$faids = get_all_financial_aids_client($clientid);
		
		foreach ($faids as $aid) {
			$client_pickups_aid_render['row'] = $toggle ? '1' : '2';
			$client_pickups_aid_render['name'] = $aid['name'];
			$client_pickups_aid_render['has'] = $aid['clientid'] > 0 ? '<b>Yes</b>' : 'No';
			$client_pickups_aid_render['amount'] = $aid['amount'];
			$client_pickups_aid->set_vars($client_pickups_aid_render);
			$client_pickups_aid->parse();
			$aids .= $client_pickups_aid->final;
			
			$toggle = !$toggle;
		}
		
		$toggle = true;
		$transactions_html = '';
		$transactions_rows = '';
		
		$client_pickups_transactions = new Template();
		$client_pickups_transactions->load('client_pickups_transactions');
		
		$client_pickups_transactions_row = new Template();
		$client_pickups_transactions_row->load('client_pickups_transactions_row');
		
		$transactions = get_client_transactions($family['clientid']);
		foreach ($transactions as $transaction) {
			$client_pickups_transactions_row_render['row'] = $toggle ? '1' : '2';
			$client_pickups_transactions_row_render['date'] = $transaction['date'];
			$client_pickups_transactions_row->set_vars($client_pickups_transactions_row_render);
			$client_pickups_transactions_row->parse();
			$transactions_rows .= $client_pickups_transactions_row->final;
			
			$toggle = !$toggle;
		}
		
		$client_pickups_transactions_render['rows'] = $transactions_rows;
		$client_pickups_transactions->set_vars($client_pickups_transactions_render);
		$client_pickups_transactions->parse();
		$products_html = $client_pickups_transactions->final;
		
		$toggle = true;
		$html = '';
		$rows = '';
	
		$client_pickups_family_members = new Template();
		$client_pickups_family_members->load('client_pickups_family_members');
		
		$client_pickups_family_members_row = new Template();
		$client_pickups_family_members_row->load('client_pickups_family_members_row');
		
		$members = get_all_family_members($clientid);
		
		foreach ($members as $member) {
			$client_pickups_family_members_row_render['row'] = $toggle ? '1' : '2';
			$client_pickups_family_members_row_render['id'] = $member['clientid'];
			$client_pickups_family_members_row_render['name'] = $member['first_name'];
			$client_pickups_family_members_row_render['dob'] = $member['dob'];
			$client_pickups_family_members_row_render['gender'] = $member['gender'] == '1' ? 'Male' : 'Female';
			$client_pickups_family_members_row_render['family'] = $clientid;
			$client_pickups_family_members_row->set_vars($client_pickups_family_members_row_render);
			$client_pickups_family_members_row->parse();
			$rows .= $client_pickups_family_members_row->final;
			
			$toggle = !$toggle;
		}
		
		$client_pickups_family_members_render['rows'] = $rows;
		$client_pickups_family_members->set_vars($client_pickups_family_members_render);
		$client_pickups_family_members->parse();
		$html = $client_pickups_family_members->final;
		
		$client_pickups_go = new Template();
		$client_pickups_go->load('client_pickups_go');
		$client_pickups_go_render['date'] = date('Y-m-d');
		$client_pickups_go_render['id'] = $family['clientid'];
		$client_pickups_go_render['bag'] = $bagname;
		$client_pickups_go_render['active'] = $family['active'] == '1' ? 'checked' : '';
		$client_pickups_go_render['first_name'] = $family['first_name'];
		$client_pickups_go_render['last_name'] = $family['last_name'];
		$client_pickups_go_render['gender'] = $family['gender'] == '1' ? 'Male' : 'Female';
		$client_pickups_go_render['address'] = $family['address'];
		$client_pickups_go_render['telephone'] = $family['telephone'];
		$client_pickups_go_render['dob'] = $family['dob'];
		$client_pickups_go_render['start'] = $family['start_date'];
		$client_pickups_go_render['comments'] = $family['comments'];
		$client_pickups_go_render['family_members'] = $html;
		$client_pickups_go_render['products'] = $products_html;
		$client_pickups_go_render['aids'] = $aids;
		$client_pickups_go->set_vars($client_pickups_go_render);
		$client_pickups_go->parse();
		$content .= $client_pickups_go->final;
		
		$client_framework_render['content'] = $content;
		render_all();
	}
	
	function render_deliveries($families) {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		if ($families == null) {
			$client_framework_render['message'] = 'There are no families to display.<br />';
			render_all();
			return;
		}
		$content = '';
		
		$client_deliveries_list = new Template();
		$client_deliveries_list->load('client_deliveries_list');
		$client_deliveries_list_render['families'] = '';
		
		$client_deliveries_family_row = new Template();
		$client_deliveries_family_row->load('client_deliveries_family_row');
		$client_deliveries_family_row_render['class'] = '';
		$client_deliveries_family_row_render['id'] = '';
		$client_deliveries_family_row_render['bag_name'] = '';
		$client_deliveries_family_row_render['size'] = '';
		$client_deliveries_family_row_render['first'] = '';
		$client_deliveries_family_row_render['last'] = '';
		$client_deliveries_family_row_render['address'] = '';
		$client_deliveries_family_row_render['telephone'] = '';
		$client_deliveries_family_row_render['start'] = '';
		$client_deliveries_family_row_render['comments'] = '';
		foreach ($families as $family) {
			$client_deliveries_family_row_render['class'] = '';
			if ($family['dietary'] == '1')
				$client_deliveries_family_row_render['class'] = '" style="background-color: #6BBA70';
			
			$bag = get_bag_by_id($family['bagid']);
			$client_deliveries_family_row_render['bag_name'] = $bag['name'];
			
			$client_deliveries_family_row_render['id'] = $family['clientid'];
			$client_deliveries_family_row_render['size'] = count(get_all_family_members($family['clientid'])) + 1;
			$client_deliveries_family_row_render['first'] = $family['first_name'];
			$client_deliveries_family_row_render['last'] = $family['last_name'];
			$client_deliveries_family_row_render['address'] = $family['address'];
			$client_deliveries_family_row_render['telephone'] = $family['telephone'];
			$client_deliveries_family_row_render['start'] = $family['start_date'];
			$client_deliveries_family_row_render['comments'] = $family['comments'];
			$client_deliveries_family_row->set_vars($client_deliveries_family_row_render);
			$client_deliveries_family_row->parse();
			$content .= $client_deliveries_family_row->final;
		}
		
		$client_deliveries_list_render['families'] = $content;
		$client_deliveries_list->set_vars($client_deliveries_list_render);
		$client_deliveries_list->parse();
		
		$client_framework_render['content'] = $client_deliveries_list->final;
		render_all();
	}
	
	function render_deliveries_go($clientid) {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$family = get_family_by_id($clientid);
		$content = '';
		$bag_list = '';
		$bags = get_all_bags();
		$bagname = '';
		
		foreach ($bags as $bag) {
			if ($bag['bagid'] == $family['bagid']) {
				$bagname = $bag['name'];
			}
		}
		
		$toggle = true;
		$aids = '';
		
		$client_deliveries_aid = new Template();
		$client_deliveries_aid->load('client_deliveries_aid');
		
		$faids = get_all_financial_aids_client($clientid);
		
		foreach ($faids as $aid) {
			$client_deliveries_aid_render['row'] = $toggle ? '1' : '2';
			$client_deliveries_aid_render['name'] = $aid['name'];
			$client_deliveries_aid_render['has'] = $aid['clientid'] > 0 ? '<b>Yes</b>' : 'No';
			$client_deliveries_aid_render['amount'] = $aid['amount'];
			$client_deliveries_aid->set_vars($client_deliveries_aid_render);
			$client_deliveries_aid->parse();
			$aids .= $client_deliveries_aid->final;
			
			$toggle = !$toggle;
		}
		
		$toggle = true;
		$products_html = '';
		$products_rows = '';
		
		$client_deliveries_products = new Template();
		$client_deliveries_products->load('client_deliveries_products');
		
		$client_deliveries_products_row = new Template();
		$client_deliveries_products_row->load('client_deliveries_products_row');
		
		$products = get_bag_contents($family['bagid']);
		foreach ($products as $product) {
			$client_deliveries_products_row_render['row'] = $toggle ? '1' : '2';
			$client_deliveries_products_row_render['product'] = $product['name'];
			$client_deliveries_products_row_render['quantity'] = $product['quantity'];
			$client_deliveries_products_row->set_vars($client_deliveries_products_row_render);
			$client_deliveries_products_row->parse();
			$products_rows .= $client_deliveries_products_row->final;
			
			$toggle = !$toggle;
		}
		
		$client_deliveries_products_render['rows'] = $products_rows;
		$client_deliveries_products->set_vars($client_deliveries_products_render);
		$client_deliveries_products->parse();
		$products_html = $client_deliveries_products->final;
		
		$toggle = true;
		$html = '';
		$rows = '';
	
		$client_deliveries_family_members = new Template();
		$client_deliveries_family_members->load('client_deliveries_family_members');
		
		$client_deliveries_family_members_row = new Template();
		$client_deliveries_family_members_row->load('client_deliveries_family_members_row');
		
		$members = get_all_family_members($clientid);
		
		foreach ($members as $member) {
			$client_deliveries_family_members_row_render['row'] = $toggle ? '1' : '2';
			$client_deliveries_family_members_row_render['id'] = $member['clientid'];
			$client_deliveries_family_members_row_render['name'] = $member['first_name'];
			$client_deliveries_family_members_row_render['dob'] = $member['dob'];
			$client_deliveries_family_members_row_render['gender'] = $member['gender'] == '1' ? 'Male' : 'Female';
			$client_deliveries_family_members_row_render['family'] = $clientid;
			$client_deliveries_family_members_row->set_vars($client_deliveries_family_members_row_render);
			$client_deliveries_family_members_row->parse();
			$rows .= $client_deliveries_family_members_row->final;
			
			$toggle = !$toggle;
		}
		
		$client_deliveries_family_members_render['rows'] = $rows;
		$client_deliveries_family_members->set_vars($client_deliveries_family_members_render);
		$client_deliveries_family_members->parse();
		$html = $client_deliveries_family_members->final;
		
		$client_deliveries_go = new Template();
		$client_deliveries_go->load('client_deliveries_go');
		$client_deliveries_go_render['id'] = $family['clientid'];
		$client_deliveries_go_render['bag'] = $bagname;
		$client_deliveries_go_render['active'] = $family['active'] == '1' ? 'checked' : '';
		$client_deliveries_go_render['first_name'] = $family['first_name'];
		$client_deliveries_go_render['last_name'] = $family['last_name'];
		$client_deliveries_go_render['gender'] = $family['gender'] == '1' ? 'Male' : 'Female';
		$client_deliveries_go_render['address'] = $family['address'];
		$client_deliveries_go_render['telephone'] = $family['telephone'];
		$client_deliveries_go_render['dob'] = $family['dob'];
		$client_deliveries_go_render['start'] = $family['start_date'];
		$client_deliveries_go_render['comments'] = $family['comments'];
		$client_deliveries_go_render['family_members'] = $html;
		$client_deliveries_go_render['products'] = $products_html;
		$client_deliveries_go_render['aids'] = $aids;
		$client_deliveries_go->set_vars($client_deliveries_go_render);
		$client_deliveries_go->parse();
		$content .= $client_deliveries_go->final;
		
		$client_framework_render['content'] = $content;
		render_all();
	}
	
	function render_dropoffs() {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
		
		$toggle = true;
		$rows = '';
		$content = '';
		
		$client_drop_food_source = new Template();
		$client_drop_food_source->load('client_drop_food_source');
		
		$food_sources = get_all_bag_food_sources(0);
		
		foreach ($food_sources as $food_source) {
			$client_drop_food_source_render['row'] = $toggle ? '1' : '2';
			$client_drop_food_source_render['name'] = $food_source['name'];
			$client_drop_food_source_render['field'] = clean_url($food_source['name']);
			$client_drop_food_source_render['checked'] = $food_source['bagid'] > 0 ? ' checked="true"' : '';
			$client_drop_food_source_render['weight'] = $food_source['weight'];
			$client_drop_food_source_render['price'] = $food_source['price'];
			$client_drop_food_source->set_vars($client_drop_food_source_render);
			$client_drop_food_source->parse();
			$rows .= $client_drop_food_source->final;
			
			$toggle = !$toggle;
		}
		
		$client_drop = new Template();
		$client_drop->load('client_drop');
		$client_drop_render['foodsources'] = $rows;
		$client_drop->set_vars($client_drop_render);
		$client_drop->parse();
		$content .= $client_drop->final;
		
		$client_framework_render['content'] = $content;
		render_all();
	}
	
	function render_new() {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = '';
		$bag_list = '';
		$bags = get_all_bags();
		
		foreach ($bags as $bag) {
			$bag_list .= "<option value='".$bag['bagid']."'>".$bag['name']."</option>";
		}
		
		$client_new = new Template();
		$client_new->load('client_new');			
		$client_new_render['bags'] = $bag_list;
		$client_new->set_vars($client_new_render);
		$client_new->parse();
		$content .= $client_new->final;
		
		$client_framework_render['content'] = $content;
		render_all();
	}

	function render_edit($clientid) {
		global $client_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$family = get_family_by_id($clientid);
		$content = '';
		$bag_list = '';
		$bags = get_all_bags();
		
		foreach ($bags as $bag) {
			$bag_list .= "<option value='".$bag['bagid']."'".($bag['bagid'] == $family['bagid'] ? ' selected' : '').">".$bag['name']."</option>";
		}
		
		$toggle = true;
		$rows = '';
		
		$client_edit_aid = new Template();
		$client_edit_aid->load('client_edit_aid');
		
		$aids = get_all_financial_aids_client($clientid);
		
		foreach ($aids as $aid) {
			$client_edit_aid_render['row'] = $toggle ? '1' : '2';
			$client_edit_aid_render['name'] = $aid['name'];
			$client_edit_aid_render['field'] = clean_url($aid['name']);
			$client_edit_aid_render['checked'] = $aid['clientid'] > 0 ? ' checked="true"' : '';
			$client_edit_aid_render['amount'] = $aid['amount'];
			$client_edit_aid->set_vars($client_edit_aid_render);
			$client_edit_aid->parse();
			$rows .= $client_edit_aid->final;
			
			$toggle = !$toggle;
		}
		
		$client_edit = new Template();
		$client_edit->load('client_edit');
		$client_edit_render['id'] = $family['clientid'];
		$client_edit_render['bags'] = $bag_list;
		$client_edit_render['active'] = $family['active'] == '1' ? 'checked' : '';
		$client_edit_render['first_name'] = $family['first_name'];
		$client_edit_render['last_name'] = $family['last_name'];
		$client_edit_render['male'] = ($family['gender'] == '1' ? ' selected' : '');
		$client_edit_render['female'] = ($family['gender'] == '0' ? ' selected' : '');
		$client_edit_render['address'] = $family['address'];
		$client_edit_render['telephone'] = $family['telephone'];
		$client_edit_render['dob'] = $family['dob'];
		$client_edit_render['fuel'] = ($family['fuel_assistance'] ? ' checked' : '');
		$client_edit_render['usda'] = ($family['usda_assistance'] ? ' checked' : '');
		$client_edit_render['delivery'] = ($family['delivery'] ? ' checked' : '');
		$client_edit_render['dietary'] = ($family['dietary'] ? ' checked' : '');
		$client_edit_render['second'] = ($family['pickup_second'] ? ' checked' : '');
		$client_edit_render['fourth'] = ($family['pickup_fourth'] ? ' checked' : '');
		$client_edit_render['cooking'] = ($family['cooking_facilities'] ? ' checked' : '');
		$client_edit_render['start'] = $family['start_date'];
		$client_edit_render['comments'] = $family['comments'];
		$client_edit_render['aids'] = $rows;
		$client_edit->set_vars($client_edit_render);
		$client_edit->parse();
		$content .= $client_edit->final;
		
		$client_framework_render['content'] = $content;
		render_all();
	}
	
	/* AJAX rendering */
	
	function render_family_members($clientid) {
		$html = '';
		$rows = '';
	
		$client_family_members = new Template();
		$client_family_members->load('client_family_members');
		
		$client_family_members_row = new Template();
		$client_family_members_row->load('client_family_members_row');
		
		$members = get_all_family_members($clientid);
		
		foreach ($members as $member) {
			$client_family_members_row_render['id'] = $member['clientid'];
			$client_family_members_row_render['name'] = $member['first_name'];
			$client_family_members_row_render['dob'] = $member['dob'];
			$client_family_members_row_render['gender'] = $member['gender'] == '1' ? 'Male' : 'Female';
			$client_family_members_row_render['family'] = $clientid;
			$client_family_members_row->set_vars($client_family_members_row_render);
			$client_family_members_row->parse();
			$rows .= $client_family_members_row->final;
		}
		
		$client_family_members_render['rows'] = $rows;
		$client_family_members->set_vars($client_family_members_render);
		$client_family_members->parse();
		$html = $client_family_members->final;
		
		echo $html;
		exit();
	}
		
	/* ===============================
	   === Start Building the page ===
	   =============================== */
	
	if (!isset($module_command)) {
		// display main blog page
		render_all_families(get_all_families());
		return;
	}
	
	// module logic
	if (in_array($module_command, $module_commands)) {
		switch ($module_command) {
			case 'family':
				if(isset($client_command) && $client_command == 'hide')
					$comments_hide = true;
				else
					$comments_hide = false;
				render_all_families(get_all_families(), $comments_hide);
				break;
			case 'pickups':
				if (post('did_submit') == 'yes') {
					new_bag_transaction_date($client_command, post('date'));
				}
				
				if (isset($client_command))
					render_pickups_go($client_command);
				else
					render_pickups(get_pickup_families());
				break;
			case 'deliveries':
				if (post('did_submit') == 'yes') {
					new_bag_transaction($client_command);
				}
				
				if (isset($client_command))
					render_deliveries_go($client_command);
				else
					render_deliveries(get_delivery_families());
				break;
			case 'dropoffs':
				if (post('did_submit') == 'yes') {
					$food_sources = get_all_food_sources();
					$id = new_dropoff_transaction();
				
					foreach ($food_sources as $food_source) {
						$field = clean_url($food_source['name']);
						$weight = post('foodsource-'.$field.'-weight');
						$price = post('foodsource-'.$field.'-price');
						
						new_dropoff_transaction_food_source($id, $food_source['sourceid'], $weight, $price);
					}
				}
				
				render_dropoffs();
				break;
			case 'new':
				if (post('did_submit') == 'yes') {
					$clientid = create_client(null,
											  post('first_name'),
											  post('last_name'),
											  post('gender') == '1',
											  post('dob'));
											  
					if ($clientid > 0) {
						$familyid = create_family($clientid,
												  post('bag'),
												  post('address'),
												  post('telephone'),
												  post('fuel') == 'true',
												  post('usda') == 'true',
												  post('delivery') == 'true',
												  post('dietary') == 'true',
												  post('2nd') == 'true',
												  post('4th') == 'true',
												  post('cooking') == 'true',
												  post('start'),
												  post('comments'));
						if ($familyid > 0) {
							redirect('/pantry/client/edit/'.$familyid);
						} else {
							$client_framework_render['message'] = 'An error occurred.<br />';
						}
					} else {
						$client_framework_render['message'] = 'An error occurred.<br />';
					}
				}
				render_new();
				break;
			case 'edit':
				if (post('did_submit') == 'yes') {
					edit_client($client_command,
									  post('first_name'),
									  post('last_name'),
									  post('gender') == '1',
									  post('dob'));
					edit_family($client_command,
									  post('bag'),
									  post('active') == 'true',
									  post('address'),
									  post('telephone'),
									  post('fuel') == 'true',
									  post('usda') == 'true',
									  post('delivery') == 'true',
									  post('dietary') == 'true',
									  post('2nd') == 'true',
									  post('4th') == 'true',
									  post('cooking') == 'true',
									  post('start'),
									  post('comments'));
					clear_financial_aids($client_command);
					$aids = get_all_financial_aids();
					
					foreach ($aids as $aid) {
						$field = clean_url($aid['name']);
						$check = post('aid-'.$field);
						$amount = post('aid-'.$field.'-text');
						
						if ($check == 'true') {
							set_financial_aid($client_command, $aid['aidid'], $amount);
						}
					}
				}
				
				if (isset($client_command))
					render_edit($client_command);
				else
					redirect('/pantry/error/invalid-page');
				break;
			case 'render':
				if (isset($client_command) &&
					in_array($client_command, $render_commands)) {
					switch ($client_command) {
						case 'family_members':
							if (isset($action_command))
								render_family_members($action_command);
							else
								redirect('/pantry/error/invalid-page');
							break;
						default:
							redirect('/pantry/error/invalid-page');
					}
				} else
					redirect('/pantry/error/invalid-page');
				
				echo "An error occurred.";
				exit();
				
				break;
			case 'ajax':
				if (isset($client_command) &&
					in_array($client_command, $ajax_commands)) {
					switch ($client_command) {
						case 'family_members':
							if (isset($action_command)) {
								switch ($action_command) {
									case 'new':
										create_client(post('id'), post('name'), '', post('gender'), post('dob'));
										exit();
										break;
									case 'save':
										edit_client(post('id'), post('name'), '', post('gender'), post('dob'));
										exit();
										break;
									case 'delete':
										delete_client(post('id'));
										exit();
										break;
									default:
										redirect('/pantry/error/invalid-page');
								}
							} else
								redirect('/pantry/error/invalid-page');
							break;
						default:
							redirect('/pantry/error/invalid-page');
					}
				} else
					redirect('/pantry/error/invalid-page');
				
				echo "An error occurred.";
				exit();
				
				break;
			default:
				$client_framework_render['message'] = 'An error occurred.<br />';
				render_all_families(get_all_families());
		}
		return;
	}
	
	
?>