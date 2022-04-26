<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../autoload.php';

use Externalbs\Processor\Authentication;
use Externalbs\Processor\Ledgercode;
use Externalbs\System\Utils\ArrayUtils;

class readLedgercodes extends \PHPUnit\Framework\TestCase {

   /**
     * @dataProvider dataProviderLedgercode
     */
    public function testReadLedgercodes(array $parms): void
    {
        $this->addLedgercodes();
        $processor = new Ledgercode($parms['clientid'], $parms['clientsecret']);
        $result    = $processor->readLedgercodes();
	print_r(json_encode($result)); 

        $this->assertTrue(array_key_exists('data', $result));
        $this->assertTrue(is_array($result['data']));
        $this->assertTrue(count($result['data']) == 2);

        $diff1 = $this->validate($result['data'], $parms['response']);
     print_r( $diff1); 
        $this->assertTrue(strlen($diff1) == 0);
    }

    public function dataProviderLedgercode() {
        $authentication         = new Authentication();
        $parms1['clientid']     = $authentication->readValue('clientid');
        $parms1['clientsecret'] = $authentication->readValue('clientsecret');
        $parms1['response']     = json_decode($this->readResponse1(), true)['data'];
        return [
	    [$parms1],
	];
    }

    private function addLedgercodes() {
        $this->deleteLedgercodes();
        $authentication = new Authentication();
        $processor      = new Ledgercode($authentication->readValue('clientid'), $authentication->readValue('clientsecret'));
        $add = $processor->add($this->ledgercodes());
        //print_r( $add);

    }

    private function deleteLedgercodes() {
        $authentication = new Authentication();
        $processor      = new Ledgercode($authentication->readValue('clientid'), $authentication->readValue('clientsecret'));
        $processor->deleteAll();
        return false;
    }

    private function readResponse1() {
        return '{"data":[{"ledgercodeid":1115,"code":"standard","name":9,"taxpercentage_100":"NL","type":"turnover","country":"NL"},{"ledgercodeid":1114,"code":"standard","name":9,"taxpercentage_100":"NL","type":"turnover","country":"NL"}],"message":"Result"}';
        return '{"data":[{"ledgercodeid":"112","name":"ideal","type":"turnover","code":5490},{"ledgercodeid":"113","name":"cash","type":"turnover","code":4590}],"message":"Result"}';
    }

    private function validate(array $trx1, array $trx2):string {
        $utils = new ArrayUtils();
        $diff  = $utils->arrayDiff($trx1, $trx2, ['ledgercodeid','description', 'createddate', 'changedate'], true);
        return $utils->noDifferences($diff);
    }

    private function ledgercodes() {
        return [
                 [
                 'ledgercodeid'      => 1115,
                 'code'              => 'standard',
                 'name'              => 9.00,
                 'taxpercentage_100' => 'NL',
                 'title'        => 'NL',
                 'isdefault'    => 'NL',
                 'type'         => 'turnover',
                 'country'      => 'NL',
                ],
                [
                 'ledgercodeid'      => 1114,
                 'code'              => 'standard',
                 'name'              => 9.00,
                 'taxpercentage_100' => 'NL',
                 'title'        => 'NL',
                 'isdefault'    => 'NL',
                 'type'         => 'turnover',
                 'country'      => 'NL',
                ]
               ];
    }

}
