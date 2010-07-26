<form method="post" action="/pantry/login/accounts/edit/<%%id%%>">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="/pantry/images/family.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				Edit Account
			</div>
			<div style="width: 316px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-b">
				<input type="submit" onClick="page_clean();" value="Save Account" style="font-weight: bold;"/>
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
	<input type="hidden" name="userid" value="<%%id%%>" />
	<table class="client_new">
		<tr class="row1">
			<td>
				Username
			</td>
			<td>
				<input name="username" type="text" value="<%%username%%>"/>
			</td>
		</tr>
		<tr class="row1">
			<td>
				Password
			</td>
			<td>
				<input name="change_password" type="button" value="Change Password"/>
			</td>
		</tr>
		<tr class="row1">
			<td>
				First Name
			</td>
			<td>
				<input name="lastname" type="text" value="<%%firstname%%>"/>
			</td>
		</tr>
		<tr class="row1">
			<td>
				Last Name
			</td>
			<td>
				<input name="firstname" type="text" value="<%%lastname%%>"/>
			</td>
		</tr>
		<tr class="row1">
			<td>
				Email
			</td>
			<td>
				<input name="email" type="text" value="<%%email%%>"/>
			</td>
		</tr>
	</table>
</form>