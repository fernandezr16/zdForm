
<?php
// ZDAPIKEY - Specify your API key. The key is listed in Zendesk on the Channels/API page (Admin > Channels > API)
define("ZDAPIKEY", "Kt1qDQ4Y4cEexR8ji4LpN1bOKUdi0v4AVp694paS");
// ZDUSER - Specify your email address registered with Zendesk
define("ZDUSER", "tton@nativo.net");
// ZDURL - Replace "subdomain" in the URL with the subdomain of your Zendesk account.
define("ZDURL", "https://ntvtest.zendesk.com/api/v2");
/* Note: do not put a trailing slash at the end of v2 */
function curlWrap($url, $json, $action)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_URL, ZDURL.$url);
	curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  	curl_setopt($curl_ch, CURLOPT_CAINFO, dirname(__FILE__)."cacert.pem");
	$output = curl_exec($ch);
	curl_close($ch);
	$decoded = json_decode($output);
	return $decoded;
}
foreach($_POST as $key => $value){
	if(preg_match('/^z_/i',$key)){
		$arr[strip_tags($key)] = strip_tags($value);
	}
}
$create = json_encode(array('ticket' => array('subject' => $arr['z_subject'], 'product' => array('product' => $arr['z_product']), 'comment' => array('value' => $arr['z_description']), 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester']))));
if(CUSTOM){
	foreach($_POST as $key => $value){
		if(preg_match('/^c_/i',$key)){
			$id = str_replace('c_', '', strip_tags($key));
			$value = strip_tags($value);
			$cfield=array('id'=>$id, 'value'=>$value);
			$ticket['ticket']['custom_fields'][]=$cfield;
		}
	}
}
$ticket = json_encode($ticket);
$return = curlWrap("/tickets.json", $create);

// Redirect to success page else 404 page.
if ($create){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=success.html\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
}
?>
