<?php

namespace Migrations;

use Migrations\migrate\MigrateMethod;

class migrate_221201201523_insert_collumn_users extends MigrateMethod
{
    public function up(): void
    {
        $this->setTable('Users')->setCollumn('login')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('Users')->setCollumn('password')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('Users')->setCollumn('mail')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('Users')->setCollumn('role')->setType('INT')->setLong(10)->addCollumn();
    }

    public function down(): void
    {
        $this->setTable('Users')->setCollumn('login')->dropCollumn();
        $this->setTable('Users')->setCollumn('password')->dropCollumn();
        $this->setTable('Users')->setCollumn('mail')->dropCollumn();
        $this->setTable('Users')->setCollumn('role')->dropCollumn();
    }
}
