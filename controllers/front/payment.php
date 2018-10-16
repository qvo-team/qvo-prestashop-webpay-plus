<?php
require_once dirname(__FILE__) . '/../../classes/Qvogateway.php';
require_once dirname(__FILE__) . '/../../classes/QvoService.php';

class QvopaymentgatewayPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl                 = true;
    public $display_column_left = false;
    public $errorbag;
    /**
     * @see FrontController::initContent()
     */

    public function postProcess()
    {
        $cart = $this->context->cart;
        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
        }
        if (!$this->module->checkCurrency($cart)) {
            Tools::redirect('index.php?controller=order');
        }

        $customer = new Customer($cart->id_customer);

        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        if (Validate::isLoadedObject($cart) && !Order::getOrderByCartId((int) Tools::getValue('cart'))) {
            $currency      = new Currency((int) $cart->id_currency);
            $curcode       = $currency->iso_code;
            $lang_iso_code = $this->context->language->iso_code;

            // print_r($this->module->requestData());
            // exit;

            $daresponse = $this->getPaymentURL($cart);
            if (is_object($daresponse)) {
                if ($daresponse->redirect_url) {
                    $carttotal = ceil($cart->getOrderTotal(true, Cart::BOTH));
                    Qvogateway::addNewRequest($cart->id, $carttotal, $daresponse->redirect_url, $daresponse->transaction_id, 'Pending');
                    Tools::redirect($daresponse->redirect_url);
                }
            }

        }

    }

      public function initContent()
    {
        $this->display_column_left  = false;
        $this->display_column_right = false;
        parent::initContent();
        $this->context->smarty->assign(array('errbag' => $this->errorbag));

        $this->setTemplate('module:qvopaymentgateway/views/templates/front/payment.tpl');

    }

    public function getPaymentURL($cart)
    {

        if($this->module->name =="qvopaymentgateway"){
             require_once dirname(__FILE__) . '/../../vendor/autoload.php';
        }

        $paymentdata     = $this->module->requestData();
        $return_url      = $this->context->link->getModuleLink($this->module->name, 'validation');
        $customer_id     = $cart->id . '_' . $cart->id_customer;
        $carttotal       = $cart->getOrderTotal(true, Cart::BOTH);
        $carttotal       = ceil($carttotal);
        $product_in_cart = $cart->getProducts();
        $product_info    = '';
        $i               = 1;
        if (count($product_in_cart) > 1) {
            foreach ($product_in_cart as $moreproduct) {
                $product_info .= ' (' . $i . ') ' . $moreproduct['name'];
                ++$i;
            }
        } else {
            $product_info .= array_shift($product_in_cart)['name'];
        }
        try{
     $service = new QvoService();
    $url =$paymentdata['base_url'] . '/webpay_plus/charge';
    $string = json_encode(['amount' => $carttotal, 'return_url' => $return_url, 'customer_id' => $customer_id]);

    $headers[] = 'Authorization: Bearer '.$paymentdata['apitoken'];

   $response =  $service->httpRequest($string, $headers, $url);



   $result = json_decode($response);


        return $result;
        }
        catch(Exception $e){
            Tools::redirect('index.php?controller=order&step=1');
        } 

    }

}
