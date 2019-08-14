<?php

class TroopID_Connect_AuthorizeController extends Mage_Core_Controller_Front_Action {

    private function getSession() {
        return Mage::getSingleton("checkout/session");
    }

    private function getConfig() {
        return Mage::helper("troopid_connect");
    }

    private function getOauth() {
        return Mage::helper("troopid_connect/oauth");
    }

    private function getCart() {
        return Mage::getSingleton("checkout/cart");
    }

    public function authorizeAction() {
        $this->getResponse()->setRedirect($this->getOauth()->getAuthorizeUrl());
    }

    public function callbackAction() {

        $config  = $this->getConfig();
        $oauth   = $this->getOauth();
        $session = $this->getSession();

        /* code from initial callback */
        $code = $this->getRequest()->getParam("code");

        /* code was not found, invalid callback request */
        if (empty($code)) {
            $session->addError($config->__("Troop ID verification failed, please contact the store owner"));
        } else {

            /* request access token with the given code */
            $token = $oauth->getAccessToken($code);

            /* request user profile data with the given access token */
            $data = $oauth->getProfileData($token);

            if (empty($data)) {
                $session->addError($config->__("Troop ID verification failed, please contact the store owner"));
            } else {
                $cart   = $this->getCart();
                $quote  = $cart->getQuote();

                if ($data["verified"]) {
                    $quote->setTroopidAffiliation($data["affiliation"]);
                    $quote->setTroopidUid($data["id"]);
                    $quote->save();

                    $session->addSuccess($config->__("Successfully verified military affiliation via Troop ID"));
                } else {
                    $session->addError($config->__("Unfortunately your have not verified your affiliation with Troop ID"));
                }
            }
        }

        $this->loadLayout()->renderLayout();
    }

}