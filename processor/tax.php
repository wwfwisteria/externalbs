<?php

namespace Externalbs\Processor;

use Externalbs\Model\UserAuth;
use Externalbs\Processor\Processor;
use Externalbs\System\HTTP\Tax as TaxHTTP;

class Tax extends Processor {

    function readTaxes():string {
        $http = new TaxHTTP();
        return $http->getTaxes($this->user);
    }

    function add(array $array):string {
        $http = new TaxHTTP();
        return $http->addTaxes($this->user, ['taxes' => json_encode($array)], $this->jsonencode);
    }

    function delete(string $jsontaxid):string {
        $http     = new TaxHTTP();
        return $http->deleteTax($this->user, $jsontaxid);
    }

    function deleteAll():string {
        $http     = new TaxHTTP();
        return $http->deleteAll($this->user);
    }
}
