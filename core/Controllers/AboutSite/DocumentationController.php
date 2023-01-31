<?php

namespace Core\Controllers\AboutSite;

use VVF\Controllers\Controller;

class DocumentationController extends Controller
{
    public function index(): void
    {
        $this->render('AboutSite.documentation');
    }
}
