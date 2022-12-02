<?php

namespace Migrations\migrate\console;

use Migrations\migrate\core\MigrationInterface;
use Migrations\migrate\core\traits\DbConnectTrait;
use PDOException;

class MigrationConsole
{
    use DbConnectTrait;

    protected array $list = [];

    protected bool $isUp = false;

    public function setIsUp(bool $isUp = false): void
    {
        $this->isUp = $isUp;
    }

    protected function parseMigrateFiles(): void
    {
        $this->list = array_values(array_filter(scandir('migrations'), function ($file) {
            return preg_match('/\.(.*)$/U', $file) && $file != '.' && $file != '..';
        }));
    }

    public function checkMigrateVersion()
    {
        $this->connect();
        $result = $this->db->query('SHOW TABLES FROM `' . $this->dbName . '` LIKE \'migrate_versions\';')->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($result)) {
            $this->db->query(
                'CREATE TABLE `migrate_versions` (
                `id` INT NOT NULL AUTO_INCREMENT, 
                `version` INT NOT NULL,
                `migration` VARCHAR(100) NOT NULL, 
                PRIMARY KEY (`id`)) ENGINE = InnoDB;'
            );
        }
    }

    public function saveMigrationVersion(int $version, string $migrateName): void
    {
        $this->db->query('INSERT INTO `migrate_versions` (`version`, `migration`) VALUES (\'' . $version . '\', \'' . $migrateName . '\')');
    }

    public function getMigrationHistory(): array
    {
        $result = $this->db->query('SELECT * FROM `migrate_versions` ORDER BY version DESC')->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function start(): void
    {
        $this->checkMigrateVersion();

        $this->parseMigrateFiles();

        $migHist = $this->getMigrationHistory();

        if (!empty($migHist)) {
            $version = current($migHist)['version'];
            if ($this->isUp) {
                $version++;
            }
        } else {
            if (!$this->isUp) {
                echo "\033[1;32m all rollback \033[40m" . PHP_EOL;
                return;
            }
            $version = 1;
        }


        $diffMigration = $this->isUp ? $this->migrate($migHist) : $this->rollBack($migHist, $version);

        foreach ($diffMigration as $file) {
            $className = 'Migrations\\' . $file;

            if (!class_exists($className)) {
                exit("\033[0;31m" . 'Не найден класс миграции ' . $className . "\033[40m");
            }

            $class = new $className();

            if (!($class instanceof MigrationInterface)) {
                echo "\033[0;31m $file не экземпляр MigrationInterface \033[40m";
                continue;
            }

            try {
                if ($this->isUp) {
                    $class->up();
                    $this->saveMigrationVersion($version, $file);
                    echo "\033[1;32m" . $file . " up \033[40m" . PHP_EOL;
                } else {
                    $class->down();
                    $this->db->query('DELETE FROM `migrate_versions` WHERE `migrate_versions`.`migration` = \'' . $file . '\'');
                    echo "\033[1;32m" . $file . " down \033[40m" . PHP_EOL;
                }
            } catch (PDOException $e) {
                echo "\033[0;31m" . $e->getMessage() . "\033[40m";
                return;
            }
        }
    }

    protected function migrate($migHist): array
    {
        $files = [];
        foreach ($migHist as $obj) {
            $files[] = $obj['migration'];
        }
        $this->list = array_map(function ($obj) {
            return str_replace('.php', '', $obj);
        }, $this->list);

        return array_diff($this->list, $files);
    }

    protected function rollBack($migHist, $version): array
    {
        $roll = array_filter($migHist, function ($obj) use ($version) {
            return $obj['version'] == $version;
        });
        $files = [];
        foreach ($roll as $obj) {
            $files[] = $obj['migration'];
        }
        return array_reverse($files);
    }
}
