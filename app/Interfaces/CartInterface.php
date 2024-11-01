<?php

namespace App\Interfaces;

interface CartInterface
{
    public function get(): mixed;

    public function getTotal(): int;

    public function clear(): void;

    public function add(Device $device): void;
}
