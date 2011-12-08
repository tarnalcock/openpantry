<?php

	/*	inventory.mod.php
		@richard pianka
		@ramsey abouzahra
		
		http://localhost/pantry/inventory/module_command/something/something/

		contains the inventory pages	*/
	
	if (!is_access(access_inventory) && !is_access(access_all)) {
		redirect($g["abs_url"].'/error/no_access');
	}
	
	global $render;
	global $module_commands;
	global $inventory_commands;
	$module_commands = array('msr', 'clients', 'bags', 'products', 'food_sources', 'usda', 'render', 'ajax');
	
	$parameters = array('module_command', 'reporting_command', 'action_command', 'tier_2_command');
	expand_get($parameters);
	
	$reporting_framework = new Template();
	$reporting_framework->load('inventory_framework');
	$reporting_framework_render['message'] = '';
	$reporting_framework_render['content'] = '';
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $reporting_framework_render;
		global $reporting_framework;
		global $render;
		
		$reporting_framework->set_vars($reporting_framework_render);
		$reporting_framework->parse();
		$render['tier_2'] = $reporting_framework->final;
	}
	
	function get_report_data()
	{
		$families = get_active_families(); // gets all active families
		$households = count($families); // get number households
		
		// get number of clients which is the sum of the number of family members of every family
		$total_clients = '0';			
		$adults = '0';			
		$seniors = '0';			
		$children = '0';			
		foreach($families as $family) {
			$family_members = get_all_family_members($family['clientid']);
			$total_clients += count($family_members)+1; // sum up the number of members in every family
			$adults += count(get_all_adults($family['clientid']));	// get the total number of adults
			$seniors += count(get_all_seniors($family['clientid']));	// get the total number of seniors
			$children += count(get_all_children($family['clientid']));	// get the total number of adults
		}
		
		$report = array();
		$report['Total Number of Househoulds Served'] = $households;
		$report['Total Number of Adults (18-64) Served'] = $adults;
		$report['Total Number of Children (under 18) Served'] = $children;
		$report['Total Number of Seniors (65 and older) Served'] = $seniors;
		$report['Total Number of Clients Served'] = $total_clients;
		$report['Total Number of Bags or Boxes Served'] =$total_clients + 3*$households;
		return $report;
	}
	
	function get_msr_report($start_date, $end_date)
	{
		$families = get_all_client_transactions($start_date, $end_date); // gets all active families
		$households = count($families); // get number households
		
		// get number of clients which is the sum of the number of family members of every family
		$total_clients = '0';			
		$adults = '0';			
		$seniors = '0';			
		$children = '0';			
		foreach($families as $family) {
			$family_members = get_all_family_members($family['clientid']);
			$total_clients += count($family_members)+1; // sum up the number of members in every family
			$adults += count(get_all_adults($family['clientid']));	// get the total number of adults
			$seniors += count(get_all_seniors($family['clientid']));	// get the total number of seniors
			$children += count(get_all_children($family['clientid']));	// get the total number of adults
		}
		
		$report = array();
		$report['Total Number of Househoulds Served'] = $households;
		$report['Total Number of Adults (18-64) Served'] = $adults;
		$report['Total Number of Children (under 18) Served'] = $children;
		$report['Total Number of Seniors (65 and older) Served'] = $seniors;
		$report['Total Number of Clients Served'] = $total_clients;
		$report['Total Number of Bags or Boxes Served'] = $households;
		return $report;
	}
	
	function render_msr_report($start_date, $end_date) {
		global $reporting_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
			
		$content = "";
		
		if(!isset($start_date) || !isset($end_date) || $start_date == NULL || $end_date == NULL)
			$report = get_report_data();
		else
			$report = get_msr_report($start_date, $end_date);
			
		$reporting_list = new Template();
		$reporting_list->load('report_msr_list');
		$reporting_list_render['report_rows'] = '';
		
		$report_row= new Template();
		$report_row->load('report_msr_row');
		$report_row_render['name'] = '';
		$report_row_render['amount'] = '';
		if ($report != null) 
			foreach ($report as $name => $amount) {
				$report_row_render['name'] = $name;
				$report_row_render['amount'] = $amount;
				$report_row->set_vars($report_row_render);
				$report_row->parse();
				$content .= $report_row->final;
			}

		
		$reporting_list_render['report_rows'] = $content;
		$reporting_list->set_vars($reporting_list_render);
		$reporting_list->parse();	
		
		$reporting_framework_render['content'] = $reporting_list->final;
		render_all();
	}
	
	function render_active_clients() {
		global $reporting_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
			
		$content = "";
		
		// Get all pickups/deliverys
		$pickups = get_pickup_families();
		$deliveries = get_delivery_families();
		
		// Tally up # of pickups on 2nd/4th and deliveries on 2nd/4th of active members
		$pickups_2nd = '0';
		$pickups_4th = '0';
		foreach($pickups as $pickup) {
			if($pickup['pickup_second'] == '1')
				$pickups_2nd++;
			if($pickup['pickup_fourth'] == '1')
				$pickups_4th++;
		}
		$deliveries_2nd = '0';
		$deliveries_4th = '0';
		foreach($deliveries as $delivery) {
			if($delivery['pickup_second'] == '1')
				$deliveries_2nd++;
			if($delivery['pickup_fourth'] == '1')
				$deliveries_4th++;
		}
		$total_2nd = $pickups_2nd + $deliveries_2nd;
		$total_4th = $pickups_4th + $deliveries_4th;
		
		// Get client transactions of last month
		$start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
		$end_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
		$client_transactions = get_all_client_transactions($start_date, $end_date);
		
		// Tally up # of pickups on 2nd/4th and deliveries on 2nd/4th of past transactions within date window (last month)
		$last_month = array('pickups_second' => '0', 'pickups_fourth' => '0', 'deliveries_second' => '0', 'deliveries_fourth' => '0'); 
		
		foreach($client_transactions as $ct) {
			if($ct['delivery'] == '0') {
				$day = date('d', strtotime($ct['date']));
				if($day < '15')
					$last_month['pickups_second'] += 1;
				else
					$last_month['pickups_fourth'] += 1;
			} else {
				$day = date('d', strtotime($ct['date']));
				if($day < '15')
					$last_month['pickups_second'] += 1;
				else
					$last_month['pickups_fourth'] += 1;
			}
		}	
		
		$reporting_list = new Template();
		$reporting_list->load('report_projection_list');		
		$reporting_list_render['title'] = "Active Clients";
		$reporting_list_render['pickups_2nd'] = $pickups_2nd;
		$reporting_list_render['pickups_4th'] = $pickups_4th;
		$reporting_list_render['deliveries_2nd'] = $deliveries_2nd;
		$reporting_list_render['deliveries_4th'] = $deliveries_4th;
		$reporting_list_render['total_2nd'] = $total_2nd;
		$reporting_list_render['total_4th'] = $total_4th;
		$reporting_list_render['pickups_2nd_last_month'] = $last_month['pickups_second'];
		$reporting_list_render['pickups_4th_last_month'] =  $last_month['pickups_fourth'];
		$reporting_list_render['deliveries_2nd_last_month'] = $last_month['deliveries_second'];
		$reporting_list_render['deliveries_4th_last_month'] = $last_month['deliveries_fourth'];
		$reporting_list_render['total_2nd_last_month'] = $last_month['pickups_second']+$last_month['deliveries_second'];
		$reporting_list_render['total_4th_last_month'] = $last_month['pickups_fourth']+$last_month['deliveries_fourth'];
		$reporting_list_render['report_rows'] = $content;
		$reporting_list->set_vars($reporting_list_render);
		$reporting_list->parse();
		$content = $reporting_list->final;
		
		$reporting_framework_render['content'] = $reporting_list->final;
		render_all();
	}
	
	function render_needed_products() {
		global $reporting_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
			
		// Get transactions of last month
		$start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
		$end_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
		
			
		$content = "";
		
		$products = array(); // List of products and quantity needed for the month
		$bags = get_all_bags();
		foreach($bags as $bag) {
			// Get the number of clients with this bag
			$num_clients = count(get_bag_clients($bag['bagid']));	
			// Get the number of transactions of this bag
			$num_clients_last_month = count(get_bag_transactions($bag['bagid'], $start_date, $end_date)); 
			// Get the contents of the bag
			$bag_contents = get_bag_contents($bag['bagid']);	
			
			// Get the number of products needed this month and distrbiuted last month
			foreach($bag_contents as $bag_content) {
				if(!isset($products[$bag_content['name']])) {
					$products[$bag_content['name']] = array('quantity' => $bag_content['quantity']*$num_clients, 'last_month' => $bag_content['quantity']*$num_clients_last_month);
				} else  {
					$products[$bag_content['name']]['quantity'] += $bag_content['quantity']*$num_clients;
					$products[$bag_content['name']]['last_month'] += $bag_content['quantity']*$num_clients_last_month;
				}
			}
		}
		
		$reporting_list = new Template();
		$reporting_list->load('report_product_list');
		$reporting_list_render['products'] = '';
		
		$report_row= new Template();
		$report_row->load('report_product_row');
		$report_row_render['name'] = '';
		$report_row_render['quantity'] = '';
		$report_row_render['last_month'] = '';
		if ($products != null) 
			foreach ($products as $name => $product) {
				$report_row_render['name'] = $name;
				$report_row_render['quantity'] = $product['quantity'];
				$report_row_render['last_month'] = $product['last_month'];
				$report_row->set_vars($report_row_render);
				$report_row->parse();
				$content .= $report_row->final;
			}

		
		$reporting_list_render['products'] = $content;
		$reporting_list->set_vars($reporting_list_render);
		$reporting_list->parse();
		
		$reporting_framework_render['content'] = $reporting_list->final;
		render_all();
	}
	
	function render_food_source_report() {
		global $reporting_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
			
		$content = "";
		
		// Get transactions of last month
		$start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
		$end_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
	
		$report = array();
		
		$food_sources = get_all_food_sources(); // List of products and quantity needed for the month
		$bags = get_all_bags();
		$total_weight = '0';
		$total_weight_last_month = '0';
		foreach($bags as $bag) {
			$num_clients = count(get_bag_clients($bag['bagid']));
			$num_clients_last_month = count(get_bag_transactions($bag['bagid'], $start_date, $end_date));
			$bag_sources = get_all_bag_food_sources($bag['bagid']);
			foreach($bag_sources as $bag_source ) {
				if(!isset($report[$bag_source['name']]))
					$report[$bag_source['name']] = array('weight' => $bag_source['weight']*$num_clients, 'percent' => '0', 'weight_last_month' =>  $bag_source['weight']*$num_clients_last_month, 'percent_last_month' => '0');
				else {
					$report[$bag_source['name']]['weight'] += $bag_source['weight']*$num_clients;
					$report[$bag_source['name']]['weight_last_month'] += $bag_source['weight']*$num_clients_last_month;
				}
					
				$total_weight += $bag_source['weight']*$num_clients;
				$total_weight_last_month += $bag_source['weight']*$num_clients_last_month;
			}
		}
		
		// Add Total Row
		$report['Total'] = array('weight' => $total_weight, 'percent' => '0', 'weight_last_month' => $total_weight_last_month, 'percent_last_month' => '0');
		
		// Calculate percentages
		foreach($report as $fsname => $fs) {
			$report[$fsname]['percent'] = number_format($fs['weight'] / $total_weight * 100, 1);
			if($total_weight_last_month != 0)
				$report[$fsname]['percent_last_month'] = number_format($fs['weight_last_month'] / $total_weight_last_month * 100, 1);
		}
		
		$reporting_list = new Template();
		$reporting_list->load('report_foodsource_list');
		$reporting_list_render['food_sources'] = '';
		
		$report_row= new Template();
		$report_row->load('report_foodsource_row');
		$report_row_render['name'] = '';
		$report_row_render['weight'] = '';
		$report_row_render['percent'] = '';
		$report_row_render['weight_last_month'] = '';
		$report_row_render['percent_last_month'] = '';
		if ($report != null) 
			foreach ($report as $name => $report_fs) {
				$report_row_render['name'] = $name;
				$report_row_render['weight'] = $report_fs['weight'];
				$report_row_render['percent'] = $report_fs['percent'];
				$report_row_render['weight_last_month'] = $report_fs['weight_last_month'];
				$report_row_render['percent_last_month'] = $report_fs['percent_last_month'];
				$report_row->set_vars($report_row_render);
				$report_row->parse();
				$content .= $report_row->final;
			}

		
		$reporting_list_render['food_sources'] = $content;
		$reporting_list->set_vars($reporting_list_render);
		$reporting_list->parse();
		
		$reporting_framework_render['content'] = $reporting_list->final;
		render_all();
	}
	
	function render_usda_sheet($mode)
	{
		global $reporting_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
			
		$content = "";
		
		// Get transactions of last month
		$start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
		$end_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
	
		$aids = get_all_aids();
		$num_aids = 0;
		$aid_columns = "";
		foreach($aids as $aid) 
			if($aid['usda_qualifier'] == '1') {
				$aid_columns .= "<th style=\"vertical-align: bottom;\">".$aid['name']."</th>"; $num_aids++;
			}
	
		$reporting_list = new Template();
		$reporting_list->load('report_usda_list');
		$reporting_list_render['num_aids'] = $num_aids;
		$reporting_list_render['aid_columns'] = $aid_columns;
		$reporting_list_render['clients'] = '';
		
		$report_row = new Template();
		$report_row->load('report_usda_row');
		$report_row_render['name'] = '';
		$report_row_render['address'] = '';
		$report_row_render['size'] = '';
		$report_row_render['client_aids'] = '';
		
		if($mode == "active") {
			$clients = get_active_families();
		} else {
			$clients = get_all_client_transactions($start_date, $end_date);
		}
		
		if ($clients != null) 
			foreach ($clients as $client) {
				$fam = get_family_by_id($client['clientid']);
				$report_row_render['id'] = $fam['clientid'];
				$report_row_render['name'] = $fam['last_name'].", ".$fam['first_name'];
				$report_row_render['address'] = $client['address'];
				$report_row_render['size'] = count(get_all_family_members($client['clientid']))+1;
				$report_row_render['fuel'] = $fam['fuel_assistance'] == '1' ? "Yes" : "No";
				//$report_row_render['sig'] = $fam['usda_assistance'] == '1' ? "Yes" : "No";
				$report_row_render['sig'] = "";
				
				// Get and Render Client Aids
				$report_row_render['client_aids'] = '';
				$aids = get_family_usda_aids($client['clientid']);
				foreach($aids as $aid) {
					$report_row_render['client_aids'] .= "<td>".($aid['amount'] == NULL ? "No" : "Yes")."</td>";
				}
			
				$report_row->set_vars($report_row_render);
				$report_row->parse();
				$content .= $report_row->final;
			}

		
		$reporting_list_render['clients'] = $content;
		$reporting_list->set_vars($reporting_list_render);
		$reporting_list->parse();
		
		$reporting_framework_render['content'] = $reporting_list->final;
		render_all();
	
	}
		
	/* ===============================
	   === Start Building the page ===
	   =============================== */
	
	if (!isset($module_command)) {
		// display all report information
		render_msr_report();
		return;
	}
	
	// module logic
	if (in_array($module_command, $module_commands)) {
		switch ($module_command) {
			case 'ajax':
				exit();
				break;
			case 'render':
				exit();
				break;
			case 'msr':
				if(!isset($reporting_command) || $reporting_command != 'last_month')
					render_msr_report(null, null);
				else {
					// Get client transactions of last month
					$start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
					$end_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
					render_msr_report($start_date, $end_date);
				}
				break;
			case 'clients':
				render_active_clients();
				break;
			case 'products':
				render_needed_products();
				break;
			case 'food_sources':
				render_food_source_report();
				break;
			case 'usda':
				render_usda_sheet("active");
				break;
			default:
				$reporting_framework_render['message'] = 'An error occurred.';
				render_msr_report();
		}
		return;
	}
	
	
?>