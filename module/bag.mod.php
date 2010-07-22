<?php

	/*	bag.mod.php
		@richard pianka
		@ramsey abouzahra
		
		http://localhost/pantry/bag/module_command/something/something/
		
		/bag/list
		/bag/new
		/bag/edit/<bagid>
		/bag/delete/<bagid>
		/bag/render/bag_products/<bagid>
		/bag/ajax/bag_products/new/<bagid>
		/bag/ajax/bag_products/edit/<bagid>/<productid>
		/bag/ajax/bag_products/delete/<bagid>/<productid>

		contains the bag pages	*/
	
	if (!is_access(access_client) && !is_access(access_all)) {
		redirect('/pantry/error/no_access');
	}
	
	global $render;
	global $module_commands;
	$module_commands = array('list', 'new', 'save', 'edit', 'delete', 'render', 'ajax');
	$render_commands = array('bag_products');
	$ajax_commands = array('bag_products', 'bag');
	$ajax_bag_product_commands = array('new', 'edit', 'delete', 'add');
	
	$parameters = array('module_command', 'bag_command', 'action_command', 'select_command', 'bagid_command', 'productid_command');
	expand_get($parameters);

	$bag_framework = new Template();
	$bag_framework->load('bag_framework');
	$bag_framework_render['message'] = '';
	$bag_framework_render['content'] = '';
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $bag_framework_render;
		global $bag_framework;
		global $render;
		
		$bag_framework->set_vars($bag_framework_render);
		$bag_framework->parse();
		$render['tier_2'] = $bag_framework->final;
	}
	
	
	function render_all_bags($bags) {
		global $bag_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		if ($bags == null) {
			$bag_framework_render['message'] = 'There are no bags to display.';
			render_all();
			return;
		}
		$content = "";
		
		$bag_list = new Template();
		$bag_list->load('bag_list');
		$bag_list_render['bags'] = '';
		
		$bag_row = new Template();
		$bag_row->load('bag_row');
		$bag_row_render['id'] = '';
		$bag_row_render['name'] = '';
		$bag_row_render['class'] = '';
		foreach ($bags as $bag) {
			$bag_row_render['id'] = $bag['bagid'];
			$bag_row_render['name'] = $bag['name'];
			
			$total_weight = "0";
			$total_cost = "0";
			$food_sources = get_all_bag_food_sources($bag['bagid']);
			foreach($food_sources as $food_source) {
				$total_weight += $food_source['weight'];
				$total_cost += $food_source['price'];
			}
			$bag_row_render['total_weight'] = $total_weight;
			$bag_row_render['total_cost'] = $total_cost;
			
			$bag_contents = get_bag_contents($bag['bagid']);
			$bag_row_render['num_products'] = '0';
			foreach($bag_contents as $product)
        $bag_row_render['num_products'] += $product['quantity'];
			//$bag_row_render['num_products'] = count($bag_contents);
			
			$bag_clients = get_bag_clients($bag['bagid']);
			$bag_row_render['num_clients'] = count($bag_clients);
			
			$bag_row->set_vars($bag_row_render);
			$bag_row->parse();
			$content .= $bag_row->final;
		}
		
		$bag_list_render['bags'] = $content;
		$bag_list->set_vars($bag_list_render);
		$bag_list->parse();
		
		$bag_framework_render['content'] = $bag_list->final;
		render_all();
	}
	
	function render_bag_food_sources($bagid)
	{
		$html = "";
		$food_sources = get_all_bag_food_sources($bagid);
		foreach($food_sources as $food_source)
		{
			$html .= "<tr>";
			$html .= "<td>".$food_source['name']."</td>";
			$html .= "</tr>";
			$html .= "<td>".$food_source['weight']."</td>";
			$html .= "<td>".$food_source['price']."</td>";
			$html .= "</tr>";
			
		}
		return $html;
	}
	
	function render_edit_bag($bagid) {
		global $bag_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		
		$toggle = true;
		$rows = '';
		
		$bag_edit_food_source = new Template();
		$bag_edit_food_source->load('bag_edit_food_source');
		
		$food_sources = get_all_bag_food_sources($bagid);
		
		foreach ($food_sources as $food_source) {
			$bag_edit_food_source_render['row'] = $toggle ? '1' : '2';
			$bag_edit_food_source_render['name'] = $food_source['name'];
			$bag_edit_food_source_render['field'] = clean_url($food_source['name']);
			$bag_edit_food_source_render['checked'] = $food_source['bagid'] > 0 ? ' checked="true"' : '';
			$bag_edit_food_source_render['weight'] = $food_source['weight'];
			$bag_edit_food_source_render['price'] = $food_source['price'];
			$bag_edit_food_source->set_vars($bag_edit_food_source_render);
			$bag_edit_food_source->parse();
			$rows .= $bag_edit_food_source->final;
			
			$toggle = !$toggle;
		}
		
		$bag = get_bag_by_id($bagid);
		
		// Render Edit Bag
		$bag_edit = new Template();
		$bag_edit->load('bag_edit');			
		$bag_edit_render['id'] = $bag['bagid'];
		$bag_edit_render['name'] = $bag['name'];
		$bag_edit_render['foodsources'] = $rows;
		$bag_edit->set_vars($bag_edit_render);
		$bag_edit->parse();
		$content .= $bag_edit->final;
		
		// Render Bag Contents
		render_bag_products($bagid);
		$content .= $bag_framework_render['content'];
		
		// Render All
		$bag_framework_render['content'] = $content;
		render_all();
	}
	
	function render_new_bag() {
		global $bag_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		$bag_new = new Template();
		$bag_new->load('bag_new');			
		$bag_new_render['place_holder'] = '';
		$bag_new->set_vars($bag_new_render);
		$bag_new->parse();
		$content .= $bag_new->final;
		
		$bags = get_all_bags();
		$bag_list = "<option name='none' id='none' value='none'>None</option>";
		foreach($bags as $bag)
		{
			$bag_list .= "<option name='".$bag['name']."' id='".$bag['name']."' value='".$bag['bagid']."'>".$bag['name']."</option>";
		}
		
		$bag_framework_render['content'] = $content;
		$bag_framework_render['bags'] = $bag_list;
		render_all();
	}
	
	function render_bag_products($bagid) {
		global $bag_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		// Get bags products
		$products = get_bag_contents($bagid);
	/*
		if ($products == null) {
			$bag_framework_render['message'] = 'There are no bag products to display.';
			render_all();
			return;
		}*/
		$content = "";
		
		$bag_product_list = new Template();
		$bag_product_list->load('bag_product_list');
		$bag_product_list_render['bag_products'] = '';
		
		$bag_product_row = new Template();
		$bag_product_row->load('bag_product_row');
		$bag_product_row_render['bagid'] = $bagid;
		$bag_product_row_render['productid'] = '';
		$bag_product_row_render['name'] = '';
		$bag_product_row_render['quantity'] = '';
		$bag_product_row_render['choice'] = '';
		$bag_product_row_render['notes'] = '';
		$bag_product_row_render['class'] = '';
		foreach ($products as $product) {
			$bag_product_row_render['productid'] = $product['productid'];
			$bag_product_row_render['name'] = $product['name'];
			$bag_product_row_render['quantity'] = $product['quantity'];
			$bag_product_row_render['choice'] = $product['choice'] == '0' ? 'No' : 'Yes';
			$bag_product_row_render['notes'] = $product['notes'];
			$bag_product_row->set_vars($bag_product_row_render);
			$bag_product_row->parse();
			$content .= $bag_product_row->final;
		}
		if ($products == null) {
			$content .= "<tr><td colspan=\"6\">There are no bag products to display.</td></tr>";
			
		}
		
		$bag_product_list_render['bag_products'] = $content;
		$bag_product_list->set_vars($bag_product_list_render);
		$bag_product_list->parse();
		
		$bag_framework_render['content'] = $bag_product_list->final;
		render_all();
	}
	
	function render_bag_products_ajax($bagid) {
		global $bag_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		// Get bags products
		$products = get_bag_contents($bagid);
	
		if ($products == null) {
			$bag_framework_render['message'] = 'There are no bag products to display.';
			render_all();
			return;
		}
		$content = "";
		
		$bag_product_list = new Template();
		$bag_product_list->load('bag_product_list');
		$bag_product_list_render['bag_products'] = '';
		
		$bag_product_row = new Template();
		$bag_product_row->load('bag_product_row');
		$bag_product_row_render['bagid'] = $bagid;
		$bag_product_row_render['productid'] = '';
		$bag_product_row_render['name'] = '';
		$bag_product_row_render['quantity'] = '';
		$bag_product_row_render['choice'] = '';
		$bag_product_row_render['notes'] = '';
		foreach ($products as $product) {
			$bag_product_row_render['productid'] = $product['productid'];
			$bag_product_row_render['name'] = $product['name'];
			$bag_product_row_render['quantity'] = $product['quantity'];
			$bag_product_row_render['choice'] = $product['choice'] == '0' ? 'No' : 'Yes';
			$bag_product_row_render['notes'] = $product['notes'];
			$bag_product_row->set_vars($bag_product_row_render);
			$bag_product_row->parse();
			$content .= $bag_product_row->final;
		}
		
		$bag_product_list_render['bag_products'] = $content;
		$bag_product_list->set_vars($bag_product_list_render);
		$bag_product_list->parse();
		
		$html = $bag_product_list->final;
		echo $html;
		exit();
	}
	
	/* ===============================
	   === Start Building the page ===
	   =============================== */
	
	if (!isset($module_command)) {
		// display main  page
		render_all_bags(get_all_bags());
		return;
	}
	
	// module logic
	if (in_array($module_command, $module_commands)) {
		switch ($module_command) {
			case 'list':
				render_all_bags(get_all_bags());
				break;
			case 'new':
				render_new_bag();
				break;
			case 'save':
				$bagid = create_bag(post('name'), post('bag'));
				redirect('/pantry/bag/edit/'.$bagid);
				break;
			case 'edit':
				// Make sure bagid set to edit
				if (isset($bag_command)) {
					// Get bagid to edit
					$bagid = $bag_command;
					// Check if updating product
					if(isset($_POST) && isset($_POST['bag_name'])) { 
						edit_bag($bag_command, post('bag_name'));
						
						$food_sources = get_all_food_sources();
					
						foreach ($food_sources as $food_source) {
							$field = clean_url($food_source['name']);
							$weight = post('foodsource-'.$field.'-weight');
							$price = post('foodsource-'.$field.'-price');
							 
							edit_bag_food_source($bag_command, $food_source['sourceid'], $weight, $price);
						}
						//echo "Renamed bag to '".post('name')."'";
					} 
					// Show the updated bag
					render_edit_bag($bag_command);
				} else redirect('/pantry/error/invalid-page');
				break;	
			case 'delete':
				if(isset($bag_command)) {
					delete_bag($bag_command);
					redirect('/pantry/bag/');
				} else 
					redirect('/pantry/error/invalid-page');
				break;
			case 'render':
				if(isset($bag_command) && in_array($bag_command, $render_commands)) {
					switch($bag_command) {
						case 'bag_products':
							if(isset($action_command)) 
								render_bag_products_ajax($action_command);
							else 
								redirect('/pantry/error/invalid-page');
							break;
						default:
							redirect('/pantry/error/invalid-page');
					}
				} else 
					redirect('/pantry/error/invalid-page');
				
				
				break;
			case 'ajax':
				if(isset($bag_command) && in_array($bag_command, $ajax_commands)) {
					switch($bag_command) {
						case 'bag_products':
							if(isset($action_command)) {
								switch($action_command) {
									case 'new':
										create_bag_product(post('bid'), post('pid'), post('quantity'), post('choice'), post('notes'));
										exit();
										break;
									case 'save':
										edit_bag_content(post('bid'), post('pid'), post('quantity'), post('choice'), post('notes'));										
										//print_r($_POST);
										exit();
										break;
									case 'delete':
										delete_bag_content(post('bagid'), post('productid'));
										exit();
										break;
									case 'add':
										$product = get_product_by_name(post('product_name'));
										if(!isset($product['productid']))
											echo "NOT_SET";
										else {
											echo "SET";
											create_bag_content(post('bagid'), $product['productid'], "0", '0', "");
										}
										exit();
										break;
									default:
										redirect('/pantry/error/invalid-page');
								}
							} else
								redirect('/pantry/error/invalid-page');
							break;
						case 'bag':
							if(isset($action_command)) {
								switch($action_command) {
									case 'new':
										create_bag(post('name'));
										exit();
										break;
									case 'save':
										edit_bag(post('bagid'), post('name'));										
										//print_r($_POST);
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
				render_all_bags(get_all_bags());
		}
		return;
	}