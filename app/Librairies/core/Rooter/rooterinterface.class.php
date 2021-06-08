<?php

declare(strict_types=1);
interface RooterInterface
{
    //=======================================================================
    //Add route to the rooting table
    //=======================================================================

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function add(string $route, array $params):void;

    //=======================================================================
    //dispatch route and create a controller object and execute default method
    //=======================================================================

    /**
    * @param string $url
    * @return void
    */
    public function dispatch(string $url):void;
}
