<?php

namespace Core\Controllers\AboutSite;

use Core\Controllers\Default\Controller;

class InstallController extends Controller
{
    public function index(): void
    {
        $this->render('AboutSite.install');
    }
}
