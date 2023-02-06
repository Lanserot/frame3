<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_230206234825_insert_collumn_groups extends MigrateMethod
{
    public function up(): void
    {
        $this->setTable('groups')->setCollumn('title')->setType('VARCHAR')->setLong(100)->addCollumn();
        $this->setTable('groups')->setCollumn('description')->setType('TEXT')->setLong(3000)->addCollumn();
        $this->setTable('groups')->setCollumn('user_id')->setType('INT')->setLong(10)->addCollumn();
    }

    public function down(): void
    {
        $this->setTable('groups')->setCollumn('title')->dropCollumn();
        $this->setTable('groups')->setCollumn('description')->dropCollumn();
        $this->setTable('groups')->setCollumn('user_id')->dropCollumn();
    }
}
