<?php
define('API_KEY', '5b4c2440-5907-44cc-9068-d0d089894243');
/* 
	East Mids: 511
	North East: 508
	North West: 507
	Scotland: 503
	West Mids: 510
	UK: 515
*/

$areas = array("511" => "East Midlands", "515" => "National", "508" => "North East", "507" => "North West", "503" => "Scotland", "510" => "West Midlands");

?>
<html>
<head>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24018806-17']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<p><b>Notice: </b>This is by no means a finished product. At the moment this updates every morning and each day gives a &quot;Today, Tonight, Tomorrow&quot; forecast! i shall be tweaking it so get the correct updates that the met office issue during the day in due course!</p>
<?php
foreach ($areas as $area=>$title) {
	echo getWeather($area, $title." Weather");
}

	?>
	</body>
	</html>
	<?php
	
	
	
	
	
	
	
/* FUNCTIONS */

function getWeather($areacode, $thearea) {
	
	$data = "http://datapoint.metoffice.gov.uk/public/data/txt/wxfcs/regionalforecast/json/".$areacode."?key=".API_KEY;
	// echo $data;
	$curl = file_get_contents_curl($data);
	$decode = json_decode($curl);

	$weather = $decode->RegionalFcst->FcstPeriods->Period{0};
	$output .= "<h2>".$thearea."</h2>";
	$timestamp = strtotime($decode->RegionalFcst->issuedAt);
	$output .= "<h4>Issued at: ".date('d/m/y hi', $timestamp)."</h4>";
	
	foreach ($weather->Paragraph as $para) {
		$output .= "<p><strong>".$para->title."</strong> ";
		$output .= $para->{"$"}."</p>";
	}
	/*	echo "<pre>";
		var_dump($decode);
		echo "</pre>";
*/
return $output;
}

	function file_get_contents_curl($url) {
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	
		$data = curl_exec($ch);
		curl_close($ch);
	
	return $data;
	}



?>