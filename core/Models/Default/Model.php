<?php

namespace Core\Models\Default;

use Migrations\migrate\core\traits\DbConnectTrait;
use PDO;
use stdClass;

class Model
{
    use DbConnectTrait;

    public function __construct()
    {
        $this->connect();
    }

    public function find(int $id): bool|stdClass
    {
        return $this->db->query('SELECT * FROM `Users` WHERE `id` = ' . $id)->fetch(PDO::FETCH_OBJ);
    }
}
