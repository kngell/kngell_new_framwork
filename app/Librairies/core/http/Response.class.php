<?php
declare(strict_types=1);
class Response extends HttpGlobals
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    public function setHeader()
    {
        // array holding allowed Origin domains
        $allowedOrigins = [
            'https://localhost:3003'
        ];
        $origin = $this->getServer('HTTP_ORIGIN');
        if (isset($origin) && $origin != '') {
            foreach ($allowedOrigins as $allowedOrigin) {
                if (preg_match('#' . $allowedOrigin . '#', $origin)) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
                    header('Access-Control-Max-Age: 1000');
                    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
                    header('Access-Control-Max-Age: 86400');
                    header('Content-type: application/json; charset=UTF-8');
                    // header('Access-Control-Allow-Origin: *');
                    break;
                }
            }
        }
        http_response_code(200);
    }
}