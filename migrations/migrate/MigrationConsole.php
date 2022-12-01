<?php

namespace Migrations\migrate;

use Exception;
use PDOException;

class MigrationConsole
{
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

    public function start(): void
    {
        $this->parseMigrateFiles();

        if(!$this->isUp){
            $this->list = array_reverse($this->list);
        }

        foreach ($this->list as $file) {
            $name = str_replace('.php', '', 'Migrations\\' . $file);

            if (!class_exists($name)) {
                exit('Не найден класс миграции ' . $name);
            }

            $class = new $name();
            try {
                if ($this->isUp) {
                    $class->up();
                    echo "\033[1;32m" . $name . " up \033[40m" . PHP_EOL;
                } else {
                    $class->down();
                    echo "\033[1;32m" . $name . " down \033[40m" . PHP_EOL;
                }
            } catch (PDOException $e) {
                echo "\033[0;31m" . $e->getMessage() . "\033[40m";
                return;
            }
        }
    }
}
