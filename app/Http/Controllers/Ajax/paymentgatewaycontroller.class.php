<?php

declare(strict_types=1);

class PaymentgatewayController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    public function successPaymentPage($data)
    {
        $r = $data;
    }

    public function cancelPaymentPage($data)
    {
        $r = $data;
    }
}