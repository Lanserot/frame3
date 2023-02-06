<?php

namespace VVF\Models;

use Migrations\migrate\core\traits\DbConnectTrait;
use PDO;
use VVF\ErrorHandler\ErrorHandler;

class Model
{
    use DbConnectTrait;

    protected string $table = '';
    private array $where = [];

    public function __construct()
    {
        $this->connect();
    }

    public function belongsTo(string $table): bool|array
    {
        if (empty($this->id)) {
            return false;
        }

        $column = preg_replace('/s$/', '', $this->getTable());
        $sql = 'SELECT * FROM `' . $table . '` WHERE `' . $column . '_id` = ' . $this->id;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): bool|Model
    {
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $model = $this;
        $model->table($this->getTable());
        foreach (get_object_vars($result) as $v => $k) {
            $model->$v = $k;
        }
        return $model;
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }
    public function getTable(): string
    {
        return $this->table;
    }
    public function where(string $column, string $operator, string|int|bool $value): self
    {
        if (!in_array($operator, ['=', '<', '>', '<=', '>=', '<>'])) {
            throw new ErrorHandler('Invalid operator');
        }

        $name = $column . '_' . count($this->where);

        $this->where[] = [
            'query' => "$column $operator :$name",
            'prep' => ["$name" => $value]
        ];

        return $this;
    }

    public function get(): array
    {
        $wherePrepare = $this->getWhere();
        $sql = 'SELECT * FROM ' . $this->getTable() . ' ' . $wherePrepare['sql'];
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
            } else {
                $wherePrepare['sql'] .= ' WHERE ';
            }

            $wherePrepare['sql'] .= $where['query'];
            $wherePrepare['prepare'] = array_merge($wherePrepare['prepare'], $where['prep']);
        }
        return $wherePrepare;
    }

    public function getLimit(int $limit = 10, string $order = 'DESC'): bool|array
    {
        if (!in_array($order, ['DESC', 'ASC'])) {
            $order = 'DESC';
        }
        if ($limit < 1 || $limit < 0) {
            $limit = 10;
        }
        $sql = "SELECT * FROM " . $this->getTable() . " ORDER BY id $order limit $limit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}