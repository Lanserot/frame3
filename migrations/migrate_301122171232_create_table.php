<?php

namespace Migrations;

use Migrations\migrate\MigrateMethod;

class migrate_301122171232_create_table extends MigrateMethod
{
    public function up()
    {
        $this->createTable('Users');
    }

    public function down()
    {
        $this->deleteTable('Users');
    }
}
