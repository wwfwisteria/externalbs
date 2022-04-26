<?php

namespace Externalbs\Processor;

use Externalbs\Processor\Processor;
use Externalbs\System\HTTP\FinancialTransaction as FinancialTransactionHTTP;

class FinancialTransaction extends Processor {

    function readFinancialTransactions():array {
        $http = new FinancialTransactionHTTP();
        return json_decode($http->getFinancialTransactions($this->user), true);
    }

    function add(string $array):string { 
        $http = new FinancialTransactionHTTP();
        return $http->addFinancialTransaction($this->user, ['financialtransaction' => $array]);
    }

    function delete(string $saleid):array {
        $http = new FinancialTransactionHTTP();
        return json_decode($http->deleteBySaleId($this->user, $saleid), true);
    }

    function deleteAll():array {
        $http = new FinancialTransactionHTTP();
        return json_decode($http->deleteAll($this->user), true);
    }

}

