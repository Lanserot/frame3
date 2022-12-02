<?php

namespace Migrations;

use Migrations\migrate\core\MigrateMethod;

class migrate_221202232123_insert_generate_users extends MigrateMethod
{
    public function up(): void
    {
        $this->setTable('users')->setCountGenerate(15)->generate(
            [
                'password' => md5('pass'),
                'login' => '|randString|',
                'mail' => '|randString|@mail.ru',
                'role' => rand(0, 3)
            ]
        );
    }

    public function down(): void
    {
    }
}
