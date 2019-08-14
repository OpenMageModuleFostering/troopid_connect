<?php
class TroopID_Connect_Model_Rule_Observer {

    public function addCondition(Varien_Event_Observer $observer) {

        if (!Mage::helper("troopid_connect")->isEnabled())
            return;

        $conditions = (array) $observer->getEvent()->getAdditional()->getConditions();
        $conditions = array_merge_recursive($conditions, array(
            array(
                "label" => Mage::helper("troopid_connect")->__("Troop ID Attribute"),
                "value" => array(
                    array(
                        "label" => Mage::helper("troopid_connect")->__("Troop ID Verified Affiliation"),
                        "value" => "troopid_connect/rule_condition"
                    )
                )
            )
        ));

        $observer->getEvent()->getAdditional()->setConditions($conditions);
    }

}