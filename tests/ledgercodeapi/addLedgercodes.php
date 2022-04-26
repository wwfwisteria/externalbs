<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../autoload.php';

use Externalbs\Processor\Authentication;
use Externalbs\Processor\Ledgercode;
use Externalbs\System\Utils\ArrayUtils;

class addLedgercodes extends \PHPUnit\Framework\TestCase {

    public function setUp(): void
    {
        $this->deleteLedgercodes();
    }

   /**
     * @dataProvider dataProviderLedgercodes
     */
    public function testAddLedgercodes(array $parms): void
    {
        $processor = new Ledgercode($parms['clientid'], $parms['clientsecret']);
        $result    = json_decode($processor->add($this->ledgercodes()), true);
        print_r( $result ); 

        $this->assertTrue(array_key_exists('data', $result));
        $this->assertTrue(is_array($result['data']));
        $this->assertTrue(count($result['data']) == 2);

        $diff1 = $this->validate($result['data'], $parms['response']);
        $this->assertTrue(strlen($diff1) == 0);
    }

	
    public function dataProviderLedgercodes() {
        $authentication         = new Authentication();
        $parms1['clientid']     = $authentication->readValue('clientid');
        $parms1['clientsecret'] = $authentication->readValue('clientsecret');
        $parms1['response']     = json_decode($this->readResponse1(), true)['data'];
        return [
	    [$parms1],
	];
    }

    private function deleteLedgercodes() {
        $authentication = new Authentication();
        $processor      = new Ledgercode($authentication->readValue('clientid'), $authentication->readValue('clientsecret'));
        $processor->deleteAll();
    }

    private function readResponse1() {
        return '{"data":[{"ledgercodeid":"112","name":"ideal","type":"standard","code":1120},{"ledgercodeid":"113","name":"cash","type":"standard","code":1140}],"message":"Your data is inserted successfully"}';
    }

    private function validate(array $trx1, array $trx2):string {
        $utils = new ArrayUtils();
        $diff  = $utils->arrayDiff($trx1, $trx2, ['id', 'licensekey', 'creationdate', 'changedate'], true);
        return $utils->noDifferences($diff);
    }

    private function ledgercodes():array {
        return [
                [
                 'ledgercodeid' => 112,
                 'name'            => 'ideal',
                 'type'            => 'standard',
                 'code'            => 1120 
                ],
                [
                 'ledgercodeid' => 113,
                 'name'            => 'cash',
                 'type'            => 'standard',
                 'code'            => 1140
                ]
               ];
    }

}
