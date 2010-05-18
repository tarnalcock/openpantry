<form method="post" action="/pantry/client/edit/<%%id%%>">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="/pantry/images/family.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				Edit Client
			</div>
			<div style="width: 316px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-b">
				<input type="submit" onClick="page_clean();" value="Save Client" style="font-weight: bold;"/>
				<input type="submit" onClick="page_clean(); client_pickup('<%%delivery%%>', '<%%id%%>'); return false;" value="Complete Sign-In" />	
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
				Client Information
			</th>
		</tr>
		<tr class="row1">
			<td>
				Bag Type
			</td>
			<td>
				<select onChange="page_mud();" name="bag">
					<%%bags%%>
				</select>
			</td>
		</tr>
		<tr class="row2">
			<td>
				First Name
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="first_name" type="text" value="<%%first_name%%>" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Last Name
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="last_name" type="text" value="<%%last_name%%>" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Gender
			</td> 
			<td>
				<select name="gender" onChange="page_mud();">
					<option value="1" <%%male%%>>Male</option>
					<option value="0" <%%female%%>>Female</option>
				</select>
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Date of Birth
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="dob" type="text" value="<%%dob%%>" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Active
			</td> 
			<td>
				<input onChange="page_mud();" name="active" type="checkbox" value="true" <%%active%%>/>
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Address
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="address" type="text" value="<%%address%%>" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Telephone
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="telephone" type="text" value="<%%telephone%%>" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Fuel Assistance
			</td> 
			<td>
				<input onChange="page_mud();" name="fuel" type="checkbox" value="true" <%%fuel%%>/>
			</td> 
		</tr>
		<tr class="row2">
			<td>
				USDA Assistance
			</td> 
			<td>
				<input onChange="page_mud();" name="usda" type="checkbox" value="true" <%%usda%%>/>
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Delivery
			</td> 
			<td>
				<input onChange="page_mud();" name="delivery" type="checkbox" value="true" <%%delivery%%>/>
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Dietary Restriction
			</td> 
			<td>
				<input onChange="page_mud();" name="dietary" type="checkbox" value="true" <%%dietary%%>/>
			</td> 
		</tr>
		<tr class="row1">
			<td>
				2nd of the month
			</td> 
			<td>
				<input onChange="page_mud();" name="2nd" type="checkbox" value="true" <%%second%%>/>
			</td> 
		</tr>
		<tr class="row2">
			<td>
				4th of the month
			</td> 
			<td>
				<input onChange="page_mud();" name="4th" type="checkbox" value="true" <%%fourth%%>/>
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Cooking Facilities: 
			</td> 
			<td>
				<input onChange="page_mud();" name="cooking" type="checkbox" value="true" <%%cooking%%>/>
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Start Date: 
			</td> 
			<td>
				<input onKeyDown="page_mud();" name="start" type="text" value="<%%start%%>" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Comments: 
			</td> 
			<td>
				<textarea onKeyDown="page_mud();" name="comments" type="checkbox"><%%comments%%></textarea>
			</td>
		</tr>
	</table>
	<table class="client_new">
		<tr>
			<th colspan="2" style="border: 0px; font-weight: bold; font-size: 16px;">
				Other Family Members
			</th>
		</tr>
		<tr class="row2">
			<td colspan="2" id="family_members" style="padding: 0px; border-bottom: 0px;">
			</td>
		</tr>
		<tr class="row1">
			<td style="border-top: 0px;">
				Name
			</td> 
			<td style="border-top: 0px;">
				<input id="name" type="text" />
			</td> 
		</tr>
		<tr class="row2">
			<td>
				Date of Birth
			</td> 
			<td>
				<input id="dob" type="text" value="YYYY-MM-DD" />
			</td> 
		</tr>
		<tr class="row1">
			<td>
				Gender
			</td> 
			<td>
				<select id="gender">
					<option value="1" selected>Male</option>
					<option value="0">Female</option>
				</select>
			</td> 
		</tr>
		<tr>
			<td colspan="2" style="border: 0px; text-align: right;">
				<input type="submit" onClick="client_family_members_new('<%%id%%>'); return false;" value="Add Member" />				
			</td>
		</tr>
	</table>
	<table class="client_new">
		<tr>
			<th colspan="3" style="border: 0px; font-weight: bold; font-size: 16px;">
				Financial Aid
			</th>
		</tr>
<%%aids%%>
	</table>
	<script>
		client_family_members_load('<%%id%%>');
	</script>
</form>