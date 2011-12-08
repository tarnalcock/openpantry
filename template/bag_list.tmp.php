<div style="float: left; width: 100%; margin-bottom: 10px;">
	<div style="float: left; padding-left: 10px;">
		<img src="<%%ABSURL%%>/images/bag.png" />
	</div>
	<div style="float: left; padding-left: 10px;">
		<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
			Manage Bag List
		</div>
		<div>
		  <b class="spiffy">
		  <b class="spiffy1"><b></b></b>
		  <b class="spiffy2"><b></b></b>
		  <b class="spiffy3"></b>
		  <b class="spiffy4"></b>
		  <b class="spiffy5"></b></b>

		  <div class="spiffyfg">
			Search: <input type="text" id="filter" onKeyUp="client_filter();" style="width: 330px;" />
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

<table class="family_list" style="margin-top: -20px;">
	<tr>
		<td colspan="8" style="background-color: white; padding-left: 14px;">
			<img src="<%%ABSURL%%>/images/help_edit_delete.png" />
		</td>
	</tr>
	<tr>
		<th style="width: 21px;">
			
		</th>
		<th style="width: 21px;">
			
		</th>
		<th>
			Name
		</th>
		<th>
			Clients
		</th>
		<th>
			Items
		</th>
		<th>
			Weight
		</th>
		<th>
			Cost
		</th>
	</tr>
	<%%bags%%>
</table>