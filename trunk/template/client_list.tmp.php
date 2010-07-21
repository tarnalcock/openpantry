<div style="float: left; width: 100%; margin-bottom: 10px;">
	<div style="float: left; padding-left: 10px;">
		<img src="/pantry/images/family.png" />
	</div>
	<div style="float: left; padding-left: 10px;">
		<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
			Manage Client List
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

<table class="family_list" style="margin-top: -16px;">
	<tr>
		<td colspan="8" style="background-color: white;">
			<img src="/pantry/images/help_family_edit.png" />
		</td>
	</tr>
	<tr>
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
			Comments <%%comments_hide_show%%>
		</th>
	</tr>
	<%%families%%>
</table>