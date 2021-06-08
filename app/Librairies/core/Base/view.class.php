<?php

declare(strict_types=1);

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class View
{
    /**
     * Undocumented function
     *
     * @param string $htmlTemplate
     * @param array $context
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function getTemplate(string $htmlTemplate, array $context = []) : string
    {
        static $twig;
        if ($twig === null) {
            $loader = new FilesystemLoader('Templates', TEMPLATE_PATH);
            $twig = new Environment($loader, YamlConfig::file('twig'));
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new TwigExtension());
            return $twig->render($htmlTemplate, $context);
        }
    }

    public function twigRender(string $htmlTemplate, array $context = [])
    {
        echo $this->getTemplate($htmlTemplate, $context);
    }
}