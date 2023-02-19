<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_221201201523_insert_collumn_users extends MigrateMethod
{
    public function up(): void
    {
        $this->setTable('appTop')->setCollumn('date')->setType('VARCHAR')->setLong(10)->addCollumn();
        $this->setTable('appTop')->setCollumn('category')->setType('INT')->setLong(10)->addCollumn();
        $this->setTable('appTop')->setCollumn('position')->setType('INT')->setLong(10)->addCollumn();
    }

    public function down(): void
    {
        $this->setTable('appTop')->setCollumn('date')->dropCollumn();
        $this->setTable('appTop')->setCollumn('category')->dropCollumn();
        $this->setTable('appTop')->setCollumn('position')->dropCollumn();
    }
}
