<?php

namespace Core\Controllers\Default;

use Core\Tools\DebugTool;

class Controller
{
    public function show(string $page, array $attr = []): void
    {
        foreach ($attr as $k => $v) {
            $$k = $v;
        }
        $filePath = 'public/' . str_replace('.', '/', $page) . '.php';
        $this->renderPage($filePath, $attr);
    }

    protected function renderHeader(): string
    {
        ob_start();
        ob_implicit_flush(false);
        if (!file_exists('public/header.php')) {
            return '';
        }
        require 'public/header.php';
        $header = ob_get_clean();
        ob_end_clean();

        return $header;
    }

    protected function renderPage(string $filePath, array $attr): void
    {

        $header = $this->renderHeader();
        ob_start();
        extract($attr, EXTR_OVERWRITE);
        require $filePath;
        $file = ob_get_clean();
        $checkAttr = preg_match_all('/@(.+?)@/', $file, $matches);

        foreach (current($matches) as $math) {
            $attr = explode('=', $math);
            $attrName = str_replace('@', '', current($attr));
            $attrValue = str_replace('@', '', $attr[1]);
            $header = str_replace('@' . $attrName . '@', $attrValue, $header);
            $file = str_replace($math, '', $file);
        }

        $header = preg_replace('/@(.+?)@/', '', $header);

        echo $header;
        echo $file;

        ob_end_clean();
        if (file_exists('public/footer.php')) {
            require 'public/footer.php';
        }
    }
    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    public function __call(string $method, array $arguments): void
    {
        echo $method . ' not foud';
    }
}
