<?php
if (!defined('_PS_VERSION_')) {
    exit;
}


require_once dirname(__FILE__) . '/../../classes/Qvogateway.php';

require_once dirname(__FILE__) . '/../../classes/QvoService.php';
class QvopaymentgatewayValidationModuleFrontController extends ModuleFrontController
{

    public $errorbag;
    public $trans_id;
    public $amountpaid;
    public function postProcess()
    {
        parent::postProcess();

        if (Tools::getIsset('transaction_id')) {
            $this->trans_id = Tools::getValue('transaction_id');
        } else {
            $this->errorbag[] = $this->module->l('No data sent for validation');
            return;
        }
         if(!$this->context){
             $this->context == Context::getContext();
         }

         if($this->checkIfPaid()){
            Tools::redirect($this->context->link->getPageLink('history', true));
         }

        $cart = new Cart((int) $this->context->cart->id);

        if(!$this->module->active){
            $this->errorbag[] = $this->module->l('Error: Esta pasarela de pago ha sido desactivada');
        }

          if ((int) $cart->id_customer == 0 || (int) $cart->id_address_delivery == 0 ||   (int) $cart->id_address_invoice == 0){
              $this->errorbag[] = $this->module->l('Error: Cliente o direccion de cliente invalida');
          }


        $currency = new Currency((int) $cart->id_currency);
        $customer = new Customer((int) $cart->id_customer);

        $supportedcurrency = $this->module->getCurrency((int) $this->context->cart->id_currency);

        if (!$this->checkSupported($supportedcurrency, $currency)) {
            $this->errorbag[] = $this->module->l('Esta moneda no es soportada por esta pasarela');
            return;
        }

        if (!Validate::isLoadedObject($customer)) {
            $this->errorbag[] = $this->module->l('Error: Informacion del cliente no disponible');
            return;
        }

        $carttotal = (float) $cart->getOrderTotal(true, Cart::BOTH);

        $extra_vars = array(

            '{total_paid}'     => Tools::displayPrice($carttotal),
            '{paid_via}'       => 'WebPay Plus',
            '{transaction_id}' => $this->trans_id,

        );

        if ($this->processCharge() === true) {

$this->module->validateOrder($cart->id, Configuration::get('PS_OS_PAYMENT'), $carttotal, $this->module->displayName, null, $extra_vars, (int) $currency->id, false, $customer->secure_key);
            $order                       = new Order((int) $this->module->currentOrder);
            $payments                    = $order->getOrderPaymentCollection();
            $payments[0]->transaction_id = $this->trans_id;
            $payments[0]->update();

    Tools::redirect('index.php?controller=order-confirmation&id_cart=' . $cart->id . '&id_module=' . $this->module->id . '&id_order=' . $this->module->currentOrder . '&key=' . $customer->secure_key);
       exit;

        }

    }

    public function checkSupported($supportedcurrency, $currentcurrency)
    {
        if (is_array($supportedcurrency)) {
            foreach ($supportedcurrency as $supported) {
                if ($currentcurrency->id == $supported['id_currency']) {
                    return true;
                }
            }
        }

        return false;
    }

    public function initContent()
    {
        $this->display_column_left  = false;
        $this->display_column_right = false;
        parent::initContent();
        $this->context->smarty->assign(array('errbag' => $this->errorbag));

        $this->setTemplate('module:qvopaymentgateway/views/templates/front/valid17.tpl');

    }

    public function setMedia()
    {
        parent::setMedia();
    }

    public function checkIfPaid()
    {
        $storeddata    = Qvogateway::getByTransID($this->trans_id);
        if($storeddata['status'] =='Paid'){
            return true;
        }
        return false;

    }

    public function processCharge()
    {
        $storeddata    = Qvogateway::getByTransID($this->trans_id);
        $paymentresult = $this->getPaymentResult();
        if ($storeddata && $storeddata['status'] == 'Pending') {

            if (is_object($paymentresult)) {
                if (((int) $paymentresult->amount == (int) $storeddata['amount']) && $paymentresult->status == 'successful') {

                    Qvogateway::updateStatus($storeddata['id_qvogateway'], 'Paid');
                    Qvogateway::logPayment($storeddata['id_qvogateway'], print_r($paymentresult, true));
                    return true;
                }

        $this->errorbag[] = $this->module->l('Pago no completado, por favor intente nuevamente');

                return false;
            }

            Qvogateway::logPayment($storeddata['id_qvogateway'], print_r($paymentresult, true));
            return false;
        }
        return false;
    }

    public function getPaymentResult()
    {

        $paymentdata = $this->module->requestData();
         try{

            $service = new QvoService();

            $url =$paymentdata['base_url'] . '/transactions/' . $this->trans_id;

         $headers[] = 'Authorization: Bearer '.$paymentdata['apitoken'];

         $result = $service->httpGetIt( $headers, $url);
        $response = json_decode($result);

        return $response;
    }
    catch(Exception $e){
        $this->errorbag[] = $this->module->l('No es posible conectar con la pasarela');
        return false;
    }
    }
}
