<?php
require_once __DIR__ . '/vendor/autoload.php';

use Core\Route\Route;
use Core\PageFactory;
use Core\Tools\DebugTool;

$PageFactory = new PageFactory(new Route());

