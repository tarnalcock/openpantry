<?php

	/*	aid.mod.php
		@richard pianka
		@ramsey abouzahra
		
		http://localhost/pantry/aid/module_command/something/something/

		contains the aid pages	*/
	
	if (!is_access(access_inventory) && !is_access(access_all)) {
		redirect($g["abs_url"].'/error/no_access');
	}
	
	global $render;
	global $module_commands;
	global $inventory_commands;
	$module_commands = array('list', 'edit', 'save', 'delete', 'render', 'ajax');
	//$inventory_commands = array('new', 'edit');
	
	$parameters = array('module_command', 'aid_command', 'action_command', 'tier_2_command');
	expand_get($parameters);
	
	$aid_framework = new Template();
	$aid_framework->load('aid_framework');
	$aid_framework_render['message'] = '';
	$aid_framework_render['content'] = '';
	
	/* ====================================
	   === All of the display functions ===
	   ==================================== */
	
	function render_all() {
		// last thing to execute in this module
		global $aid_framework_render;
		global $aid_framework;
		global $render;
		
		$aid_framework->set_vars($aid_framework_render);
		$aid_framework->parse();
		$render['tier_2'] = $aid_framework->final;
	}
	
	function render_all_aids($aids) {
		global $aid_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		$aid_list = new Template();
		$aid_list->load('aid_list');
		$aid_list_render['aids'] = '';
		
		$aid_row = new Template();
		$aid_row->load('aid_row');
		$aid_row_render['id'] = '';
		$aid_row_render['name'] = '';
		$aid_row_render['usda_qualifier'] = '';
		if($aids != null)
			foreach ($aids as $aid) {
				$aid_row_render['id'] = $aid['aidid'];
				$aid_row_render['name'] = $aid['name'];
				$aid_row_render['usda_qualifier'] = $aid['usda_qualifier'] == 0 ? "" : "checked";
				$aid_row->set_vars($aid_row_render);
				$aid_row->parse();
				$content .= $aid_row->final;
			}
		else 
			$content .= "<tr><td colspan=\"2\"></td><td>There are no aids to display</td></tr>";
		$aid_list_render['aids'] = $content;
		$aid_list->set_vars($aid_list_render);
		$aid_list->parse();
		
		$aid_framework_render['content'] = $aid_list->final;
		render_all();
	}
	
	function render_edit_aid($aidid) {
		global $aid_framework_render;
		global $parameters;
		foreach ($parameters as $parameter)
			global $$parameter;

		$content = "";
		
		$aid = get_aid_by_id($aidid);
		
		$aid_edit = new Template();
		$aid_edit->load('aid_edit');			
		$aid_edit_render['id'] = $aid['aidid'];
		$aid_edit_render['name'] = $aid['name'];
		$aid_edit->set_vars($aid_edit_render);
		$aid_edit->parse();
		$content .= $aid_edit->final;
		
		$aid_framework_render['content'] = $content;
		render_all();
	}
	
	function render_aid_names()
	{
		$html = "";
		$aids = get_all_aids();
		$data = array();
		foreach($aids as $aid)
		{
			$html .= $aid['name'].";";
			array_push($data, array(
				"name" => $aid['name'],
				"id" => $aid['aidid']
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
		render_all_aids(get_all_aids());
		return;
	}
	
	// module logic
	if (in_array($module_command, $module_commands)) {
		switch ($module_command) {
			case 'ajax':
				if(isset($aid_command)) {
					switch($aid_command) {
						case 'save':
							if(isset($_POST['aidid']) && isset($_POST['name'])) {
								edit_aid(post('aidid'), post('name'), post('usda_qualifier'));
							}
							exit();
							break;
						case 'delete':
							if(isset($_POST['aidid'])) {
								delete_aid(post('aidid'));
							}
							exit();
							break;
						default:
							render_aid_names();
							break;
					}
				} else {
					render_aid_names();
					break;
				}
			case 'render':
				exit();
				break;
			case 'list':
				render_all_aids(get_all_aids());
				break;
			case 'save':
				create_aid(post('name'));
				redirect($g["abs_url"].'/aid/list');
				break;
			case 'edit':
				// Make sure productid set to edit
				if (isset($aid_command)) {
					// Get aidid to edit
					$aidid = $aid_command;
					// Check if updating financial aid
					if(isset($_POST) && isset($_POST['name'])) { 
						$new_name = $_POST['name'];
						$usda_qualifier = $_POST['usda_qualifier'];
						edit_aid($aidid, $new_name, $usda_qualifier);
						//echo "Update food source to '".$new_name."'";
						redirect($g["abs_url"].'/aid/list/');
					} 
					// Show the updated food source
					render_edit_aid($aidid);
				} else redirect($g["abs_url"].'/error/invalid-page');
				break;
			case 'delete':
				if(isset($aid_command)) {
					delete_aid($aid_command);
					redirect($g["abs_url"].'/aid/list/');
				}
				break;
			default:
				$client_framework_render['message'] = 'An error occurred.';
				render_all_foodsources(get_all_food_sources());
		}
		return;
	}
	
	
?>