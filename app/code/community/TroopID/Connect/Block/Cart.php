<?php

class TroopID_Connect_Block_Cart extends Mage_Checkout_Block_Cart_Abstract {

    public function isOperational() {
        return Mage::helper("troopid_connect")->isOperational();
    }

    public function getEndpoint() {
        return Mage::getUrl("troopid/authorize/authorize");
    }

    public function hasAffiliation() {
        return $this->getQuote() && $this->getQuote()->getTroopidAffiliation() !== null;
    }

    public function getAffiliation() {
        return $this->getQuote()->getTroopidAffiliation();
    }

    public function getAbout() {
        return Mage::helper("troopid_connect")->getKey("about");
    }

    protected function _toHtml() {

        if (!$this->isOperational())
            return "";

        return parent::_toHtml();
    }

}