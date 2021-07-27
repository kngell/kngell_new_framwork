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

    public function resolve();

    public function get(string $path, mixed $callback);

    public function post(string $path, mixed $callback);

    public function getResponse();
}