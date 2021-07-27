<?php
declare(strict_types=1);

use Stripe\PaymentIntent;

class TransactionsManager extends Model
{
    protected $_colID = 'trID';
    protected $_table = 'transactions';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    public function savePayment(PaymentIntent $pmg, OrdersManager $order) : mixed
    {
        $this->transactionID = $pmg->id;
        $this->customerID = $pmg->id;
        $this->orderID = $order->get_lastID();
        $this->order_amount = $pmg->amount;
        $this->currency = $pmg->currency;
        $this->status = $pmg->status;
        if ($r = $this->save()) {
            return $r;
        }
        return false;
    }
}