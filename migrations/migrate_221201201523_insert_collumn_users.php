<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_221201201523_insert_collumn_users extends MigrateMethod
{
    public function up(): void
    {
        $this->setTable('users')->setCollumn('login')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('users')->setCollumn('password')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('users')->setCollumn('mail')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('users')->setCollumn('role')->setType('INT')->setLong(10)->addCollumn();
    }

    public function down(): void
    {
        $this->setTable('users')->setCollumn('login')->dropCollumn();
        $this->setTable('users')->setCollumn('password')->dropCollumn();
        $this->setTable('users')->setCollumn('mail')->dropCollumn();
        $this->setTable('users')->setCollumn('role')->dropCollumn();
    }
}
