<?php
namespace App\Repositories\Interfaces;

Interface TodoRepositoryInterface
{
    public function all();

    public function store(array $data);

    public function find($id);

    public function update(array $data);

    public function delete($id);
}