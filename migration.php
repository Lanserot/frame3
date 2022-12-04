<?php

use Migrations\migrate\console\MigrationConsole;


$opt = getopt("r:");
$migrationClass = new MigrationConsole();
$migrationClass->setIsUp($opt['r'] == ':Migrate');
$migrationClass->start();



