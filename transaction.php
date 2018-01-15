<?php

$_GET["hash"] = preg_replace('/[^a-z0-9]+/i', '_', $_GET["hash"]);

$hashID = $_GET["hash"];

$first64 = substr($hashID, 0, 64);

$upperCase = strtoupper ($first64);

$baseUrl = 'https://data.ripple.com/v2/transactions/';



$hashUrl = $baseUrl . $upperCase;

$c = curl_init();
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
curl_setopt($c, CURLOPT_URL, $hashUrl);

$json = curl_exec($c);
curl_close($c);

$json = json_decode($json, true);

$resultFront = $json['result'];
$hashFront = $json['transaction']['hash'];
$dateFront = $json['transaction']['date'];
$ledger_indexFront = $json['transaction']['ledger_index'];
$TransactionTypeFront = $json['transaction']['tx']['TransactionType'];
$FlagsFront = $json['transaction']['tx']['Flags'];
$SequenceFront = $json['transaction']['tx']['Sequence'];
$AmountPre = $json['transaction']['tx']['Amount'];
$FeePre = $json['transaction']['tx']['Fee'];
$AccountFront = $json['transaction']['tx']['Account'];
$DestinationFront = $json['transaction']['tx']['Destination'];
$TransactionResultFront = $json['transaction']['meta']['TransactionResult'];

$AmountDividedPre = $AmountPre / 1000000;
$AmountFront = number_format($AmountDividedPre, 6, '.', '');

$FeeDividedPre = $FeePre / 1000000;
$FeeFront = number_format($FeeDividedPre, 6, '.', '');

$canonical ='<link rel="canonical" href="https://explorer.cm.org.uk/transaction/' . $hashID . '/" />';
$canonicalurlonly = 'https://explorer.cm.org.uk/transaction/' . $hashID . '/';
$noindex = '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';

?>

<!DOCTYPE HTML><html lang="en">
<head>
<title>
	<?php
	if(empty($hashID)) {
	  echo 'Error';
	} else {
	  echo 'Transaction: ' . $hashID . ' - Ripple XRP Transaction Explorer';
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
<body class="transaction">

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

<?php
if (strpos($resultFront,'success') !== false) {
  echo '<p style="text-align:center !important;" class="alert alert-success"><em>' . $hashFront . '</em> is a valid XRP transaction hash.</p><h5>Key stats:</h5><p style="text-align:center !important;">Amount:' . $AmountFront . ' &nbsp; Type: ' . $TransactionTypeFront . '</p>';
} else {
  echo '<p style="text-align:center !important;" class="alert alert-error">Please try again making sure to enter a valid XRP transaction hash.</p>';
};
?>


<?php
if (strpos($resultFront,'success') !== false) {
    echo '<div class="btn-group" style="margin:15px 0 5px 0;"><a class="btn" href="/">New Search</a><a class="btn" href="/account/' . $AccountFront . '/">View Sending Account</a><a class="btn" href="/account/' . $DestinationFront . '/">View Destination</a><a class="btn" href="' . $hashUrl . '" target="blank" rel="nofollow noopener">View Raw JSON</a><a class="btn" href="javascript:window.print()">Print</a></div>';
} else {
    echo '<div class="btn-group" style="margin:15px 0 5px 0;"><a class="btn" href="/">New Search</a><a class="btn" href="' . $hashUrl . '" target="blank" rel="nofollow noopener">View Raw JSON</a></div>';
};?>

	
	<div class="well" style="margin-top:26px;">
	
	<div style="text-align:left;">
	
<?php
if (strpos($resultFront,'success') !== false) {
	echo '<ul class="transResults" style="list-style:none;">';
	echo '<li style="text-transform: capitalize">Result: ' . $resultFront . '</li>';
	echo '<li>Date: ' . $dateFront . '</li>';
	echo '<li>Transaction type: ' . $TransactionTypeFront . '</li>';
	echo '<li>Amount: ' . $AmountFront . '</li>';
	echo '<li>Fee: ' . $FeeFront . ' XRP</li>';
	echo '<li>Account: <a href="/account/' . $AccountFront . '/">' . $AccountFront . '</a></li>';
	echo '<li>Destination: <a href="/account/' . $DestinationFront . '/">' . $DestinationFront . '</a></li>';
	echo '<li style="text-transform: capitalize">Transaction Result: ' . $TransactionResultFront . '</li>';
	echo '<li>Flags: ' . $FlagsFront . '</li>';
	echo '<li>Sequence: ' . $SequenceFront . '</li>';
	echo '<li>Ledger Index: ' . $ledger_indexFront . '</li>';
	echo '<li>Hash: <a href="' . $canonicalurlonly . '">' . $hashFront . '</a></li>';
	echo '<li>Raw: <a href="' . $hashUrl . '" target="_blank" rel="nofollow noopener">JSON</a></li>';

	echo '</ul>';
} else {
echo '<h5>Please try again</h5>';
};
?>

</div>

</div>

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