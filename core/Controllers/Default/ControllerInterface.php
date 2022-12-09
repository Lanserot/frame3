<?php

namespace Core\Controllers\Default;

interface ControllerInterface
{
    public function render(string $page): void;
    public function setRequest(array $request): void;
}
