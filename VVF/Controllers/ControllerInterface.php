<?php

namespace VVF\Controllers;

interface ControllerInterface
{
    public function render(string $page): void;
    public function setRequest(array $request): void;
}
