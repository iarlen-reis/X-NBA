<?php

namespace App\Repositories\Contracts;

interface TeamRepositoryInterface
{
    public function index(string $league);

    public function show(string $id);
}
