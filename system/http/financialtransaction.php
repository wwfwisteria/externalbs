<?php

namespace Externalbs\System\HTTP;

use Externalbs\Model\UserAuth;
use Externalbs\System\HTTP\HTTP;
use Externalbs\System\Utils\Constants;

class FinancialTransaction extends HTTP {
    
    function getFinancialTransactions( UserAuth $userauth, $startDate = '',$endDate ='', int $page = 1, int $count = 10 ):string {
        $endpoint = ( new Constants() )->getEndpointurl('financialtransactionapi');
        $url = $endpoint .'/searchfinancialtransactions?startdate='.$startDate.'&enddate='.$endDate;
        return $this->send_msg( $userauth, $url, 'GET', [], true );
    }

    function getFinancialTransactionBySaleId( UserAuth $userauth, string $id ):string {
        $endpoint = ( new Constants() )->getEndpointurl('financialtransactionapi');
        $url = $endpoint .'/searchfinancialtransactionbyid?id='.$id;
        return $this->send_msg( $userauth, $url, 'GET', [], true );
    }

    function addFinancialTransaction( UserAuth $userauth, array $data ):string {
        $endpoint = ( new Constants() )->getEndpointurl('financialtransactionapi');
        $url = $endpoint .'/addFinancialTransaction'; 
        return $this->send_msg($userauth, $url, 'POST', $data, true);
    }

    function deleteBySaleId( UserAuth $userauth, string $id ) {
        $endpoint = ( new Constants() )->getEndpointurl('financialtransactionapi');
        $url = $endpoint .'/deleteFinancialTransaction/'.$id;
        return $this->send_msg($userauth, $url, 'DELETE', '', true);
    }
    
    function deleteAll( UserAuth $userauth ):string {
        $endpoint = ( new Constants() )->getEndpointurl('financialtransactionapi');
        $url = $endpoint .'/deletefinancialtransactions';
        return $this->send_msg($userauth, $url, 'DELETE', [], true);
    }
    
}

