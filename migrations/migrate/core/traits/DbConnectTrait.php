<?php

namespace Migrations\migrate\core\traits;

use Exception;
use PDO;
use VVF\ErrorHandler\ErrorHandler;

trait DbConnectTrait
{
    public PDO $db;
    public string $dbName = 'test';

    public function connect()
    {
        $conf = require 'conf.php';
        $this->dbName = $conf['db']['dbName'];

        try {
            $dsn = 'mysql:dbname=' . $this->dbName . ';host=' . $conf['db']['host'];
            $db = new PDO($dsn, $conf['db']['userName'], $conf['db']['pass']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $db->query("SET NAMES 'utf8'");
        } catch (Exception $e) {
            throw new ErrorHandler(date('Y-m-d H:i:s - ') . '[ERROR] DB connection error! ' . json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE));
            exit;
        }
        $this->db = $db;
    }
}
