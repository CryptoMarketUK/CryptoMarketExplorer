<?php

$_GET["accountAddress"] = preg_replace('/[^a-z0-9]+/i', '_', $_GET["accountAddress"]);

$accountID = $_GET["accountAddress"];

$baseUrl = 'https://data.ripple.com/v2/accounts/';

$balanceAddon = '/balances?currency=XRP';

$accountUrl = $baseUrl . $accountID . $balanceAddon;

$c = curl_init();
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
curl_setopt($c, CURLOPT_URL, $accountUrl);

$json = curl_exec($c);
curl_close($c);

$json = json_decode($json, true);

$resultFront = $json['result'];
$ledger_indexFront = $json['ledger_index'];
$XRPFront = $json['balances'][0]['value'];

$canonical ='<link rel="canonical" href="https://explorer.cm.org.uk/account/' . $accountID . '/" />';
$canonicalurlonly = 'https://explorer.cm.org.uk/account/' . $accountID . '/';
$noindex = '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';

?>

<!DOCTYPE HTML><html lang="en">
<head>

<title>
	<?php
	if(empty($accountID)) {
	  echo 'Error';
	} else {
	  echo 'Account Address: ' . $accountID . ' - Ripple XRP Account Explorer';
	};
	?>
</title>

<?php include 'headerScripts.php';?>

<!-- canonical -->
<?php
if (strpos($resultFront,'success') !== false) {
  echo $canonical;
} else {
  echo $noindex;
};
?>
<!-- /canonical -->
</head>
<body class="account">

<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
<a class="brand" href="/"><img class="pull-left" src="//cmk-colinmcdermott.netdna-ssl.com/wp-content/uploads/2018/01/cm-logo2-300x300.png" style="width:42px !important;" /></a>
        <ul class="nav pull-right">
          <li><a href="https://cm.org.uk/" class="a-1">Home<br></a>
          </li>
        </ul>
      </div>
      </div>
    </div>

<div class="container-fluid container container-fluid-1" id="firstcont">

	<div class="container-fluid" style="text-align:center;">
	
	<h2 style="text-transform: capitalize; margin-bottom:32px;"><?php
if (strpos($resultFront,'success') !== false) {
    echo '<span style="height:0.8em;width:0.8em; background-color:LightGreen;border-radius: 50%; display:inline-block; position: relative;top: 2px;" title="Success"> </span>';
} else {
    echo '<span style="height:0.8em;width:0.8em; background-color:Red;border-radius: 50%; display:inline-block; position: relative;top: 2px;" title="Error"> </span>';
};?> <?php echo $resultFront;?></h2>

<div>
		<?php
			if (strpos($resultFront,'success') !== false) {
				echo  '<p style="text-align:center !important;" class="alert alert-success"><em>' . $accountID . '</em> is a valid Ripple XRP wallet address.</p>';}
			else {
				echo '<p style="text-align:center !important;" class="alert alert-error">This address does not exist or has not yet been activated. <a href="https://cm.org.uk/coin/ripple-account-activation/?' . $accountID . '">Click here to activate this account<a/>.</p>';
		};?>
</div>

<?php
if (strpos($resultFront,'success') !== false) {
    echo '<div class="btn-group" style="margin:15px 0 5px 0;"><a class="btn" href="/">New Search</a><a class="btn" href="http://cm.org.uk/coins/ripple/">Send XRP to this address</a><a class="btn" href="' . $accountUrl . '" target="blank" rel="nofollow noopener">View Raw JSON</a><a class="btn" href="javascript:window.print()">Print</a></div>';
} else {
    echo '<div class="btn-group" style="margin:15px 0 5px 0;"><a class="btn" href="/">New Search</a><a class="btn" href=""https://cm.org.uk/coin/ripple-account-activation/?' . $accountID . '">Activate this account</a><a class="btn" href="' . $accountUrl . '" target="blank" rel="nofollow noopener">View Raw JSON</a></div>';
};?>

	

	
<?php
if (strpos($resultFront,'success') !== false) {
	
	echo '<div class="well" style="margin-top:26px;">';
	echo '<div style="text-align:left;">';
	
	echo '<ul class="transResults" style="list-style:none;">';
	echo '<li style="text-transform: capitalize">Result: ' . $resultFront . '</li>';
	echo '<li>XRP Balance: ' . $XRPFront . '</li>';
	echo '<li>Ledger Index: ' . $ledger_indexFront . '</li>';
	echo '<li>Account address: <a href="' . $canonicalurlonly . '">' . $accountID . '</a></li>';
	echo '<li>Raw: <a href="' . $accountUrl . '" target="_blank" rel="nofollow noopener">JSON</a></li>';
	echo '</ul>';
	
	echo '</div>';
	echo '</div>';
	
} else {
	echo '<div class="well" style="margin-top:26px;">';
	echo '<div style="text-align:left;">';
	
	echo '<ul class="transResults" style="list-style:none;">';
	echo '<li style="text-transform: capitalize">Result: ' . $resultFront . '</li>';
	echo '<li>Account address: <a href="' . $canonicalurlonly . '">' . $accountID . '</a></li>';
	echo '<li>Raw: <a href="' . $accountUrl . '" target="_blank" rel="nofollow noopener">JSON</a></li>';
	echo '</ul>';
	
	echo '</div>';
	echo '</div>';
};
?>



	<div style="font-style:italic; margin-top:30px;">
		<p>This web service is hosted by <a href="https://cm.org.uk/">Crypro Market</a>.</p>

		<p>Data is pulled live from the XRP ledger using the <a href="https://ripple.com/build/data-api-v2/" target="_blank" rel="noopener">Ripple Data API v2</a>.</p>

		<p>Usage of this tool and the Ripple API may be subject to fair usage limits. Please feel free to use this service but avoid bulk requests.</p>

		<p>You can view our <a href="https://cm.org.uk/terms-privacy/">privacy policy here</a>.</p>
	</div>
	

</div>

<style>
ul.transResults li {margin: 5px 0 15px 0 !important;}
</style>



<?php include 'footer.php';?>

</body>
</html>