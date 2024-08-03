<?php

namespace App\Repositories\Contracts;

interface PlayerRepositoryInterface
{
    public function index();

    public function show($id);

    public function store(array $data);

    public function update(array $data, $id);

    public function destroy($id);
}
