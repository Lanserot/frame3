<?php

use Migrations\migrate\MigrationConsole;

require_once __DIR__ . '/vendor/autoload.php';

$opt = getopt("r:");
$migrationClass = new MigrationConsole();
$migrationClass->setIsUp($opt['r'] == ':Migrate');
$migrationClass->start();



