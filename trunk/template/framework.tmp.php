<html>
	<head>
		<title>
			<%%page_title%%>
		</title>
<%%css_include%%>
<%%js_include%%>
<script>
	// initialise plugins
	jQuery(function(){
		jQuery('ul.sf-menu').superfish();
	});
</script>
	</head>
	<body>
		<table class="framework" cellspacing="0px" cellpadding="0px">
			<tr>
				<!-- tier 1 logo + search -->
				<td class="tier">
<%%tier_1%%>
				</td>
			</tr>
			<tr>
				<!-- tier 2 content -->
				<td class="tier">
<%%tier_2%%>
				</td>
			</tr>
			<tr>
				<!-- tier 3 footer -->
				<td class="tier">
<%%tier_3%%>
				</td>
			</tr>
		</table>
	</body>
</html>