<?php

namespace App\Lib\Templating;

use Twig_Environment;

class Templater
{
    protected $twigEnv;
    protected $twigLoader;

    public function __construct()
    {
        $this->twigLoader = new Twig_Loader_Filesystem(__DIR__.'/../../../public/templates');
        $this->twigEnv    = new Twig_Environment($this->twigLoader);
    }

    public function render(string $file, array $params = []): string
    {
        $template = $this->twigEnv->load($file)

        return $template->render($params);
    }
}
