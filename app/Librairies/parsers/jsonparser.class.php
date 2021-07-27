<?php
declare(strict_types=1);
class JsonParser implements ParserInterface
{
    public static function parse(string $file, string $keytoReturn) : array
    {
        $content = json_decode(file_get_contents($file), true);
        if (!isset($content[$keytoReturn])) {
            throw new InvalidArgumentException(message : "Invalid key [$keytoReturn] in JSON File {$file}");
        }
        return $content[$keytoReturn];
    }
}