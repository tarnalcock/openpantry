<div style="float: left; width: 100%; margin-bottom: 10px;">
	<div style="float: left; padding-left: 10px;">
		<img src="<%%ABSURL%%>/images/PackageIcon.png" />
	</div>
	<div style="float: left; padding-left: 10px;">
		<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
			Delivery Sign In
		</div>
		<div>
		  <b class="spiffy">
		  <b class="spiffy1"><b></b></b>
		  <b class="spiffy2"><b></b></b>
		  <b class="spiffy3"></b>
		  <b class="spiffy4"></b>
		  <b class="spiffy5"></b></b>

		  <div class="spiffyfg">
			Search: <input type="text" id="filter" onKeyUp="client_filter();" style="width: 330px; margin-right: 6px;" />
		  </div>

		  <b class="spiffy">
		  <b class="spiffy5"></b>
		  <b class="spiffy4"></b>
		  <b class="spiffy3"></b>
		  <b class="spiffy2"><b></b></b>
		  <b class="spiffy1"><b></b></b></b>
		</div>
	</div>
</div>

<!-- Make select all checkbox function using jQuery -->
<script>
$(function () { 
	$('.checkall').click(function () {
		$(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
})
</script>

<fieldset>
<table class="family_list" style="margin-top: -20px;">
	<tr>
		<td></td>
		<td colspan="8" style="background-color: white;">
			<img src="<%%ABSURL%%>/images/help_delivery_signin.png" />
		</td>
	</tr>
	<tr>
		<th style="width: 21px;">
			<input type="checkbox" name="checkall" id="checkall" value="checkall" class="checkall"/>
		</th>
		<th style="width: 21px;">
			
		</th>
		<th>
			Last
		</th>
		<th>
			First
		</th>
		<th>
			Size
		</th>
		<th>
			Address
		</th>
		<th>
			Telephone
		</th>
		<th>
			Start Date
		</th>
		<th>
			Bag
		</th>
		<th>
			Comments
		</th>
	</tr>
	<%%families%%>
</table>
</fieldset>

<br/>		  
<table class="family_list">
	<tr><td></td></tr>
	<tr><td>
		<input type="submit" onClick="page_clean(); doSelectedDeliveries(); return false;" value="Complete Selected Deliveries" style="font-weight: bold;" />	
	</td></tr>
</table>