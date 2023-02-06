<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_230206234828_insert_generate_groups extends MigrateMethod
{
    public function up(): void
    {
        $this->setTable('groups')->setCountGenerate(50)->generate(
            [
                'title' => '|randString|',
                'description' => '|randString|@mail.ru',
                'user_id' => '|randInt|'
            ]
        );
    }

    public function down(): void
    {
    }
}
