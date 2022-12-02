<?php

namespace Migrations\migrate\core;

use Migrations\migrate\core\MigrationInterface;
use Migrations\migrate\core\traits\DbConnectTrait;
use Migrations\migrate\core\traits\MigrateContainerTrait;

class MigrateMethod implements MigrationInterface
{
    protected string $table = '';
    protected string $type = 'VARCHAR';
    protected string $collumn = '';
    protected int $long = 255;
    protected bool $isNull = true;

    use DbConnectTrait;
    use MigrateContainerTrait;

    public function up():void {}
    public function down():void {}

    public function __construct()
    {
        $this->connect();
    }

    public function createTable($table): void
    {
        $this->db->query('CREATE TABLE `' . $table . '` (`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)) ENGINE = InnoDB;');
    }

    public function deleteTable($table): void
    {
        $this->db->query('DROP TABLE ' . $table);
    }

    public function addCollumn()
    {
        $null = $this->isNull ? 'NULL' : 'NOT NULL';
        $sql = 'ALTER TABLE `' . $this->table . '` ADD `' . $this->collumn . '` ' . $this->type . '(' . $this->long . ') ' . $null . ';';
        $this->db->query($sql);
    }

    public function dropCollumn()
    {
        $sql = 'ALTER TABLE `' . $this->table . '` DROP `' . $this->collumn . '`;';
        $this->db->query($sql);
    }
}
