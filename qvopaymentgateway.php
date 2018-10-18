<?php
if (!defined('_PS_VERSION_')){
	exit;
}
use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

class qvopaymentgateway extends PaymentModule {

	private $_postErrors = array();

public function __construct() {
	$this->name = 'qvopaymentgateway';
	$this->tab = 'payments_gateways';
	$this->version = '1.14';
	$this->author = 'QVO';
	$this->bootstrap = true;
	$this->currencies = true;
	$this->currencies_mode = 'checkbox';
	$this->controllers = array('payment', 'validation');
	parent::__construct();

	$this->displayName = $this->trans('QVO - Pago a través de WebPay Plus', array(), 'Modules.Qvopaymentgateway.Admin');
	$this->description = $this->trans('Pago con Tarjetas de Crédito o Redcompra', array(), 'Modules.Qvopaymentgateway.Admin');
	$this->confirmUninstall = $this->trans('¿Estás seguro de que deseas desinstalar?', array(), 'Modules.Qvopaymentgateway.Admin');
	$this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
}

public function install() {
	$sqlfile = dirname(__FILE__).'/install/install.sql';
	return parent::install() &&  $this->doDatabaseInstallation($sqlfile) &&
	$this->registerHook('footer') &&
	$this->registerHook('displayPaymentReturn') &&
	$this->registerHook('adminOrder') &&
	$this->registerHook('paymentOptions') &&
	$this->registerHook('displayHeader') &&
	$this->registerHook('paymentReturn');
}

public function hookAdminOrder($params) {
	$order_id=$params['id_order'];
	$msg = new Message();
	$res=$msg->getMessagesByOrderId($order_id,true);
	if(is_array($res) && !empty($res)) {
		$message="";
		foreach($res as $km=>$vm) {
			$message.=$vm['message'];
		}
	}
	else {
		return;
	}
	$this->smarty->assign('message',$message);
	return $this->display(__FILE__, 'tpl/orderdetail.tpl');
}

public function prefillConfig() {
	Configuration::updateValue('QVO_WEBPAY_PLUS_TITLE','Pago con Tarjetas de Crédito o Redcompra');
	Configuration::updateValue('QVO_WEBPAY_PLUS_DESCR','Paga con tu tarjeta usando Webpay Plus');
	return true;
}


public function uninstall() {
	$sqlfile = dirname(__FILE__).'/install/uninstall.sql';
	if(!parent::uninstall() ||  !$this->doDatabaseInstallation($sqlfile) || !$this->destroySettingData() ) {
		return false;
	}
	return true;
}

public function requestData() {
	$r = array();
	if((int)Configuration::get('QVO_WEBPAY_PLUS_PAYMENT_MODE') ==1){
		$r['apitoken'] = Configuration::get('QVO_WEBPAY_PLUS_API_TOKEN_LIVE');
		$r['base_url']= 'https://api.qvo.cl';
	}
	else{
		$r['apitoken'] = Configuration::get('QVO_WEBPAY_PLUS_API_TOKEN_TEST');
		$r['base_url']='https://playground.qvo.cl';
	}
	return $r;
}

public function doDatabaseInstallation($sqlfile) {
	$read_sql = Tools::file_get_contents($sqlfile);
	$read_sql = str_replace('PREFIX_', _DB_PREFIX_, $read_sql);
	$sql_rep = preg_split("/;\s*[\r\n]+/", $read_sql);
	$result = true;
	foreach ($sql_rep as $request) {
		if (!empty($request)) {
			$result &= Db::getInstance()->execute(trim($request));
		}
	}
	return $result;
}

public function destroySettingData() {
	Configuration::deleteByName('QVO_WEBPAY_PLUS_TITLE');
	Configuration::deleteByName('QVO_WEBPAY_PLUS_DESCR');
	Configuration::deleteByName('QVO_WEBPAY_PLUS_API_TOKEN_TEST');
	Configuration::deleteByName('QVO_WEBPAY_PLUS_API_TOKEN_LIVE');
	Configuration::deleteByName('QVO_WEBPAY_PLUS_PAYMENT_MODE');
	return true;
}

public function hookDisplayHeader() {
	if (!$this->context) {
		$this->context = Context::getContext();
	}
	if ('order' === $this->context->controller->php_self) {
		$this->context->controller->registerStylesheet(
		'module-qvopaymentgateway-qvo',
		'modules/'.$this->name.'/views/css/qvo.css');
		$this->context->controller->registerJavascript(
		'module-qvopaymentgateway-qvojs',
		'modules/'.$this->name.'/views/js/qvo.js'
		);
		return $this->display(__FILE__, 'displayheader.tpl');
	}
}

public function hookDisplayPaymentReturn($params) {
	if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
		return $this->hookPaymentReturn($params);
	}
	if (!$this->active)
	return;
	$this->smarty->assign(array(
	'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
	'status' => 'ok',
	'id_order' => $params['objOrder']->id,
	));
	if (isset($params['objOrder']->reference) && !empty($params['objOrder']->reference))
	$this->smarty->assign('reference', $params['objOrder']->reference);
	return $this->display(__FILE__, 'paymentreturn.tpl');
}

