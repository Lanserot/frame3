<?php

namespace Core\Controllers\AboutSite;

use VVF\Controllers\Controller;

class TechnologiesController extends Controller
{
    public function index(): void
    {
        $this->render('AboutSite.technologies');
    }
}
