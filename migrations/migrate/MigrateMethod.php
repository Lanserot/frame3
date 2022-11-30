<?php

namespace Migrations\migrate;

use Migrations\migrate\traits\DbConnectTrait;

class MigrateMethod
{
    use DbConnectTrait;

    public function __construct()
    {
        $this->connect();
    }

    public function createTable($table)
    {   
        $this->db->query('CREATE TABLE `' . $table . '` (`id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;');
    }

    public function deleteTable($table)
    {
        $this->db->query('DROP TABLE ' . $table);
    }
}
