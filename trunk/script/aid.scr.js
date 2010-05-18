
function aid_edit(aidid) {
	// convert edit button to save
	$('#edit'+aidid).html("<a href='#' onclick='aid_rename(\""+aidid+"\"); return false;'><img src='/pantry/images/save.png'/></a>");
	$('#name'+aidid).html("<input id='edit_name"+aidid+"' value='"+$('#name'+aidid).text().trim()+"' style='width: 70%;'/>");
}

function aid_delete(aid_id) {
	var stop = false;

	jConfirm('Are you sure you want to remove this financial aid?', 'Remove Financial Aid', function(r) {
		if (r) {
		$.post('/pantry/aid/ajax/delete', { aidid: aid_id },
			function(data){
				window.location = '/pantry/aid/list';
			});
		}
	});
}

function aid_rename(aid_id) {
	var v_name = $('#edit_name'+aid_id).val();
	var v_usda_qualifier = $('#usda_qualifier'+aid_id+':checked').val() != null ? '1' : '0';

	jConfirm('Are you sure you want to rename this aid to \"'+v_name+'\"?', 'Save Aid', function(r) {
		if (r) {
		$.post('/pantry/aid/ajax/save', { aidid: aid_id, name: v_name, usda_qualifier: v_usda_qualifier},
			function(data){
				window.location = '/pantry/aid/list';
			});
		} else {
			window.location = '/pantry/aid/list';
		}
	});
}