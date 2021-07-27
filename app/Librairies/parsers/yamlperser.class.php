<?php

declare(strict_types=1);
use Symfony\Component\Yaml\Yaml;

class YamlParser implements ParserInterface
{
    public static function parse(string $file, string $keytoReturn) : array
    {
        $content = Yaml::parseFile(filename: $file);
        if (!isset($content[$keytoReturn])) {
            throw new InvalidArgumentException(message : "Invalid key [$keytoReturn] in YAML File {$file}");
        }
        return $content[$keytoReturn];
    }
}