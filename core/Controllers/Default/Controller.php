<?php

namespace Core\Controllers\Default;

use Core\Controllers\Default\Page\PageFactory;
use Core\ErrorHandler\ErrorHandler;

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
            throw new ErrorHandler($page . ' not found page');
        }
        $this->pageFactory->renderPage($filePath, $attr);
    }

    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    public function initPageFactory()
    {
        $this->pageFactory = new PageFactory();
    }

    public function redirect(string $url = '/'){
        header("Location: " . $url);
    }
}
