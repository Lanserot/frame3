<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_221130171232_create_table extends MigrateMethod
{
    public function up(): void
    {
        $this->createTable('appTop');
    }

    public function down(): void
    {
        $this->deleteTable('appTop');
    }
}
