<?php
declare(strict_types=1);

interface PaymentGatewayInterface
{
    /**
     * Create Payment Intent
     * --------------------------------------------------------------------------------------------------
     *
     * @return Object
     */
    public function createPaymentIntent() : ?Object;

    /**
     * Confirm Payment Intent
     * --------------------------------------------------------------------------------------------------
     * @return Object
     */
    public function confirmPaymentIntent() : Object;

    /**
     * Create Custumer
     * --------------------------------------------------------------------------------------------------
     * @return Object
     */
    public function createCustomer() : Object;

    /**
     * Get Payment intent
     * --------------------------------------------------------------------------------------------------
     * @return Object
     */
    public function getPaymentIntent() : Object;

    /**
     * Get Customer
     * --------------------------------------------------------------------------------------------------
     * @return Object
     */
    public function getCustomer() : Object;
}