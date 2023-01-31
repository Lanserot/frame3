<?php

namespace Core\Controllers\Default\Page;

class PageFactory
{
    protected string $filePath = '';
    protected array $attr = [];

    public function renderPage(string $filePath, array $attr): void
    {
        $this->setFilePath($filePath)->setAttr($attr)->build();
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

        return $header;
    }

    protected function renderFooter(): string
    {
        ob_start();
        ob_implicit_flush(false);
        if (!file_exists('public/footer.php')) {
            return '';
        }
        require 'public/footer.php';
        $footer = ob_get_clean();

        return $footer;
    }

    protected function build(): void
    {
        foreach ($this->getAttr() as $k => $v) {
            $$k = $v;
        }

        $header = $this->renderHeader();
        $footer = $this->renderFooter();

        ob_start();
        extract($this->getAttr(), EXTR_OVERWRITE);
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

    public function getAttr(): array
    {
        return $this->attr;
    }
}
