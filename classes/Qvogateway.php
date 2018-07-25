<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
class Qvogateway extends ObjectModel
{
    public $id_qvogateway;
    public $id_cart;
    public $amount;
    public $redirect_url;
    public $transaction_id;
    public $status;
    public $response;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table'     => 'qvo_gateways',
        'multilang' => false,
        'primary'   => 'id_qvogateway',
        'fields'    => array(
            'id_cart'        => array('type' => Self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size' => 11),
            'amount'         => array('type' => Self::TYPE_FLOAT),
            'redirect_url'   => array('type' => Self::TYPE_STRING),
            'transaction_id' => array('type' => Self::TYPE_STRING),
            'status'         => array('type' => Self::TYPE_STRING),
            'response'       => array('type' => Self::TYPE_STRING),
            'date_add'       => array('type' => Self::TYPE_DATE, 'copy_post' => false),
            'date_upd'       => array('type' => Self::TYPE_DATE, 'copy_post' => false),
        ));

    public static function addNewRequest($id_cart, $amount, $redirect_url, $transaction_id, $status)
    {
        $doadd                 = new self();
        $doadd->id_cart        = (int) $id_cart;
        $doadd->amount         = (int) $amount;
        $doadd->transaction_id = pSQL($transaction_id);
        $doadd->redirect_url   = pSQL($redirect_url);
        $doadd->status         = 'Pending';
        $doadd->date_add       = pSQL(date('Y-m-d H:i:s'));
        $done                  = $doadd->add();
        if ($done == 1) {
            return Db::getInstance()->Insert_ID();
        }
    }

    public static function getByTransID($id)
    {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'qvo_gateways WHERE transaction_id = "' . pSQL($id) . '"';

        return Db::getInstance()->getRow($sql);
    }

    public static function getByCartid($id)
    {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'qvo_gateways WHERE id_cart = ' . (int) ($id);

        return Db::getInstance()->getRow($sql);
    }

    public static function updateStatus($id_qvogateway, $status)
    {
        $updated = Db::getInstance()->update('qvo_gateways', array('status' => pSQL($status)), 'id_qvogateway=' . (int) $id_qvogateway);
        if ($updated) {
            return true;
        }

        return false;
    }

    public static function logPayment($id_qvogateway, $response)
    {
        $updated = Db::getInstance()->update('qvo_gateways', array('response' => pSQL($response)), 'id_qvogateway=' . (int) $id_qvogateway);
        if ($updated) {
            return true;
        }

        return false;
    }
}
