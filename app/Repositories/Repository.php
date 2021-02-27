<?php


namespace App\Repositories;


interface Repository
{

    public function all();

    public function create(array $data);

    public function show($id);

    public function update($id, array $data);

    public function delete($id);
}