public function hookPaymentReturn($params) {
	if (!$this->active){
		return;
	}
	$currency = new Currency($params['order']->id_currency);
	$total_to_pay = $params['order']->getOrdersTotalPaid();
	$state = $params['order']->getCurrentState();
	$this->smarty->assign(array(
	'total_to_pay' => Tools::displayPrice($total_to_pay, $currency, false),
	'status' => 'ok',
	'id_order' => $params['order']->id,
	'shop_name'=> \Configuration::get('PS_SHOP_NAME'),
	));
	if (isset($params['order']->reference) && !empty($params['order']->reference))
	$this->smarty->assign('reference', $params['order']->reference);
	return $this->display(__FILE__, 'paymentreturn.tpl');
}

public function hookPaymentOptions($params) {
	if (!$this->active) {
		return;
	}
	if (!$this->checkCurrency($params['cart'])) {
		return;
	}
	if (!$this->context) {
		$this->context = Context::getContext();
	}
	$payment_title=(Configuration::get('QVO_WEBPAY_PLUS_TITLE') !='')?Configuration::get('QVO_WEBPAY_PLUS_TITLE') :'Pago con Tarjetas de Crédito o Redcompra';
	$payment_desc=(Configuration::get('QVO_WEBPAY_PLUS_DESCR') !='')?Configuration::get('QVO_WEBPAY_PLUS_DESCR') :'Paga con tu tarjeta usando Webpay Plus';
	$cart = new Cart((int) $this->context->cookie->id_cart);
	$customer = new Customer((int) $this->context->customer->id);
	$currency = new Currency((int) $cart->id_currency);
	$carttotal = (float) $cart->getOrderTotal(true, Cart::BOTH);
	$newOption = new PaymentOption();
	// $newOption->setBinary(true)
	$newOption->setCallToActionText($this->trans($payment_title, array(), 'Modules.QvopaymentGateway.Shop'))
	->setLogo(Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/views/img/webpay.png'))
	->setAction($this->context->link->getModuleLink($this->name, 'payment'))
	->setAdditionalInformation($this->trans($payment_desc, array(), 'Modules.QvopaymentGateway.Shop'));
	$payment_options = array(
		$newOption,
	);
	return $payment_options;
}


public function checkCurrency($cart) {
	$currency_order = new Currency((int)($cart->id_currency));
	$currencies_module = $this->getCurrency((int)$cart->id_currency);
	if (is_array($currencies_module)) {
		foreach ($currencies_module as $currency_module) {
			if ($currency_order->id == $currency_module['id_currency']) {
				return true;
			}
		}
	}
	return false;
}


public function getContent() {
	$this->context->controller->addJS(_MODULE_DIR_.$this->name.'/views/js/riot.min.js');
	$this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/views/css/qvo.css');
	$sv = 'ko';
	if (Tools::isSubmit('qvopaymentconfiguration')) {
		\Configuration::updateValue('QVO_WEBPAY_PLUS_TITLE', Tools::getValue('QVO_WEBPAY_PLUS_TITLE'));
		\Configuration::updateValue('QVO_WEBPAY_PLUS_DESCR', Tools::getValue('QVO_WEBPAY_PLUS_DESCR'));
		\Configuration::updateValue('QVO_WEBPAY_PLUS_API_TOKEN_TEST', Tools::getValue('QVO_WEBPAY_PLUS_API_TOKEN_TEST'));
		\Configuration::updateValue('QVO_WEBPAY_PLUS_API_TOKEN_LIVE', Tools::getValue('QVO_WEBPAY_PLUS_API_TOKEN_LIVE'));
		\Configuration::updateValue('QVO_WEBPAY_PLUS_PAYMENT_MODE', Tools::getValue('QVO_WEBPAY_PLUS_PAYMENT_MODE'));
		$sv = 'ok';
	}
	$this->context->smarty->assign(array(
	'logoimage' => _MODULE_DIR_.$this->name.'/views/img/Webpay50x50.png',
	'QVO_WEBPAY_PLUS_TITLE' => \Configuration::get('QVO_WEBPAY_PLUS_TITLE'),
	'QVO_WEBPAY_PLUS_DESCR' => \Configuration::get('QVO_WEBPAY_PLUS_DESCR'),
	'QVO_WEBPAY_PLUS_PAYMENT_MODE' => \Configuration::get('QVO_WEBPAY_PLUS_PAYMENT_MODE'),
	'QVO_WEBPAY_PLUS_API_TOKEN_LIVE' => \Configuration::get('QVO_WEBPAY_PLUS_API_TOKEN_LIVE'),
	'QVO_WEBPAY_PLUS_API_TOKEN_TEST' => \Configuration::get('QVO_WEBPAY_PLUS_API_TOKEN_TEST'),
	'savedok' =>$sv,
	));
	$html = $this->display(__FILE__, 'getContent.tpl');
	return $html.$this->display(__FILE__, 'views/templates/admin/prestui/ps-tags.tpl');
}


}
