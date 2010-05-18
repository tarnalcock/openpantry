<form id='drop' method="post" action="/pantry/client/dropoffs">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="/pantry/images/truck.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				New Drop Off
			</div>
			<div style="width: 207px;">
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg-g">
				<input type="submit" onClick="page_clean(); doDropoff('drop'); return false;" value="Complete Drop Off" style="font-weight: bold;"/>
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

	<table class="client_new">
		<tr>
			<th>Food Source</th>
			<th>Weight</th>
			<th>Cost</th>
		</tr>
		<%%foodsources%%>
	</table>
	<input type="hidden" name="did_submit" value="yes" />
</form>