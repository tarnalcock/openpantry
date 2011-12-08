<!--<form method="post" action="<%%ABSURL%%>/bag/edit/<%%id%%>">-->
<script>
product_list_load();
</script>

<form id="frmEdit" method="POST" action="<%%ABSURL%%>/bag/edit/<%%id%%>">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="<%%ABSURL%%>/images/bag.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				Edit Bag
			</div>
			<div style="width: 130px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-e">
				<input type="submit" onClick="page_clean();" value="Save Bag" style="font-weight: bold;"/>
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

	<table class="client_new">
		<tr>
			<th colspan="2">Edit Bag</th>
		</tr>
		<tr class="row1">
			<td>
				Name
			</td>
			<td>
				<input id="bag_name" name="bag_name" type="text" value="<%%name%%>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="background-color: white;">
				<img src="<%%ABSURL%%>/images/help_product_add.png" />
			</td>
		</tr>
		<tr>
			<th colspan="2">Add Product</th>
		</tr>
		<tr>
			<td>
				<input type="text" id="product" name="product"/>
			</td>
			<td>
				<input type="button" value="Add Product" onClick="add_product('<%%id%%>');"/>
			</td>
		</tr>
	</table>
	
	<table class="client_new">
		<tr>
			<th>Food Source</th>
			<th>Weight</th>
			<th>Cost</th>
		</tr>
		<%%foodsources%%>
	</table>
</form>