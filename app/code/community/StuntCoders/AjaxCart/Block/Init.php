<?php

class StuntCoders_AjaxCart_Block_Init extends Mage_Core_Block_Template
{
    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        if (!$this->_getHelper()->canUseAjaxCart()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * @return Stuntcoders_AjaxCart_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('stuntcoders_ajaxcart');
    }
}
