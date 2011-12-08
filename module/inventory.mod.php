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
	$module_commands = array('list', 'new', 'edit', 'save', 'delete', 'render', 'ajax');
	//$inventory_commands = array('new', 'edit');
	
	$parameters = array('module_command', 'inventory_command', 'action_command', 'tier_2_command');
	expand_get($parameters);
	
	$inventory_framework = new Template();
	$inventory_framework->load('inventory_framework');
	$inventory_framework_render['message'] = '';
	$inventory_framework_render['content'] = '';
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $inventory_framework_render;
		global $inventory_framework;
		global $render;
		
		$inventory_framework->set_vars($inventory_framework_render);
		$inventory_framework->parse();
		$render['tier_2'] = $inventory_framework->final;
	}
	
	function render_all_products($products) {
		global $inventory_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		if ($products == null) {
			$inventory_framework_render['message'] = 'There are no products to display.';
			render_all();
			return;
		}
		$content = "";
		
		$inventory_product_list = new Template();
		$inventory_product_list->load('inventory_product_list');
		$inventory_product_list_render['bags'] = '';
		
		$inventory_product_row = new Template();
		$inventory_product_row->load('inventory_product_row');
		$inventory_product_row_render['id'] = '';
		$inventory_product_row_render['name'] = '';
		$inventory_product_row_render['quantity'] = '';
		foreach ($products as $product) {
			$inventory_product_row_render['id'] = $product['productid'];
			$inventory_product_row_render['name'] = $product['name'];
			$inventory_product_row_render['quantity'] = $product['quantity'];
			$inventory_product_row->set_vars($inventory_product_row_render);
			$inventory_product_row->parse();
			$content .= $inventory_product_row->final;
		}
		
		$inventory_product_list_render['products'] = $content;
		$inventory_product_list->set_vars($inventory_product_list_render);
		$inventory_product_list->parse();
		
		$inventory_framework_render['content'] = $inventory_product_list->final;
		render_all();
	}
	
	function render_new_product() {
		global $inventory_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		$inventory_product_new = new Template();
		$inventory_product_new->load('inventory_product_new');			
		$inventory_product_new_render['place_holder'] = '';
		$inventory_product_new->set_vars($inventory_product_new_render);
		$inventory_product_new->parse();
		$content .= $inventory_product_new->final;
		
		$inventory_framework_render['content'] = $content;
		render_all();
	}
	
	function render_edit_product($productid) {
		global $inventory_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		$product = get_product_by_id($productid);
		
		$inventory_product_edit = new Template();
		$inventory_product_edit->load('inventory_product_edit');			
		$inventory_product_edit_render['id'] = $product['productid'];
		$inventory_product_edit_render['name'] = $product['name'];
		$inventory_product_edit_render['quantity'] = $product['quantity'];
		$inventory_product_edit->set_vars($inventory_product_edit_render);
		$inventory_product_edit->parse();
		$content .= $inventory_product_edit->final;
		
		$inventory_framework_render['content'] = $content;
		render_all();
	}
	
	function render_product_names()
	{
		$html = "";
		$products = get_all_products();
		$data = array();
		foreach($products as $product)
		{
			$html .= $product['name'].";";
			array_push($data, array(
				"name" => $product['name'],
				"id" => $product['productid']
			));
		}
		
		//echo json_encode($data);
		echo $html;
		exit();
	}
		
	/* ===============================
	   === Start Building the page ===
	   =============================== */
	
	if (!isset($module_command)) {
		// display all bags
		render_all_products(get_all_products());
		return;
	}
	
	// module logic
	if (in_array($module_command, $module_commands)) {
		switch ($module_command) {
			case 'ajax':
				if(isset($inventory_command)) {
					switch($inventory_command) {
						case 'save':
							if(isset($_POST['productid']) && isset($_POST['name']) && isset($_POST['quantity'])) {
								edit_product(post('productid'), post('name'), post('quantity'));
							}
							exit();
							break;
						case 'delete':
							if(isset($_POST['productid'])) {
								delete_product(post('productid'));
							}
							exit();
							break;
						case 'list':
							render_product_names();
							exit();
							break;
						default:
							render_product_names();
							break;
					}
				} else {
					render_product_names();
					break;
				}
			case 'render':
				exit();
				break;
			case 'list':
				render_all_products(get_all_products());
				break;
			case 'new': 
				render_new_product();
				break;
			case 'save':
				create_product(post('name'), post('quantity'));
				redirect($g["abs_url"].'/inventory/');
				break;
			case 'edit':
				// Make sure productid set to edit
				if (isset($inventory_command)) {
					// Get productid to edit
					$productid = $inventory_command;
					// Check if updating product
					if(isset($_POST) && isset($_POST['name']) && isset($_POST['quantity'])) { 
						$new_name = $_POST['name'];
						$quantity = $_POST['quantity'];
						edit_product($productid, $new_name, $quantity);
						echo "Update product to '".$new_name."' and quantity: " . $quantity;
					} 
					// Show the updated product
					render_edit_product($productid);
				} else redirect($g["abs_url"].'/error/invalid-page');
				break;
			case 'delete':
				if(isset($inventory_command)) {
					delete_product($inventory_command);
					redirect($g["abs_url"].'/inventory/list/');
				}
				break;
			default:
				$client_framework_render['message'] = 'An error occurred.';
				render_all_products(get_all_products());
		}
		return;
	}
	
	
?>