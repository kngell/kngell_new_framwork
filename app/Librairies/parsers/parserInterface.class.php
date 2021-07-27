<?php
declare(strict_types=1);
interface ParserInterface
{
    public static function parse(string $file, string $keytoReturn) : array;
}