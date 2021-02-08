<?php


namespace App\Repositories;


use App\Models\Code;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class CodeRepository implements Repository
{

    protected $model;

    public function __construct(Code $model)
    {
        $this->model = $model;
    }

    public function all($pagination = 0)
    {
//        if ($pagination) {
//            return $this->model->paginate($pagination);
//        }

        // TODO: Refactor.
        return $this->model->orderBy('created_at', 'desc')
            ->ownedByCurrentUser()
            ->filter(Request::only('tag'))
            ->with('tags')->get();
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
        $model = $this->model->firstOrCreate(Arr::except($data, ['tags']));

        $model->attachTags($data['tags']);

        $model->userables()->attach(auth()->id());
    }

    public function show($id)
    {
        // TODO: Implement show() method.
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
        $model = $this->model->find($id);
        return $model->updata($data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->model->destroy($id);
    }
}
