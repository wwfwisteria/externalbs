<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../autoload.php';

use Externalbs\Processor\Authentication;
use Externalbs\Processor\Tax;
use Externalbs\System\Utils\ArrayUtils;

class addTaxes extends \PHPUnit\Framework\TestCase {

    public function setUp(): void 
    {
        $this->deleteTaxes();
    }

   /**
     * @dataProvider dataProviderTaxes
     */
    public function testAddTaxes($parms) {
        $processor = new Tax($parms['clientid'], $parms['clientsecret'], $parms['jsonencode']);
        $result    = json_decode($processor->add($this->taxes()), true);
        //print_r($result); die();

        $this->assertTrue(array_key_exists('data', $result));
        $this->assertTrue(is_array($result['data']));
        $this->assertTrue(count($result['data']) == 4);

        $diff1 = $this->validate($result['data'], $parms['response']);
        //print_r($diff1); die();
        $this->assertTrue(strlen($diff1) == 0);
    }

	
    public function dataProviderTaxes() {
        $authentication         = new Authentication();
        $parms1['clientid']     = $authentication->readValue('clientid');
        $parms1['clientsecret'] = $authentication->readValue('clientsecret');
        $parms1['jsonencode']   = false;
        $parms1['response']     = json_decode($this->readResponse1(), true)['data'];

        $parms2['clientid']     = $authentication->readValue('clientid');
        $parms2['clientsecret'] = $authentication->readValue('clientsecret');
        $parms2['jsonencode']   = true;
        $parms2['response']     = json_decode($this->readResponse1(), true)['data'];

        return [
	    [$parms1],
	    [$parms2]
	];
    }

    private function deleteTaxes() {
        $authentication = new Authentication();
        $processor      = new Tax($authentication->readValue('clientid'), $authentication->readValue('clientsecret'));
        $processor->deleteAll();
    }

    private function readResponse1() {
        return '{"data":[{"taxid":"111","taxcode":"VL","percentage_1":"0.0900","percentage_100":"9.0000","title":"testtax","description":null,"country":"NL"},{"taxid":"112","taxcode":"VH","percentage_1":"0.2100","percentage_100":"21.0000","title":"testtax","description":null,"country":"NL"},{"taxid":"211","taxcode":"VLBE","percentage_1":"0.0600","percentage_100":"6.0000","title":"testtax","description":null,"country":"BE"},{"taxid":"212","taxcode":"VHBE","percentage_1":"0.2100","percentage_100":"21.0000","title":"testtax","description":null,"country":"BE"}],"message":"Your data is inserted successfully"}';
    }

    private function validate(array $trx1, array $trx2):string {
        $utils = new ArrayUtils();
        $diff  = $utils->arrayDiff($trx1, $trx2, ['id', 'licensekey', 'creationdate', 'changedate'], true);
        return $utils->noDifferences($diff);
    }

    private function taxes():array {
        return [
                [
                 'taxid'      => 111,
                 'taxcode'    => 'VL',
                 'percentage' => 9.00,
                 'title'      => 'testtax',
                 'country'    => 'NL',
                ],
                [
                 'taxid'      => 112,
                 'taxcode'    => 'VH',
                 'percentage' => 0.21,
                 'title'      => 'testtax',
                 'country'    => 'NL',
                ],
                [
                 'taxid'      => 211,
                 'taxcode'    => 'VLBE',
                 'percentage' => 6.00,
                 'title'      => 'testtax',
                 'country'    => 'BE',
                ],
                [
                 'taxid'      => 212,
                 'taxcode'    => 'VHBE',
                 'percentage' => 0.21,
                 'title'      => 'testtax',
                 'country'    => 'BE',
                ]
               ];
    }

}
