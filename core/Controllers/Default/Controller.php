<?php

namespace Core\Controllers\Default;

use Core\Controllers\Default\Page\PageFactory;

class Controller implements ControllerInterface
{
    private PageFactory $pageFactory;
    public array $request = [];

    public function __construct()
    {
        $this->initPageFactory();
    }

    public function render(string $page, array $attr = []): void
    {
        $filePath = 'public/' . str_replace('.', '/', $page) . '.php';
        if (!file_exists($filePath)) {
            echo $page . ' not found page';
            return;
        }
        $this->pageFactory->renderPage($filePath, $attr);
    }

    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    public function __call(string $method, array $arguments): void
    {
        echo $method . ' Controller not found';
    }

    public function initPageFactory()
    {
        $this->pageFactory = new PageFactory();
    }

    public function redirect(string $url = '/'){
        header("Location: " . $url);
    }
}
