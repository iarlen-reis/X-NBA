<?php

namespace App\Repositories\Contracts;

interface TeamRepositoryInterface
{
    public function index();

    public function show(string $id);
}
