<?php

namespace Core\Models\Default;

use Migrations\migrate\core\traits\DbConnectTrait;
use PDO;
use stdClass;

class Model
{
    use DbConnectTrait;

    public string $table = '';

    public function __construct()
    {
        $this->connect();
    }

    public function find(int $id): bool|stdClass
    {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `id` = ' . $id;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getLimit(int $limit = 10, string $order = 'DESC'): bool|array
    {
        if (!in_array($order, ['DESC', 'ASC'])) {
            $order = 'DESC';
        }
        if ($limit < 1) {
            $limit = 10;
        }
        $sql = "SELECT * FROM `" . $this->table . "` ORDER BY id $order limit $limit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
