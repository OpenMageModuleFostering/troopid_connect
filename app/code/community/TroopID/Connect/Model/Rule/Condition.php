<?php
class TroopID_Connect_Model_Rule_Condition extends Mage_Rule_Model_Condition_Abstract {

    public function loadAttributeOptions() {

        $this->setAttributeOption(array(
            "troopid_affiliation" => Mage::helper("troopid_connect")->__("Troop ID Verified Affiliation")
        ));

        return $this;
    }

    public function getInputType() {
        return "select";
    }

    public function getValueElementType() {
        return "select";
    }

    public function getValueSelectOptions() {
        if (!$this->hasData("value_select_options")) {

            $options = array();
            $affiliations = Mage::helper("troopid_connect")->getAffiliations();

            foreach ($affiliations as $affiliation) {
                $options[$affiliation] = $affiliation;
            }

            $this->setData("value_select_options", $options);
        }

        return $this->getData("value_select_options");
    }

    public function getAttributeElement() {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);

        return $element;
    }

    public function validate(Varien_Object $object) {

        if (!Mage::helper("troopid_connect")->isEnabled())
            return true;

        $quote = $object->getQuote();
        $value = $quote->getTroopidAffiliation();

        return $value === $this->getValue();
    }

}