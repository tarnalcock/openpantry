<form method="post" action="<%%ABSURL%%>/bag/save">
	<tr class="<%%class%%>">
		<td id="delete<%%id%%>">
			<a href="#" onclick="inventory_delete('<%%id%%>'); return false;"><img src="<%%ABSURL%%>/images/delete.png" /></a>
		</td>
		<td id="edit<%%id%%>">
			<a href="#" onclick="inventory_edit('<%%id%%>'); return false;"><img src="<%%ABSURL%%>/images/edit.png" /></a>
		</td>
		<td id="name<%%id%%>">
			<%%name%%>
		</td>
		<td id="quantity<%%id%%>">
			<%%quantity%%>
		</td>
	</tr>
</form>