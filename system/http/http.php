<?php

namespace Externalbs\System\HTTP;

use Externalbs\Model\UserAuth;
use Externalbs\System\HTTP\OAuth;
use Externalbs\System\Utils\Constants;

class HTTP {

    function send_msg(UserAuth $user, string $url, string $method, array $data = [], bool $firsttry = true, $jsonencode = false):string {
        try { 

            $header[1] = 'Accept: application/json';
            $header[2] = $this->getContentType($jsonencode);
            $header[3] = 'Authorization: Bearer '  . trim($user->getClientsecret());

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_VERBOSE, false);

            if ($method == 'POST') {
                curl_setopt($curl, CURLOPT_POST, 1);
            }
            if ($method == 'DELETE') {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            }
            if ($data) { 
                $data['signature'] = $this->determineSignature($user, $data);
                if (in_array($method, ['DELETE', 'POST'])) { 
                    if ($jsonencode) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)  );
                    } else {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query( $data )  );
                    }
                } else { 
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
            } else {
                $url = $url . '&signature=' . $this->determineSignature($user, []);
            }
        
            $result = curl_exec($curl);
print_r($result);
            if ($firsttry && $this->tokenExpired($result)) {
                $this->getToken($user);
                $this->send_msg($user, $url, $method, $data, false);
            }
  
            curl_close($curl);

            return (string)$result;
              
        } catch (\Exception $e) {
            return error_log('error wisteria send_msg system-http-http ' . $e->getMessage());
        }             
        
    }
            
    private function tokenExpired(string $result):bool {
        $array = json_decode($result, true);
        if (array_key_exists('errorcode', $array) && $array['errorcode'] == 401) {
            return true;
        }
        return false;
    }

    private function getToken(UserAuth $user):string { 
        $oauth = new OAuth();
        $array = $oauth->refreshtoken_request($user);

        if (array_key_exists('access_token', $array)) {
            $user->modify( ['clientid' => $array['refresh_token'], 'clientsecret' => $array['access_token']] );
            return $array['access_token'];
        }
        return '';
    }
    
    private function getContentType(bool $jsonencode):string {
        if ($jsonencode) {
            return 'Content-Type: application/json';
        } 
        return 'Content-Type: application/x-www-form-urlencoded';
    }

    private function determineSignature(UserAuth $user, array $array):string {
        $constants = new Constants();
        if (count($array) > 0) {
            return md5( gmdate("Ydm").gmdate("dmY").$constants->getClientsecret().(string)reset($array).gmdate("dmY") );
        }
        return md5( gmdate("Ydm").gmdate("dmY").$constants->getClientsecret().gmdate("dmY") );
    }
}
