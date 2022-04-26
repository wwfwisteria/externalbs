<?php

namespace Externalbs\System\HTTP;

use Externalbs\Model\UserAuth;
use Externalbs\System\HTTP\HTTP;
use Externalbs\System\Utils\Constants;

class Ledgercode extends HTTP {
    
    function getLedgercodes( UserAuth $userauth ):string {
        $endpoint = ( new Constants() )->getEndpointurl('ledgercodeapi');
        $url = $endpoint .'/readLedgercodes';
        return $this->send_msg( $userauth, $url, 'GET', [], true );
    }

    function getLedgercodeById( UserAuth $userauth, string $id ):string {
        $endpoint = ( new Constants() )->getEndpointurl('ledgercodeapi');
        $url = $endpoint .'/readLedgercodeById?ledgercodeid='.$id;
        return $this->send_msg( $userauth, $url, 'GET', [], true );
    }

    function addLedgercodes( UserAuth $userauth, array $data ):string {
        $endpoint = ( new Constants() )->getEndpointurl('ledgercodeapi');
        $url = $endpoint .'/addledgercodes';
        return $this->send_msg($userauth, $url, 'POST', $data, true);
    }

    function deleteLedgercode( UserAuth $userauth, string $id ) {
        $endpoint = ( new Constants() )->getEndpointurl('ledgercodeapi');
        $url = $endpoint .'/deleteLedgercode/'.$id;
        return $this->send_msg($userauth, $url, 'DELETE', '', true);
    }
    
    function deleteLedgercodes( UserAuth $userauth ):string {
        $endpoint = ( new Constants() )->getEndpointurl('ledgercodeapi');
        $url = $endpoint .'/deleteLedgercodes';
        return $this->send_msg($userauth, $url, 'DELETE', [], true);
    }
    
}

