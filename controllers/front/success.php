<?php
class WannafindSuccessModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
	public function initContent()
    {
		 parent::initContent();
		 
		 $cart = $this->context->cart;
		 if (Validate::isLoadedObject($cart) && !Order::getOrderByCartId((int)Tools::getValue('cart')))
		{
		 $this->module->validateOrder((int)$cart->id, (int)Configuration::get('PS_OS_PREPARATION'), (float)$cart->getOrderTotal(), $this->module->displayName,'', array(), null, false, $cart->secure_key);
		}
		
		 
		 $this->setTemplate('module:wannafind/views/templates/front/success.tpl');
	}
}
