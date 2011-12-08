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
	
	$parameters = array('module_command', 'foodsource_command', 'action_command', 'tier_2_command');
	expand_get($parameters);
	
	$foodsource_framework = new Template();
	$foodsource_framework->load('inventory_framework');
	$foodsource_framework_render['message'] = '';
	$foodsource_framework_render['content'] = '';
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $foodsource_framework_render;
		global $foodsource_framework;
		global $render;
		
		$foodsource_framework->set_vars($foodsource_framework_render);
		$foodsource_framework->parse();
		$render['tier_2'] = $foodsource_framework->final;
	}
	
	function render_all_foodsources($foodsources) {
		global $foodsource_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;
			
		$content = "";
		
		$foodsource_list = new Template();
		$foodsource_list->load('foodsource_list');
		$foodsource_list_render['foodsources'] = '';
		
		$foodsource_row = new Template();
		$foodsource_row->load('foodsource_row');
		$foodsource_row_render['id'] = '';
		$foodsource_row_render['name'] = '';
		if ($foodsources != null) 
			foreach ($foodsources as $foodsource) {
				$foodsource_row_render['id'] = $foodsource['sourceid'];
				$foodsource_row_render['name'] = $foodsource['name'];
				$foodsource_row->set_vars($foodsource_row_render);
				$foodsource_row->parse();
				$content .= $foodsource_row->final;
			}
		
		$foodsource_list_render['foodsources'] = $content;
		$foodsource_list->set_vars($foodsource_list_render);
		$foodsource_list->parse();
		
		$foodsource_framework_render['content'] = $foodsource_list->final;
		render_all();
	}
	
	function render_edit_foodsource($sourceid) {
		global $foodsource_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		$foodsource = get_food_source_by_id($sourceid);
		
		$foodsource_edit = new Template();
		$foodsource_edit->load('foodsource_edit');			
		$foodsource_edit_render['id'] = $foodsource['sourceid'];
		$foodsource_edit_render['name'] = $foodsource['name'];
		$foodsource_edit->set_vars($foodsource_edit_render);
		$foodsource_edit->parse();
		$content .= $foodsource_edit->final;
		
		$foodsource_framework_render['content'] = $content;
		render_all();
	}
	
	function render_foodsource_names()
	{
		$html = "";
		$foodsources = get_all_foodsources();
		$data = array();
		foreach($foodsources as $foodsource)
		{
			$html .= $foodsource['name'].";";
			array_push($data, array(
				"name" => $foodsource['name'],
				"id" => $foodsource['sourceid']
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
		render_all_foodsources(get_all_food_sources());
		return;
	}
	
	// module logic
	if (in_array($module_command, $module_commands)) {
		switch ($module_command) {
			case 'ajax':
				if(isset($foodsource_command)) {
					switch($foodsource_command) {
						case 'save':
							if(isset($_POST['sourceid']) && isset($_POST['name'])) {
								edit_food_source(post('sourceid'), post('name'));
							}
							exit();
							break;
						case 'delete':
							if(isset($_POST['sourceid'])) {
								delete_food_source(post('sourceid'));
							}
							exit();
							break;
						default:
							render_foodsource_names();
							break;
					}
				} else {
					render_foodsource_names();
					break;
				}
			case 'render':
				exit();
				break;
			case 'list':
				render_all_foodsources(get_all_food_sources());
				break;
			case 'save':
				create_food_source(post('name'));
				redirect($g["abs_url"].'/foodsource/list');
				break;
			case 'edit':
				// Make sure productid set to edit
				if (isset($foodsource_command)) {
					// Get sourceid to edit
					$sourceid = $foodsource_command;
					// Check if updating food source
					if(isset($_POST) && isset($_POST['name'])) { 
						$new_name = $_POST['name'];
						edit_food_source($sourceid, $new_name);
						//echo "Update food source to '".$new_name."'";
						redirect($g["abs_url"].'/foodsource/list/');
					} 
					// Show the updated food source
					render_edit_foodsource($sourceid);
				} else redirect($g["abs_url"].'/error/invalid-page');
				break;
			case 'delete':
				if(isset($foodsource_command)) {
					delete_food_source($foodsource_command);
					redirect($g["abs_url"].'/foodsource/list/');
				}
				break;
			default:
				$client_framework_render['message'] = 'An error occurred.';
				render_all_foodsources(get_all_food_sources());
		}
		return;
	}
	
	
?>