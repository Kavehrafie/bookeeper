<?php


namespace App\Repositories;


use App\Models\Author;

class AuthorRepository implements Repository
{
    protected $model;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->all();
    }

    public function asTags()
    {
        // TODO: Implement all() method.
        return $this->model->get()->pluck('tag');
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
