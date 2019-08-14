<?php
class TroopID_Connect_Block_Cart extends Mage_Checkout_Block_Cart_Abstract {

    public function isOperational() {
        return Mage::helper("troopid_connect")->isOperational();
    }

    public function isEnabled($scope) {
        return Mage::helper("troopid_connect")->isEnabled($scope);
    }

    public function getEndpoint() {
        return Mage::getUrl("troopid/authorize/authorize", array('_secure' => Mage::app()->getFrontController()->getRequest()->isSecure()));
    }

    public function getRemoveUrl() {
        return Mage::getUrl("troopid/authorize/remove", array('_secure' => Mage::app()->getFrontController()->getRequest()->isSecure()));
    }

    public function hasAffiliation() {
        return $this->getQuote() && $this->getQuote()->getTroopidScope() !== null;
    }

    public function getAffiliation() {
        $helper = Mage::helper("troopid_connect");
        $quote  = $this->getQuote();
        $scope  = $quote->getTroopidScope();
        $group  = $quote->getTroopidAffiliation();

        return $helper->formatAffiliation($scope, $group);
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