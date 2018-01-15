<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Ripple XRP Transaction & Account Explorer Tools</title>
	
			<?php include 'headerScripts.php';?>
	
			<!-- canonical -->
			<link rel="canonical" href="https://explorer.cm.org.uk/" />
			<!-- /canonical -->
	</head>

	<body class="home">

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/"><img class="pull-left" src="//cmk-colinmcdermott.netdna-ssl.com/wp-content/uploads/2018/01/cm-logo2-300x300.png" style="width:42px !important;" /></a>
					<ul class="nav pull-right">
					<li><a href="https://cm.org.uk/" class="a-1">Home<br></a></li>
					</ul>
				</div>
			 </div>
		</div>

		<div class="container-fluid container container-fluid-1" id="firstcont">

			<div class="container-fluid" style="text-align:center;">

				<h1 id="entercomp">Ripple XRP Transaction lookup tool</h1>

				<form method="get" action="transaction.php?<?php echo $_get["hash"];?>">
					<input placeholder="Enter Transaction Hash / ID" type="text" name="hash" class="textinput" style="width:355px !important;">
					<button class="btn btn-primary btn-large whois" type="submit">Submit</button>
				</form>
				
				<h2>Account / Wallet Address lookup tool</h2>
				
				<form method="get" action="account.php?<?php echo $_get["accountAddress"];?>">
					<input placeholder="Enter Account Address" type="text" name="accountAddress" class="textinput" style="width:355px !important;">
					<button class="btn btn-primary btn-large whois" type="submit">Submit</button>
				</form>

			</div>

			<div class="container-fluid" id="innercont">
				<h5>Ripple XRP Transaction & Account lookup tools.</h5>
				<h5>Data is pulled live from the XRP ledger using the <a href="https://ripple.com/build/data-api-v2/" target="_blank">Ripple Data API v2</a>.</h5>
			</div>

		</div>

		<style>
		button.btn-primary {background:#22a1c4 !important;}
		</style>
		
		

<?php include 'footer.php';?>

	</body>
</html>