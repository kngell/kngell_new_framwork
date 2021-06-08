<?php
declare(strict_types=1);
use Symfony\Component\Yaml\Yaml;

class YamlConfig
{
    private function isFileExsit(string $fileName)
    {
        if (!file_exists($fileName)) {
            throw new BaseException($fileName . ' does not exist');
        }
    }

    public function getYaml(string $yamlFile)
    {
        foreach (glob(CONFIG_PATH . DS . '*.yaml') as $file) {
            $this->isFileExsit($file);
            $parts = parse_url($file);
            $path = $parts['path'];
            if (strpos($path, $yamlFile) !== false) {
                return Yaml::parseFile($file);
            }
        }
    }

    public static function file(string $yamFile)
    {
        return (new self())->getYaml($yamFile);
    }
}