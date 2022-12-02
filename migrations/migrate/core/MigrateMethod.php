<?php

namespace Migrations\migrate\core;

use Core\Tools\StrClass;
use Migrations\migrate\core\MigrationInterface;
use Migrations\migrate\core\traits\DbConnectTrait;
use Migrations\migrate\core\traits\MigrateContainerTrait;

class MigrateMethod implements MigrationInterface
{
    use DbConnectTrait;
    use MigrateContainerTrait;

    public function up(): void
    {
    }
    public function down(): void
    {
    }

    public function __construct()
    {
        $this->connect();
    }

    public function createTable($table): void
    {
        $this->makeSqlRequest('CREATE TABLE `' . $table . '` (`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)) ENGINE = InnoDB;');
    }

    public function deleteTable($table): void
    {
        $this->makeSqlRequest('DROP TABLE ' . $table);
    }

    public function addCollumn(): void
    {
        $null = $this->isNull ? 'NULL' : 'NOT NULL';
        $sql = 'ALTER TABLE `' . $this->table . '` ADD `' . $this->collumn . '` ' . $this->type . '(' . $this->long . ') ' . $null . ';';
        $this->makeSqlRequest($sql);
    }

    public function dropCollumn(): void
    {
        $sql = 'ALTER TABLE `' . $this->table . '` DROP `' . $this->collumn . '`;';
        $this->makeSqlRequest($sql);
    }

    public function generate(array $params): void
    {
        for ($i = 0; $i < $this->countGenerate; $i++) {

            $collumn = array_map(function ($k) {
                return "`" . $k . "`";
            }, array_keys($params));

            $data = array_map(function ($v) {
                return "'" . $v . "'";
            }, array_values($params));

            $data = StrClass::handleRandomStringInArray($data);
            $sql = 'INSERT INTO `' . $this->table . '` (' . implode(',', $collumn) . ') VALUES (' . implode(',', $data) . ');';
            $this->makeSqlRequest($sql);
        }
    }

    protected function makeSqlRequest(string $sql)
    {
        $this->db->query($sql);
    }
}
