<?php

namespace VVF\Models;

use Migrations\migrate\core\traits\DbConnectTrait;
use PDO;
use stdClass;
use VVF\ErrorHandler\ErrorHandler;

class Model
{
    use DbConnectTrait;

    public string $table = '';
    private array $where = [];

    public function __construct()
    {
        $this->connect();
    }

    public function find(int $id): bool|stdClass
    {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `id` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $column, string $operator, string|int|bool $value): self
    {
        if (!in_array($operator, ['=', '<', '>', '<=', '>=', '<>'])) {
            throw new ErrorHandler('Invalid operator');
        }

        $name = $column . '_' . count($this->where);

        $this->where[] = [
            'query' => "`$column` $operator :$name",
            'prep' => ["$name" => $value]
        ];

        return $this;
    }

    public function get(): array
    {
        $wherePrepare = $this->getWhere();
        $sql = 'SELECT * FROM `' . $this->table . '` ' . $wherePrepare['sql'];
        $stmt = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($wherePrepare['prepare']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getWhere(): array
    {
        $wherePrepare['sql'] = '';
        $wherePrepare['prepare'] = [];
        foreach ($this->where as $num => $where) {
            if ($num) {
                $wherePrepare['sql'] .= ' AND ';
            }else{
                $wherePrepare['sql'] .= ' WHERE ';
            }

            $wherePrepare['sql'] .= $where['query'];
            array_push($wherePrepare['prepare'], $where['prep']);
        }
        $wherePrepare['prepare'] = array_merge(...$wherePrepare['prepare']);
        return $wherePrepare;
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
