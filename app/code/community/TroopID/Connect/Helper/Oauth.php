<?php

class TroopID_Connect_Helper_Oauth extends Mage_Core_Helper_Abstract {

    const ENDPOINT_SANDBOX      = "https://api.sandbox.troopid.com";
    const ENDPOINT_PRODUCTION   = "https://api.troopid.com";

    const AUTHORIZE_PATH    = "/oauth/authorize";
    const TOKEN_PATH        = "/oauth/token";
    const PROFILE_PATH      = "/v1/me.json";
    const AFFILIATIONS_PATH = "/v1/affiliations.json";

    private function getConfig() {
        return Mage::helper("troopid_connect");
    }

    private function getCallbackUrl() {
        return Mage::getUrl("troopid/authorize/callback");
    }

    public function getAuthorizeUrl() {

        $params = array(
            "client_id"     => $this->getConfig()->getKey("client_id"),
            "redirect_uri"  => $this->getCallbackUrl(),
            "response_type" => "code",
            "display"       => "popup"
        );

        return $this->getDomain() . self::AUTHORIZE_PATH . "?" . $this->toQuery($params);
    }

    public function getAccessToken($code) {

        $config = $this->getConfig();
        $client = new Zend_Http_Client();

        $client->setUri($this->getDomain() . self::TOKEN_PATH);
        $client->setParameterPost(array(
            "client_id"     => $config->getKey("client_id"),
            "client_secret" => $config->getKey("client_secret"),
            "redirect_uri"  => $this->getCallbackUrl(),
            "code"          => $code,
            "grant_type"    => "authorization_code"
        ));

        try {
            $response = $client->request("POST");
        } catch (Zend_Http_Client_Exception $e) {
            return null;
        }

        if ($response->isError())
            return null;

        $json = Zend_Json::decode($response->getBody());

        return $json["access_token"];
    }


    public function getProfileData($token) {

        if (empty($token))
            return null;

        $config = Mage::helper("troopid_connect");

        $client = new Zend_Http_Client();
        $client->setUri($this->getDomain() . self::PROFILE_PATH);
        $client->setParameterGet(array(
            "access_token" => $token
        ));

        try {
            $response = $client->request("GET");
        } catch (Zend_Http_Client_Exception $e) {
            return null;
        }

        if ($response->isError())
            return null;

        $json = Zend_Json::decode($response->getBody());

        return $json;
    }

    public function getAffiliations() {
        $client     = new Zend_Http_Client($this->getDomain() . self::AFFILIATIONS_PATH);
        $response   = $client->request("GET");
        $values     = array();

        if ($response->isSuccessful())
            $values = Zend_Json::decode($response->getBody());

        return $values;
    }

    private function getDomain() {
        if ($this->getConfig()->isSandbox()) {
            return self::ENDPOINT_SANDBOX;
        } else {
            return self::ENDPOINT_PRODUCTION;
        }
    }

    private function toQuery($params) {
        $output = array();

        foreach ($params as $key => $value) {
            $output[]= $key . "=" . urlencode($value);
        }

        return join("&", $output);
    }


}