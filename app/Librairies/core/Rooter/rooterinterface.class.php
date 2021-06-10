<?php

declare(strict_types=1);
interface RooterInterface
{
    /**
     * Dispatch Route
     * --------------------------------------------------------------------------------------------------
     * @param string $url
     * @return void
     */
    public function dispatch():void;

    /**
     * UParse url and return ??
     * --------------------------------------------------------------------------------------------------
     * @return string
     */
    public function parseUrl() : string;

    /**
     * Validate Url
     * --------------------------------------------------------------------------------------------------
     * @param string $controller
     * @return boolean
     */
    public function IsvalidController(string $controller) : bool;
}