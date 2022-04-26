<?php

require( dirname( __FILE__ ) . '/../../autoload.php' );

use Externalbs\System\Utils\Constants;

$constants   = new Constants();
$clientid    = $constants->getClientid();
$accessurl   = $constants->getWisteriaOAuthurl() . '/authorize';
$callbackurl = $constants->getCallbackurl();

$authorizestring = 'response_type=code&client_id=' . $clientid . '&redirect_url=' . $callbackurl;

$authorize_endpoint = $accessurl . '?' . $authorizestring;

echo "<script>window.location='" . $authorize_endpoint . "'</script>";

die();
