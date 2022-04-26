<?php

namespace Externalbs\Processor;

use Externalbs\Processor\Processor;
use Externalbs\System\HTTP\Ledgercode as LedgercodeHTTP;

class Ledgercode extends Processor {

    function readLedgercodes():array {
        $http = new LedgercodeHTTP();
        return json_decode($http->getLedgercodes($this->user), true);
    }

    function add(array $array):string {
        $http = new LedgercodeHTTP();
        return $http->addLedgercodes($this->user, ['ledgercodes' => json_encode($array)]);
    }

    function delete(string $jsonlcid):array {
        $http = new LedgercodeHTTP();
        return json_decode($http->deleteLedgercode($this->user, $jsonlcid), true);
    }

    function deleteAll():array {
        $http = new LedgercodeHTTP();
        return json_decode($http->deleteLedgercodes($this->user), true);
    }

}

