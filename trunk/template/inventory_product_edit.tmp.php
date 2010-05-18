<form method="post" action="/pantry/inventory/edit/<%%id%%>">
	<table class="client_new">
		<tr>
			<td colspan="2" style="border: 0px;">
				<input type="submit" value="Save" />				
			</td>
		</tr>
		<tr class="row1">
			<td>
				Name
			</td>
			<td>
				<input name="name" type="text" value="<%%name%%>"/>
			</td>
		</tr>
		<tr class="row2">
			<td>
				Quantity
			</td>
			<td>
				<input name="quantity" type="text" value="<%%quantity%%>"/>
			</td>
		</tr>
	</table>
</form>