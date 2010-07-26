function client_filter() {
	var pattern = $("#filter").val();
	var patterns = pattern.split(' ');
	var table = $("table.family_list");
	
	var toggle = true;
	var tr = table.find("tr");
	for (var i = 2; i < tr.length; i++) {
		var td = tr[i].children;
		var first_name = td[1].firstChild.textContent;
		var last_name = td[2].firstChild.textContent;
		var found = false;
		
		for (var p in patterns) {
			if (first_name.toLowerCase().indexOf(patterns[p].toLowerCase()) != -1 ||
				last_name.toLowerCase().indexOf(patterns[p].toLowerCase()) != -1|| pattern.length == 0) {
				found = true;
			}
		}
		
		if (found) {
			tr[i].style.display = '';
			var bgc = tr[i].style.backgroundColor;
			if (bgc != 'rgb(107, 186, 112)' && bgc != 'rgb(255, 255, 136)' && bgc != 'rgb(255, 0, 0)') {
				if (toggle) {
					tr[i].style.backgroundColor = '#dce9ff';
				} else {
					tr[i].style.backgroundColor = '#f2f7ff';
				}
			}
			
			toggle = !toggle;
		} else{
			tr[i].style.display = 'none';
		}
	}
}

function client_pickup(delivery, id) {
	if (delivery == ' checked') {
		window.location = '/pantry/client/deliveries/'+id;
	} else {
		window.location = '/pantry/client/pickups/'+id;
	}
}

function client_family_members_load(id) {
	$('#family_members').load('/pantry/client/render/family_members/'+id);
}

function client_family_members_new(clientid) {
	var v_name = $('#name').val();
	var v_dob = $('#dob').val();
	var v_gender = $('#gender').val();
	
	$.post('/pantry/client/ajax/family_members/new', { id: clientid, name: v_name, dob: v_dob, gender: v_gender },
		function(data){
			client_family_members_load(clientid);
		});
}

function client_family_members_delete(clientid, familyid) {
	var stop = false;

	jConfirm('Are you sure you want to delete this member?', 'Delete Family Member', function(r) {
		if (r) {
		$.post('/pantry/client/ajax/family_members/delete', { id: clientid },
			function(data){
				client_family_members_load(familyid);
			});
		}
	});
}

function client_family_members_edit(clientid, familyid) {
	$('#edit'+clientid).html("<a href='#' onClick='client_family_members_save(\""+clientid+"\", \""+familyid+"\"); return false;'><img src='/pantry/images/save.png'/></a>");
	$('#name'+clientid).html("<input id='edit_name"+clientid+"' value='"+$('#name'+clientid).text().trim()+"' style='width: 100%;' />");
	$('#dob'+clientid).html("<input id='edit_dob"+clientid+"' value='"+$('#dob'+clientid).text().trim()+"' style='width: 100%;' />");
	var male = '';
	var female = '';
	if ($('#gender'+clientid).text().trim() == 'Male') {
		male = ' selected';
	} else if ($('#gender'+clientid).text().trim() == 'Female') {
		female = ' selected';
	}
	var gender_html = "<select id='edit_gender"+clientid+"' style='width: 100%;'><option value='1'"+male+">Male</option><option value='0'"+female+">Female</option></select>";
	$('#gender'+clientid).html(gender_html);
}

function client_family_members_save(clientid, familyid) {
	var v_name = $('#edit_name'+clientid).val();
	var v_dob = $('#edit_dob'+clientid).val();
	var v_gender = $('#edit_gender'+clientid).val();

	jConfirm('Are you sure you want to save this member?', 'Save Family Member', function(r) {
		if (r) {
		$.post('/pantry/client/ajax/family_members/save', { id: clientid, name: v_name, dob: v_dob, gender: v_gender },
			function(data){
				client_family_members_load(familyid);
			});
		} else {
			client_family_members_load(familyid);
		}
	});
	

}

function client_transaction_delete(clientid, transaction_id, date) {
	var stop = false;
	
	jConfirm('Are you sure you want to delete this client transaction?<br/><center><strong>Date:'+date+'</strong></center>', 'Delete Client Transaction', function(r) {
		if (r) {
		$.post('/pantry/client/ajax/transactions/delete', { transactionid: transaction_id },
			function(data){
				window.location = '/pantry/client/pickups/'+clientid;
			});
		}
	});
}

function page_mud() {
	page_dirty = true;
}

function page_clean() {
	page_dirty = false;
}

function goodbye(e) {
	if (!page_dirty) return;
	
	var done = false;
	var stop = false;
	
	/*jConfirm('There are unsaved changes.  Are you sure you want to leave the page?', 'Unsaved Changes', function(r) {
		if (r) {
			stop = false;
		} else {
			stop = true;
		}
	});*/
	//jConfirm('something');
	
	if (stop) return;
	
	//if(!e) e = window.event;
	//e.cancelBubble is supported by IE - this will kill the bubbling process.
	//e.cancelBubble = true;
	e.returnValue = 'There are unsaved changes.'; //This is displayed on the dialog

	//e.stopPropagation works in Firefox.
	if (e.stopPropagation) {
		e.stopPropagation();
		e.preventDefault();
	}
}
var page_dirty = false;
window.onbeforeunload=goodbye;