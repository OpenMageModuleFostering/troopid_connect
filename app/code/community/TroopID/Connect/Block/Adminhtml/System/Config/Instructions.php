<?php

class TroopID_Connect_Block_Adminhtml_System_Config_Instructions extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

    protected function _getHeaderTitleHtml($element) {
        $config = $this->getGroup($element)->asArray();

        $html = '<div class="config-heading"><div class="heading"><strong>' . $element->getLegend() . '</strong></div>';
        $html .= '<ul class="steps">';
        $html .= '<li>' . $this->__("Create a developer account at") . ' <a href="' . $config["developer_url"] . '" target="_blank">' . $config["developer_url"] . '</a></li>';
        $html .= '<li>' . $this->__("Register an application at") . ' <a href="' . $config["apps_url"] . '" target="_blank">' . $config["apps_url"] . '</a></li>';
        $html .= '<li>' . $this->__("Fill in <strong>Redirect URI</strong> with") . ' ' . Mage::getUrl("troopid/authorize/callback") . '</li>';
        $html .= '<li>' . $this->__("Fill in <strong>Base URI</strong> with") . ' ' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . '</li>';
        $html .= '<li>' . $this->__("Copy and paste your <strong>Client ID</strong> and <strong>Client Secret</strong> values from your application settings on Troop ID") . '</li>';
        $html .= '<li>' . $this->__("That's it! You are ready to go.") . '</li>';
        $html .= '</ul>';
        $html .= '<div class="heading"><span class="heading-intro"><a href="' . $config["learn_more_url"] . '" target="_blank">' . $this->__("Learn more about Troop ID") . '</a></span></div>';
        $html .= '<div class="heading"><span class="heading-intro"><a href="' . $config["docs_url"] . '" target="_blank">' . $this->__("Read developer documentation") . '</a></span></div>';
        $html .= '</div>';

        return $html;
    }

    protected function _getHeaderCommentHtml($element) {
        return '';
    }

    protected function _getCollapseState($element) {
        return false;
    }

}