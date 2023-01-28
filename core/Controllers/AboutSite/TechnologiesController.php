<?php

namespace Core\Controllers\AboutSite;

use Core\Controllers\Default\Controller;

class TechnologiesController extends Controller
{
    public function index(): void
    {
        $this->render('AboutSite.technologies');
    }
}
