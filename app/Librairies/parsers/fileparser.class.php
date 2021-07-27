<?php
declare(strict_types=1);

use function PHPUnit\Framework\matches;

class FileParser
{
    public static array $method = ['get', 'put', 'post', 'patch', 'delete', 'options', 'head', 'trace'];

    public static function parse(string $file) : array
    {
        $paths = static::getPaths(file: $file);
        $routes = [];
        foreach ($paths as $key => $path) {
            foreach ($path as $method => $item) {
                // dump($item);
                if (in_array($method, static::$method)) {
                    $routes[] = [
                        'method' => $method,
                        'route' => $key,
                        'name' => $item['operationId'] ?? null
                    ];
                }
            }
        }
        return $routes;
    }

    public static function getPaths(string $file) : array
    {
        $infos = pathinfo($file);
        return match($infos['extension']){
            'json' => JsonParser::parse(file: $file, keytoReturn: 'paths'),
            'yaml' => YamlParser::parse(file: $file, keytoReturn: 'paths'),
        };
    }
}