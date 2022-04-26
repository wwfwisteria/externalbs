<?php

namespace Externalbs\System\HTTP;

use Externalbs\Model\UserAuth;
use Externalbs\System\HTTP\HTTP;
use Externalbs\System\Utils\Constants;

class Tax extends HTTP {
    
    function getTaxes( UserAuth $userauth, int $page = 0, int $count = 10 ):string {
        $constants = new Constants();
        $url = $constants->getEndpointurl( 'taxapi' ) .'/readtaxes?page=' . $page . '&count=' . $count;
        return $this->send_msg( $userauth, $url, 'GET', [], true );
    }

    function getTax( UserAuth $userauth, string $id ):string {
        $constants = new Constants();
        $url = $constants->getEndpointurl( 'taxapi' ) .'/readtaxbyid?taxid=' . $id;
        return $this->send_msg( $userauth, $url, 'GET', [], true );
    }

    function addTaxes( UserAuth $userauth, array $data, bool $jsonencode = false ):string {
echo 'addTaxes jsonencode ' . $jsonencode;
        $constants = new Constants();
        $url = $constants->getEndpointurl( 'taxapi' ) .'/addtaxes';
        return  $this->send_msg($userauth, $url, 'POST', $data, true, $jsonencode);
    }

    function deleteTax( UserAuth $userauth, $id ):string {
        $constants = new Constants();
        $url       = $constants->getEndpointurl( 'taxapi' ) .'/deletetax/' . $id;
        return $this->send_msg($userauth, $url, 'DELETE', [], true);
    }
    
    function deleteAll( UserAuth $userauth ):string {
        $constants = new Constants();
        $url       = $constants->getEndpointurl( 'taxapi' ) . '/deletetaxes';
        return $this->send_msg($userauth, $url, 'DELETE', [], true);
    }
    
}



