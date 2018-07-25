<?php
class WannafindFailedModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
	public function initContent()
    {
		 parent::initContent();
		 
		 $this->setTemplate('module:wannafind/views/templates/front/failed.tpl');
	}
}
