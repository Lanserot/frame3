<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_230206234823_create_table_groups extends MigrateMethod
{
    public function up(): void
    {
        $this->createTable('groups');
    }

    public function down(): void
    {
        $this->deleteTable('groups');
    }
}
