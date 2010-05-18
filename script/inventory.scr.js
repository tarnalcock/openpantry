
function inventory_edit(productid) {
	// convert edit button to save
	$('#edit'+productid).html("<a href='#' onclick='inventory_save(\""+productid+"\"); return false;'><img src='/pantry/images/save.png'/></a>");
	$('#name'+productid).html("<input id='edit_name"+productid+"' value='"+$('#name'+productid).text().trim()+"' style='width: 70%;'/>");
	$('#quantity'+productid).html("<input id='edit_quantity"+productid+"' value='"+$('#quantity'+productid).text().trim()+"' style='width: 70%;'/>");
}

function inventory_delete(product_id) {
	var stop = false;

	var name = $('#name'+product_id).html().trim();
	if(name.indexOf('<input') != -1)
		name = $('#edit_name'+product_id).val();
	
	jConfirm("Are you sure you want to remove \""+name+"\" from the inventory and all bags?", 'Remove Product From Inventory', function(r) {
		if (r) {
		$.post('/pantry/inventory/ajax/delete', { productid: product_id },
			function(data){
				window.location = '/pantry/inventory/list';
			});
		}
	});
}

function inventory_save(product_id) {
	var v_name = $('#edit_name'+product_id).val();
	var v_quantity = $('#edit_quantity'+product_id).val();
	
	jConfirm('Are you sure you want to save these inventory product changes?', 'Save Inventory Product', function(r) {
		if (r) {
		$.post('/pantry/inventory/ajax/save', { productid: product_id, name: v_name, quantity: v_quantity},
			function(data){
				window.location = '/pantry/inventory/list';
			});
		} else {
			window.location = '/pantry/inventory/list';
		}
	});
}