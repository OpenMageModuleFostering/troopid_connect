<?php
class TroopID_Connect_Model_Order_Observer {

    protected $options = array();

    public function addCollection(Varien_Event_Observer $observer) {
        $collection = $observer->getOrderGridCollection();

        if (!isset($collection))
            return;

        $tablename  = $collection->getTable("sales/order");

        $select = $collection->getSelect();
        $select->joinLeft(array("order" => $tablename), "order.entity_id = main_table.entity_id", array("troopid_scope"));
    }

    public function addColumn(Varien_Event_Observer $observer) {
        $block = $observer->getBlock();

        if (!isset($block))
            return;

        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_Grid) {

            $block->addColumnAfter(
                "troopid_scope",
                array(
                    "header"        => "ID.me Affiliation",
                    "index"         => "troopid_scope",
                    "type"          => "options",
                    "filter"        => "TroopID_Connect_Block_Widget_Grid_Column_Filter_Scope",
                    "renderer"      => "TroopID_Connect_Block_Widget_Grid_Column_Renderer_Scope",
                    "filter_index"  => "order.troopid_scope",
                ),
                "shipping_name"
            );
        }
    }

}