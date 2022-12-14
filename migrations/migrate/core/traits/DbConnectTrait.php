<?php

namespace Migrations\migrate\core\traits;

use Exception;
use PDO;

trait DbConnectTrait
{
    public PDO $db;
    public string $dbName = 'test';

    public function connect()
    {
        try {
            $dsn = 'mysql:dbname=' . $this->dbName . ';host=localhost';
            $db = new PDO($dsn, 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $db->query("SET NAMES 'utf8'");
        } catch (Exception $e) {
            echo date('Y-m-d H:i:s - ') . '[ERROR] DB connection error! ' . json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE) . "\n";
            exit;
        }
        $this->db = $db;
    }
}
