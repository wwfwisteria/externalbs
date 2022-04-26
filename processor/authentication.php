<?php

namespace Externalbs\Processor;

class Authentication {

    function readValue(string $key):string {
        $oauthfile = dirname(__FILE__) . '/../../../../files/externalbs/oauth/user.cnf';
        $handle = fopen($oauthfile, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $arr = explode('=', $line);
                if ($arr[0] == $key) {
                    return $arr[1];
                }
            }
            fclose($handle);
        }
        return 'nokey';
    }

}
