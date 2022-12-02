<?php

namespace Migrations\migrate\core;


interface MigrationInterface {
    public function up():void;
    public function down():void;
}