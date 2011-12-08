<form method="post" action="<%%ABSURL%%>/login/accounts/change_password/<%%id%%>">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="<%%ABSURL%%>/images/family.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				Change Password
			</div>
			<div style="width: 316px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-b">
				<input type="submit" onClick="page_clean();" value="Change Password" style="font-weight: bold;"/>
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
	<span style="color: red;"><%%error%%></span>
	<table class="client_new">
		<tr class="row1">
			<td>
				Username:
			</td>
			<td>
				<%%username%%>
			</td>
		</tr>
		<tr class="row1">
			<td>
				Old Password
			</td>
			<td>
				<input name="old_password" type="text"/>
			</td>
		</tr>
		<tr class="row1">
			<td>
				New Password
			</td>
			<td>
				<input name="new_password" type="password"/>
			</td>
		</tr>
		<tr class="row1">
			<td>
				Confirm New Password
			</td>
			<td>
				<input name="new_password_confirm" type="password"/>
			</td>
		</tr>
	</table>
</form>