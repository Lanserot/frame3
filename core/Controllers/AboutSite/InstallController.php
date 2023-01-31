<?php

namespace Core\Controllers\AboutSite;

use VVF\Controllers\Controller;

class InstallController extends Controller
{
    public function index(): void
    {
        $this->render('AboutSite.install');
    }
}
