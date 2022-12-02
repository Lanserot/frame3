<?php
namespace Migrations\migrate\core\traits;


trait MigrateContainerTrait
{
    protected string $table = '';
    protected string $type = 'VARCHAR';
    protected string $collumn = '';
    protected int $long = 255;
    protected bool $isNull = true;
    protected int $countGenerate = 1;

    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function setLong(int $long): self
    {
        $this->long = $long;

        return $this;
    }

    public function setCollumn(string $collumn): self
    {
        $this->collumn = $collumn;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setIsNull(bool $isNull): self
    {
        $this->isNull = $isNull;

        return $this;
    }

    public function setCountGenerate(int $countGenerate): self
    {
        $this->countGenerate = $countGenerate;

        return $this;
    }
}
