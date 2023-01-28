<?php
require_once __DIR__ . '/vendor/autoload.php';

$opt = getopt("r:");
$migrationClass = new Migrations\migrate\console\MigrationConsole();
$migrationClass->setIsUp($opt['r'] == ':Migrate');
$migrationClass->start();



