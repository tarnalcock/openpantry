<form method="post" action="<%%ABSURL%%>/foodsource/save">
	<div style="float: left; width: 100%; margin-bottom: 10px;">
		<div style="float: left; padding-left: 10px;">
			<img src="<%%ABSURL%%>/images/source.png" />
		</div>
		<div style="float: left; padding-left: 10px;">
			<div style="font-family: georgia; font-size: 36px; margin-bottom: 10px;">
				Manage Food Sources
			</div>
			<div>
			  <b class="spiffy">
			  <b class="spiffy1"><b></b></b>
			  <b class="spiffy2"><b></b></b>
			  <b class="spiffy3"></b>
			  <b class="spiffy4"></b>
			  <b class="spiffy5"></b></b>

			  <div class="spiffyfg">
				Name: <input type="text" name="name" style="width: 180px;" /> <input type="submit" value="Add Food Source"/>
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
</form>
<table class="family_list">
	<tr>
		<th style="width: 21px;">
		</th>
		<th style="width: 21px;">
			
		</th>
		<th>
			Food Source
		</th>
	</tr>
	<%%foodsources%%>
</table>