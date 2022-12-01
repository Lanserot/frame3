<?php

namespace Migrations;

use Migrations\migrate\MigrateMethod;

class migrate_301122171232_create_table extends MigrateMethod
{
    public function up(): void
    {
        $this->createTable('Users');
    }

    public function down(): void
    {
        $this->deleteTable('Users');
    }
}
