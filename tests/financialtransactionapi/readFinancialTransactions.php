<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../autoload.php';

use Externalbs\Processor\Authentication;
use Externalbs\Processor\FinancialTransaction;
use Externalbs\System\Utils\ArrayUtils;

class readFinancialTransactions extends \PHPUnit\Framework\TestCase {

   /**
     * @dataProvider dataProviderFinancialTransaction
     */
    public function testReadFinancialTrx($parms) {
        $this->addFinancialTrx();
        $processor = new FinancialTransaction($parms['clientid'], $parms['clientsecret']);
        $result    = $processor->readFinancialTransactions();
      print_r( $result  ); 

        $this->assertTrue(array_key_exists('data', $result));
        $this->assertTrue(is_array($result['data']));
        $this->assertTrue(count($result['data']) == 1);

        $diff1 = $this->validate($result['data'], $parms['response']);
        $this->assertTrue(strlen($diff1) == 0);
    }

    public function dataProviderFinancialTransaction() {
        $authentication         = new Authentication();
        $parms1['clientid']     = $authentication->readValue('clientid');
        $parms1['clientsecret'] = $authentication->readValue('clientsecret');
        $parms1['response']     = json_decode($this->readResponse1(), true)['data'];
        return [
	       [$parms1],
	    ];
    }

    private function addFinancialTrx() {
        $this->deleteFinancialTrx();
        $authentication = new Authentication();
        $processor      = new FinancialTransaction($authentication->readValue('clientid'), $authentication->readValue('clientsecret'));
        $processor->add($this->FinancialTrx());
    }

    private function deleteFinancialTrx() {
        $authentication = new Authentication();
        $processor      = new FinancialTransaction($authentication->readValue('clientid'), $authentication->readValue('clientsecret'));
        $processor->deleteAll();
        return false;
    }

    private function readResponse1() {
    }

    private function validate(array $trx1, array $trx2):string {
        $utils = new ArrayUtils();
        $diff  = $utils->arrayDiff($trx1, $trx2, [], true);
        return $utils->noDifferences($diff);
    }

    private function FinancialTrx() {
        return '[{"friendly":{"customer":{"firstname":"Karel","inbetween":"de","lastname":"Wit","street":"Stationstraat","housenumber":"12","addition":"a","zipcode":"1100 AA","city":"Amsterdam","country":"NL","email":"karel@webwinkelfacturen.nl","phone":"123456789","vatnr":"NLxxxB1","kvknr":"xxxx","companyname":"ComputerService"},"saledate":"2021-09-17","saleid":"12345-xxx","reference":"ORD1268699065 / INV xxx","status":"open","lines":[{"description":"DIY-Kit Maak je eigen Fiets","productnumber":"DIYZ","category":"CAT_DIYZ","quantity":1,"unitpriceincl":"23.9900","linepriceincl":"23.9900","unitpriceexcl":"19.83","linepriceexcl":"19.83","taxperc":"21","invtaxid":"VATCODE21","ledgercode":"8000","taxledgercode":"1600","productledgercode":"3000"},{"description":"Verzendkosten","productnumber":"VERZ","category":"CAT_VERZ","quantity":1,"unitpriceincl":"6.05","linepriceincl":"6.05","unitpriceexcl":"5","linepriceexcl":"5","taxperc":"21","invtaxid":"VATCODE21","ledgercode":"8000","taxledgercode":"1600","productledgercode":"3001"}],"payments":[{"name":"iDeal","slug":"ideal","id":"1","amount":24.09,"transactionid":"xxx-xxx","paymentledgercode":"2100"}],"sendingaddress":{"firstname":"Maria","inbetween":"de","lastname":"Jong","street":"Stationstraat","housenumber":"14","addition":"b","zipcode":"1100 AA","city":"Amsterdam","country":"NL","email":"karel@webwinkelfacturen.nl","phone":"123456789","vatnr":"NLxxxB1","kvknr":"xxxx","companyname":"ComputerHardware"}}},{"raw":{' . $this->raw() . '}}]';
    }

