<?php

namespace Migrations\migrate\interfaces;


interface MigrationInterface {
    public function up(): void;
    public function down(): void;
}