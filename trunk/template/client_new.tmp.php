<form method="post" action="/pantry/client/new">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="/pantry/images/family.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				New Client
			</div>
			<div style="width: 140px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-c">
				<input type="submit" onClick="page_clean();" value="Save Client" style="font-weight: bold;"/>
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

	<input type="hidden" name="did_submit" value="yes" />
	<table class="client_new">
		<tr>
			<th colspan="2" style="border: 0px; font-weight: bold; font-size: 16px;">
				New Family				
			</th>
		</tr>
		<tr class="row1">
			<td>
				Bag Type
			</td>
			<td>
				<select>
					<%%bags%%>
				</select>
			</td>
		</tr>
		<tr class="row2">
			<td>
				First Name
			</td> 
			<td>
				<input name="first_name" type="text" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Last Name
			</td> 
			<td>
				<input name="last_name" type="text" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Gender
			</td> 
			<td>
				<select name="gender" onChange="page_mud();">
					<option value="1">Male</option>
					<option value="0">Female</option>
				</select>
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Date of Birth
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="dob" type="text" />
				<span>YYYY-mm-dd</span>
			</td>
		</tr>
		<tr class="row2">
			<td>
				Address
			</td> 
			<td>
				<input name="address" type="text" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Telephone
			</td> 
			<td>
				<input name="telephone" type="text" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Fuel Assistance
			</td> 
			<td>
				<input name="fuel" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				USDA Assistance
			</td> 
			<td>
				<input name="usda" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Delivery
			</td> 
			<td>
				<input name="delivery" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Dietary Restriction
			</td> 
			<td>
				<input name="dietary" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				2nd of the month
			</td> 
			<td>
				<input name="2nd" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				4th of the month
			</td> 
			<td>
				<input name="4th" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Cooking Facilities: 
			</td> 
			<td>
				<input name="cooking" type="checkbox" value="true" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Start Date: 
			</td> 
			<td>
				<input name="start" type="text" value="<?php echo date('Y-m-d'); ?>" />
				<span>YYYY-mm-dd</span>
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Comments: 
			</td> 
			<td>
				<textarea name="comments" type="checkbox"></textarea>
			</td>
		</tr>
	</table>
</form>