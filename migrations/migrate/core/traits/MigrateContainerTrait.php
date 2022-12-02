<?php
namespace Migrations\migrate\core\traits;


trait MigrateContainerTrait
{
    protected string $table = '';
    protected string $type = 'VARCHAR';
    protected string $collumn = '';
    protected int $long = 255;
    protected bool $isNull = true;

    public function setTable($table): self
    {
        $this->table = $table;

        return $this;
    }

    public function setLong($long): self
    {
        $this->long = $long;

        return $this;
    }

    public function setCollumn($collumn): self
    {
        $this->collumn = $collumn;

        return $this;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setIsNull($isNull): self
    {
        $this->isNull = $isNull;

        return $this;
    }
}
