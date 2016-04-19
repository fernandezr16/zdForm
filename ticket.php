<?php
// ZDAPIKEY - Specify your API key. The key is listed in Zendesk on the Channels/API page (Admin > Channels > API)
define("ZDAPIKEY", "...");
// ZDUSER - Specify your email address registered with Zendesk
define("ZDUSER", "user@example.com");
// ZDURL - Replace "subdomain" in the URL with the subdomain of your Zendesk account.
define("ZDURL", "https://ntv.zendesk.com/api/v2");
/* Note: do not put a trailing slash at the end of v2 */
// function curlWrap($url, $json, $action)
function curlWrap($url, $json)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_URL, ZDURL.$url);
	curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");
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

$ticket = json_encode(
	array(
		'ticket' => array(
			'ticket_form_id' => 139637,
			'subject' => $arr['z_subject'],
			'requester' => array(
				'name' => $arr['z_name'], 
				'email' => $arr['z_requester']
			),
			'custom_fields' => array(
				'id' => 30167118,
				'value' => $arr['z_product']
			),
			'comment' => array('value' => $arr['z_description'])
		)
	)
);

$return = curlWrap("/tickets.json", $ticket);

// Redirect to success page else 404 page.
if ($ticket){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=success.html\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
}
?>
