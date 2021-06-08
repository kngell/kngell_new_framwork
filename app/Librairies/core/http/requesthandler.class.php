<?php
declare(strict_types=1);
use Symfony\Component\HttpFoundation\Request;

class RequestHandler
{
    /**
     * Handler http request
     *
     * @return Request
     */
    public function handler() : Request
    {
        if (!isset($request)) {
            $request = new Request();
            if ($request) {
                $create = $request->createFromGlobals();
                if ($create) {
                    return $create;
                }
            }
        }
        return false;
    }
}