<?php

declare(strict_types=1);
interface RooterInterface
{
    /**
     * Dispatch Route
     * --------------------------------------------------------------------------------------------------
     * @return void
     */
    public function dispatch():void;

    /**
     * UParse url and return ??
     * --------------------------------------------------------------------------------------------------
     * @param string $urlroute
     * @return string
     */
    public function parseUrl(string $urlroute) : string;

    /**
     * Validate Url
     * --------------------------------------------------------------------------------------------------
     * @param string $controller
     * @return boolean
     */
    public function IsvalidController(string $controller) : bool;
}