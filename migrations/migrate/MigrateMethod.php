<?php

namespace Migrations\migrate;

use Migrations\migrate\interfaces\MigrationInterface;
use Migrations\migrate\traits\DbConnectTrait;

class MigrateMethod implements MigrationInterface
{
    protected string $table = '';
    protected string $type = 'VARCHAR';
    protected string $collumn = '';
    protected int $long = 255;
    protected bool $isNull = true;

    use DbConnectTrait;

    public function up(): void{}
    public function down(): void{}

    public function __construct()
    {
        $this->connect();
    }

    public function createTable($table): void
    {
        $this->db->query('CREATE TABLE `' . $table . '` (`id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;');
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

    public function setTable($table): self
    {
        $this->table = $table;

        return $this;
    }

    public function setLong($long): self
    {
        $this->long = $long;

        return $this;
    }

    public function setCollumn($collumn): self
    {
        $this->collumn = $collumn;

        return $this;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setIsNull($isNull): self
    {
        $this->isNull = $isNull;

        return $this;
    }
}
