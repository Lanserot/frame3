<?php

namespace Core\Controllers;

use Core\Controllers\Default\Controller;

class TestController extends Controller
{
    public function index(): void
    {
        echo 'Test Page';
    }

    public function testMethod(): void
    {
        echo 'is it Test method Page';
    }
}
