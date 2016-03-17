<?php
// ZDAPIKEY - Specify your API key. The key is listed in Zendesk on the Channels/API page (Admin > Channels > API)
define("ZDAPIKEY", "Yl48iZX9j0jS7AsY4kP3bU9IkwxwHmdnzLUdGjtm");
// ZDUSER - Specify your email address registered with Zendesk
define("ZDUSER", "ymonkey714@gmail.com");
// ZDURL - Replace "subdomain" in the URL with the subdomain of your Zendesk account.
define("ZDURL", "https://testacct.zendesk.com/api/v2");
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
// $create = json_encode(array('ticket' => array('subject' => $arr['z_subject'], 'comment' => array( "value"=> $arr['z_description']), 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester'], 'custom_fields' => array('id' => 31204387, 'value' => $arr['z_31204387'])))));
// $return = curlWrap("/tickets.json", $create);

$create = json_encode(array(
  'ticket' => array(
    'subject' => $arr['z_subject'],
    'comment' => array('value' => $arr['z_description']),
    'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester']),
    'custom_fields' => [
      //replace 1234 with the value or variable for the custom field id
      //replace 'somevalue' with the variable containing the field value collected from your form
      array('id' => 31204387, 'value' => 'z_product')
    ]
    )
  )
);
// print_r($create);
$return = curlWrap("/tickets.json", $create);

// Redirect to success page else 404 page.
if ($create){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=success.html\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
}
?>
