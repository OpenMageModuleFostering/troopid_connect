<?php

class TroopID_Connect_Block_Adminhtml_System_Config_Help extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

    protected function _getHeaderTitleHtml($element) {
        $html = '<div class="config-heading"><div class="heading"><strong>' . $element->getLegend() . '</strong>';
        $html .= '<span class="heading-intro">' . $element->getComment() . '</span></div>';
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