<?php

use Symfony\Component\HttpFoundation\Response;

declare(strict_types=1);

class ResponseHandler
{
    /**
     * Handler http response
     *
     * @return Response
     */
    public function handler() :Response
    {
        if (!isset($request)) {
            $response = new Response();
            if ($response) {
                return $response;
            }
        }
        return false;
    }
}