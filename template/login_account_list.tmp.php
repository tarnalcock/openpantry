<form method="post" action="<%%ABSURL%%>/login/accounts">

	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="<%%ABSURL%%>/images/family.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				Manage Accounts
			</div>
			<input type="button" onClick="window.location='/pantry/login/register';" value="Create Account" style="font-weight: bold;"/>
		</div>
	</div>
</form>
<table class="family_list">
	<tr>
		<th style="width: 21px;">
		</th>
		<th style="width: 21px;">
		</th>
		<th>
			Username
		</th>
		<th>
			First Name
		</th>
		<th>
			Last Name
		</th>
		<th>
			Email
		</th>
		<th>
			Access
		</th>
	</tr>
	<%%accounts%%>
</table>