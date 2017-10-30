<?php

class StuntCoders_AjaxCart_Helper_Data extends Mage_Core_Helper_Abstract
{
    const USE_AJAX_CART_SYSTEM_PATH = 'checkout/cart/ajax_cart';

    /**
     * @param mixed $store
     * @return bool
     */
    public function canUseAjaxCart($store = null)
    {
        return Mage::getStoreConfigFlag(self::USE_AJAX_CART_SYSTEM_PATH, $store);
    }
}
