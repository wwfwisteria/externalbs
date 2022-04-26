<?php

namespace Externalbs\Processor;

use Externalbs\Model\UserAuth;

class Processor {

    protected $user;
    protected $jsonencode;

    function __construct(string $wistclientid, string $wistclientsecret, bool $jsonencode = false) {
        $this->user = new UserAuth($wistclientid, $wistclientsecret);
        $this->jsonencode = $jsonencode;
    }
        
}
