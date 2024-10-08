<?php

namespace App\Repositories\Contracts;

interface TeamRepositoryInterface
{
    public function index(string $league);

    public function show(string $id);

    public function store(array $data);

    public function update(string $id, array $data);

    public function destroy(string $id);
}
