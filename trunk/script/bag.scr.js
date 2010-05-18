
function bag_edit(bagid) {
	// convert edit button to save
	$('#edit'+bagid).html("<a href='#' onclick='bag_edit_save(\""+bagid+"\"); return false;'><img src='/pantry/images/save.png'/></a>");
	$('#name'+bagid).html("<input id='edit_name"+bagid+"' value='"+$('#name'+bagid).text().trim()+"' style='width: 70%;' disabled='disabled'/>");
}

function bag_rename(bag_id) {
	var v_name = $('#bag_name').val();

	jConfirm('Are you sure you want to rename this bag to \"'+v_name+'\"?', 'Save Bag Product', function(r) {
		if (r) {
		$.post('/pantry/bag/ajax/bag/save', { bagid: bag_id, name: v_name },
			function(data){
				bag_products_load(bagid);
			});
		} else {
			bag_products_load(bagid);
		}
	});
}

function bag_products_load(id) {
	$('#bag_products').load('/pantry/bag/render/bag_products/'+id);
}

function product_list_load() {
	var data;
	$.get('/pantry/inventory/ajax/list', function(products) {
		data = products.split(";");
		$(document).ready(function(){
			$("#product").autocomplete(data);
		});	
	});
}

function bag_product_delete(bag_id, product_id) {
	var stop = false;

	jConfirm('Are you sure you want to remove this product from the bag?', 'Remove Product From Bag', function(r) {
		if (r) {
		$.post('/pantry/bag/ajax/bag_products/delete', { bagid: bag_id, productid: product_id },
			function(data){
				bag_products_load(bag_id);
			});
		}
	});
}

function bag_product_edit(bagid, productid) {
	// convert edit button to save
	$('#edit'+productid).html("<a href='#' onclick='bag_product_save(\""+bagid+"\", \""+productid+"\"); return false;'><img src='/pantry/images/save.png'/></a>");
// <input type='submit' value='Save' onClick='bag_product_save(\""+bagid+"\", \""+productid+"\"); return false;' style='width: 25%; padding: 0px;'/> 
	$('#name'+productid).html("<input id='edit_name"+productid+"' value='"+$('#name'+productid).text().trim()+"' style='width: 70%;' disabled='disabled'/>");
	$('#quantity'+productid).html("<input id='edit_quantity"+productid+"' value='"+$('#quantity'+productid).text().trim()+"' style='width: 100%;' />");
	var yes = '';
	var no = '';
	if ($('#choice'+productid).text().trim() == 'Yes') {
		yes = ' selected';
	} else if ($('#choice'+productid).text().trim() == 'No') {
		no = ' selected';
	}
	
	var choice_html = "<select id='edit_choice"+productid+"' style='width: 100%;'><option value='1'"+yes+">Yes</option><option value='0'"+no+">No</option></select>";
	$('#choice'+productid).html(choice_html);
	$('#notes'+productid).html("<input type='text' id='edit_notes"+productid+"' value='"+$('#notes'+productid).text().trim()+"' style='width: 100%;' />");
}

function bag_product_save(bagid, productid) {
	var v_name = $('#edit_name'+productid).val();
	var v_quantity = $('#edit_quantity'+productid).val();
	var v_choice = $('#edit_choice'+productid).val();
	var v_notes = $('#edit_notes'+productid).val();


	jConfirm('Are you sure you want to save these bag product changes?', 'Save Bag Product', function(r) {
		if (r) {
		$.post('/pantry/bag/ajax/bag_products/save', { bid: bagid, pid: productid, quantity: v_quantity, choice: v_choice, notes: v_notes },
			function(data){
				bag_products_load(bagid);
			});
		} else {
			bag_products_load(bagid);
		}
	});
}

function add_product(bag_id)
{
	var v_product_name = $('#product').val();
	
	$.post('/pantry/bag/ajax/bag_products/add', { bagid: bag_id, product_name: v_product_name },
			function(data){
				if(data == 'NOT_SET')
					add_product_to_inventory(bag_id, v_product_name);
				bag_products_load(bag_id);
			});
}

function add_product_to_inventory(bag_id, v_product_name)
{
	jConfirm("No product in inventory exists called \""+v_product_name+"\" would you like it create and add this product to the inventory and add to current bag?", "Add Product to Inventory?",
				function (r) {
					if(r) {
						$.post('/pantry/inventory/save', { name: v_product_name, quantity: '0' }, function(data) { 
							$.post('/pantry/bag/ajax/bag_products/add', { bagid: bag_id, product_name: v_product_name }, function(data) {
								bag_products_load(bag_id);
								product_list_load();
							});
						});
					} 
				});
}