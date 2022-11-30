<?php

namespace Core\Controllers\Default;

interface ControllerInterface
{
    public function show(string $page): void;
}
