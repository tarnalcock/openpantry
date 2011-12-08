				<div class="banner">
					<img src="<%%ABSURL%%>/images/banner.png" />
					<span style="position: absolute; top: 1em; right: 1em;">
						<a style="color:white;" href="<%%ABSURL%%>/login/signout">Log Out</a>
					</span>
				</div>
				<div class="header_menu">
					&nbsp;
				
				<ul id="sample-menu-1" class="sf-menu">
					<li class="current">
						<a href="<%%ABSURL%%>/home">Home</a>
					</li>
					<li class="current">
						<a href="<%%ABSURL%%>/client">Food</a>
						<ul>
							<li>
								<a href="<%%ABSURL%%>/client/pickups">Pickups</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/client/deliveries">Deliveries</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/client/dropoffs">Drop Offs</a>
							</li>
							<li>
								<a style="border-top: 3px solid #CFDEFF;" href="<%%ABSURL%%>/client/family">All Records</a>
							</li>
						</ul>
					</li>
					
					<li>
						<a href="<%%ABSURL%%>/client">Clients</a>
						<ul>
							<li>
								<a href="<%%ABSURL%%>/client/new">New Family</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/client/family">Family List</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#">Inventory</a>
						<ul>
							<li>
								<a href="<%%ABSURL%%>/bag/new">New Bag</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/bag/list">Bag List</a>
							</li>
							<li>
								<a style="border-top: 3px solid #CFDEFF;" href="<%%ABSURL%%>/inventory/new">New Product</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/inventory/list/">Product List</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Reporting</a>		
						<ul>
							<li>
								<a href="<%%ABSURL%%>/reporting/msr">MSR Summary</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/reporting/clients">Active Clients</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/reporting/products">Grocery List</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/reporting/food_sources">Food Source Distribution</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/reporting/usda">USDA Sign In Sheet</a>
							</li>
						</ul>

					</li>
					<li>
						<a href="#">Settings</a>
						<ul>
							<li>
								<a href="<%%ABSURL%%>/aid/list">Financial Aids</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/foodsource/list">Food Sources</a>
							</li>
							<li>
								<a href="<%%ABSURL%%>/login/accounts">Accounts</a>
							</li>
						</ul>
					</li>
				</ul>
				
				</div>

				<script>
					$("ul.sf-menu").superfish();
				</script>