
function foodsource_edit(sourceid) {
	// convert edit button to save
	$('#edit'+sourceid).html("<a href='#' onclick='foodsource_rename(\""+sourceid+"\"); return false;'><img src='/pantry/images/save.png'/></a>");
	$('#name'+sourceid).html("<input id='edit_name"+sourceid+"' value='"+$('#name'+sourceid).text().trim()+"' style='width: 70%;'/>");
}

function foodsource_delete(source_id) {
	var stop = false;

	jConfirm('Are you sure you want to remove this food source?', 'Remove Food Source', function(r) {
		if (r) {
		$.post('/pantry/foodsource/ajax/delete', { sourceid: source_id },
			function(data){
				window.location = '/pantry/foodsource/list';
			});
		}
	});
}

function foodsource_rename(source_id) {
	var v_name = $('#edit_name'+source_id).val();

	jConfirm('Are you sure you want to rename this food source to \"'+v_name+'\"?', 'Save Food Source', function(r) {
		if (r) {
		$.post('/pantry/foodsource/ajax/save', { sourceid: source_id, name: v_name },
			function(data){
				window.location = '/pantry/foodsource/list';
			});
		} else {
			window.location = '/pantry/foodsource/list';
		}
	});
}
