<?php

namespace VVF\Controllers\Page;

use VVF\ErrorHandler\ErrorHandler;

class PageFactory
{
    const FOOTER = 'footer';
    const HEADER = 'header';
    protected string $filePath = '';
    protected array $attr = [];

    public function renderPage(string $filePath, array $attr): void
    {
        $this->setFilePath($filePath)->setAttr($attr)->build();
    }

    protected function renderElement(string $element = ''): string
    {
        ob_start();
        ob_implicit_flush(false);
        if (!file_exists('public/' . $element . '.php')) {
            throw new ErrorHandler('"public/' . $element . '.php" not found element');
        }
        require 'public/' . $element . '.php';
        $header = ob_get_clean();

        return $header;
    }

    protected function build(): void
    {
        foreach ($this->attr as $k => $v) {
            $$k = $v;
        }

        $header = $this->renderElement(self::HEADER);
        $footer = $this->renderElement(self::FOOTER);

        ob_start();
        extract($this->attr, EXTR_OVERWRITE);

        if (!file_exists($this->getFilePath())) {
            throw new ErrorHandler('Cant found ' . $this->getFilePath());
        }

        require $this->getFilePath();
        $body = ob_get_clean();
        $checkAttr = preg_match_all('/@(.+?)@/', $body, $matches);

        foreach (current($matches) as $math) {
            $attr = explode('=', $math);
            $attrName = str_replace('@', '', current($attr));
            $attrValue = str_replace('@', '', $attr[1]);
            $header = str_replace('@' . $attrName . '@', $attrValue, $header);
            $body = str_replace($math, '', $body);
        }

        $header = preg_replace('/@(.+?)@/', '', $header);

        echo $header;
        echo $body;
        echo $footer;

        ob_end_clean();
    }

    public function setAttr(array $attr): self
    {
        $this->attr = $attr;
        return $this;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