    private function raw() {
        return '{"id":12345,"parent_id":0,"status":"completed","currency":"EUR","version":"6.1.1","prices_include_tax":true,"date_created":"2021-09-17T13:25:08","date_modified":"2021-09-18T14:54:36","discount_total":"0.00","discount_tax":"0.00","shipping_total":"0.00","shipping_tax":"0.00","cart_tax":"24.83","total":"30.04","total_tax":"24.83","customer_id":5,"order_key":"wc_order_123","billing":{"first_name":"theo","last_name":"vdb","company":"","address_1":"Stationstraat 12","address_2":"","city":"Amsterdam","state":"","postcode":"1100 AA","country":"NL","email":"karel@webwinkelfacturen.nl","phone":"+32476067698"},"shipping":{"first_name":"theo","last_name":"vdb","company":"","address_1":"Stationstraat 12","address_2":"","city":"Amsterdam","state":"","postcode":"1100 AA","country":"NL","phone":""},"payment_method":"","payment_method_title":"","transaction_id":"","customer_ip_address":"111.123.134.211","customer_user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64; rv:96.0) Gecko\/20100101 Firefox\/96.0","created_via":"checkout","customer_note":"","date_completed":"2021-1008T14:54:36","date_paid":"2021-09-17T13:25:08","cart_hash":"hash_6c","number":"12345-xxx","meta_data":[{"id":460446,"key":"is_vat_exempt","value":"no"},{"id":460447,"key":"ywcdd_order_delivery_date","value":"2021-1009"},{"id":460448,"key":"ywcdd_order_shipping_date","value":"2021-1008"},{"id":460449,"key":"ywcdd_order_slot_from","value":""},{"id":460450,"key":"ywcdd_order_slot_to","value":""},{"id":460451,"key":"ywcdd_order_carrier_id","value":"1047"},{"id":460452,"key":"ywcdd_order_processing_method","value":"1046"},{"id":460453,"key":"ywcdd_order_carrier","value":"UPS"},{"id":460454,"key":"_alg_wc_custom_order_number","value":"104"},{"id":460455,"key":"_alg_wc_full_custom_order_number","value":"12345-xxx"},{"id":460456,"key":"vat_number","value":""},{"id":460457,"key":"_vat_country","value":""},{"id":460458,"key":"_vat_number_validated","value":"no-number"},{"id":460459,"key":"vies_response","value":[]},{"id":460460,"key":"vies_consultation_number","value":"Not returned"},{"id":460461,"key":"vat_number_validation_source","value":"Not returned"},{"id":460462,"key":"_customer_location_self_certified","value":"no"},{"id":460463,"key":"_eu_vat_data","value":{"eu_vat_assistant_version":"2.0.26.220104","exchange_rates_provider_label":"BitPay","invoice_currency":"EUR","taxes":{"3":{"label":"21% NL VAT","vat_rate":"21.0000","country":"NL","tax_rate_class":"","tax_payable_to_country":"NL","amounts":{"items_total":24.829437,"shipping_total":0}}},"totals":{"items_total":24.829437,"shipping_total":0,"items_refund":0,"shipping_refund":0,"total":24.829437},"vat_currency":"EUR","vat_currency_exchange_rate":1,"vat_currency_exchange_rate_timestamp":1626947883}},{"id":460464,"key":"_eu_vat_evidence","value":{"eu_vat_assistant_version":"2.0.26.220104","location":{"is_eu_country":1,"billing_country":"NL","shipping_country":"NL","customer_ip_address":"111.123.134.211","customer_ip_address_country":"NL","self_certified":"no"},"exemption":{"vat_number":"","vat_country":"","vat_number_validated":"no-number","vies_response":[],"vat_number_validation_source":"Not returned","vies_consultation_number":"Not returned"}}},{"id":460472,"key":"_new_order_email_sent","value":"true"},{"id":460478,"key":"_wcpdf_invoice_settings","value":{"display_shipping_address":"","display_customer_notes":"1","display_date":"","display_number":"","number_format":{"prefix":"","suffix":"","padding":""},"my_account_buttons":"available","paper_size":"a4","font_subsetting":false,"header_logo":"49","header_logo_height":"","shop_name":{"default":"Sponiza \/ IT"},"shop_address":{"default":"fietsstraat 11 \r\n1100 AA Amsterdam\r\nNederland\r\n{{merchant_vat_number}}"},"footer":{"default":""},"extra_1":{"default":""},"extra_2":{"default":""},"extra_3":{"default":""}}},{"id":460481,"key":"_woo_ml_order_tracked","value":"1"},{"id":463501,"key":"_woo_ml_order_tracked","value":"1"},{"id":463523,"key":"_woo_ml_order_tracked","value":"1"},{"id":463541,"key":"_woo_ml_order_tracked","value":"1"}],"line_items":[{"id":5484,"name":"DIY-Kit Maak je eigen Fiets","product_id":15597,"variation_id":0,"quantity":1,"tax_class":"","subtotal":"26.86","subtotal_tax":"5.64","total":"26.86","total_tax":"5.64","taxes":[{"id":3,"total":"5.640496","subtotal":"5.640496"}],"meta_data":[{"id":46194,"key":"_wcpdf_regular_price","value":{"incl":32.5,"excl":26.859504},"display_key":"_wcpdf_regular_price","display_value":{"incl":32.5,"excl":26.859504}},{"id":46196,"key":"_reduced_stock","value":"1","display_key":"_reduced_stock","display_value":"1"}],"sku":"c00000003660","price":26.859504,"parent_name":null}],"tax_lines":[{"id":5487,"rate_code":"NL-21% NL VAT-1","rate_id":3,"label":"21% NL VAT","compound":false,"tax_total":"24.83","shipping_tax_total":"0.00","rate_percent":21,"meta_data":[]}],"shipping_lines":[],"fee_lines":[],"coupon_lines":[],"refunds":[],"date_created_gmt":"2021-09-17T12:25:08","date_modified_gmt":"2021-1008T13:54:36","date_completed_gmt":"2021-1008T13:54:36","date_paid_gmt":"2021-09-17T12:25:08","currency_symbol":"\u20ac","_links":{"self":[{"href":"https:\/\/sponiza.nl\/wp-json\/wc\/v2\/orders\/12345"}],"collection":[{"href":"https:\/\/sponiza.nl\/wp-json\/wc\/v2\/orders"}],"customer":[{"href":"https:\/\/sponiza.nl\/wp-json\/wc\/v2\/customers\/5"}]}}';
    }

}

