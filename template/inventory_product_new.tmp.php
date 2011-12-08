<form method="post" action="<%%ABSURL%%>/inventory/save">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="<%%ABSURL%%>/images/product.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				New Product
			</div>
			<div style="width: 160px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-f">
				<input type="submit" onClick="page_clean();" value="Save Product" style="font-weight: bold;"/>
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
		<tr class="row1">
			<th colspan="2">
				Create New Product
			</th>
		</tr>
		<tr class="row1">
			<td>
				Name
			</td>
			<td>
				<input name="name" type="text" />
			</td>
		</tr>
		<tr class="row2">
			<td>
				Quantity
			</td>
			<td>
				<input name="quantity" type="text" />
			</td>
		</tr>
	</table>
</form>