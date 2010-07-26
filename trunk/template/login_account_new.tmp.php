<form method="post" action="/pantry/login/register">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="/pantry/images/family.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				New Account
			</div>
			<div style="width: 130px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-e">
				<input type="submit" onClick="page_clean();" value="Create" style="font-weight: bold;"/>
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
	
	<input type="hidden" name="did_submit" value="yes"/>
	<table class="client_new">
		<tr class="row1">
			<td>
				Username
			</td>
			<td>
				<input name="username" type="text" />
			</td>
		</tr>
		<tr class="row1">
			<td>
				Password
			</td>
			<td>
				<input name="password" type="password" />
			</td>
		</tr>
		<tr class="row1">
			<td>
				Confirm Password
			</td>
			<td>
				<input name="password_confirm" type="password" />
			</td>
			<td width="100%">
				<span style="color:red;"><%%mismatch%%></span>
			</td>
		</tr>
		<tr class="row1">
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
		<tr class="row1">
			<td>
				Email
			</td>
			<td>
				<input name="email" type="text" />
			</td>
		</tr>
	</table>
</form>