<?php

class StuntCoders_AjaxCart_CartController extends Mage_Core_Controller_Front_Action
{
    public function ajaxAddAction()
    {
        if (!$this->_validateFormKey()) {
            return;
        }

        $cart = $this->_getCart();
        $params = $this->getRequest()->getParams();
        $result = array();
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );

                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            if (!$product) {
                return;
            }

            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);
            Mage::dispatchEvent('checkout_cart_add_product_complete', array(
                'product' => $product,
                'request' => $this->getRequest(),
                'response' => $this->getResponse(),
            ));

            if (!$cart->getQuote()->getHasError()) {
                $result['success'] = 1;
                $result['message'] = $this->__(
                    '%s was added to your shopping cart.',
                    Mage::helper('core')->escapeHtml($product->getName())
                );
            }
        } catch (Mage_Core_Exception $e) {
            $result['success'] = 0;
            $result['message'] = $e->getMessage();
        } catch (Exception $e) {
            $result['success'] = 0;
            $result['message'] = $this->__('Cannot add the item to shopping cart.');
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * @return Mage_Catalog_Model_Product|false
     */
    protected function _initProduct()
    {
        $productId = (int) $this->getRequest()->getParam('product');
        if (!$productId) {
            return false;
        }

        /** @var Mage_Catalog_Model_Product $product */
        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);

        if (!$product->getId()) {
            return false;
        }

        return $product;
    }
}
