<?php

namespace Core\Controllers\AboutSite;

use Core\Controllers\Default\Controller;

class DocumentationController extends Controller
{
    public function index(): void
    {
        $this->render('AboutSite.documentation');
    }
}
