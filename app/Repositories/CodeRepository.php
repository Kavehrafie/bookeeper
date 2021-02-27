<?php


namespace App\Repositories;


use App\Models\Code;
use App\Models\Notes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class CodeRepository implements Repository
{

    protected $model;

    public function __construct(Code $model)
    {
        $this->model = $model;
    }

    public function getById($id, $with = [])
    {
        return $this->model->with($with)->findOrFail($id);
    }

    public function notesSync($id, $fields)
    {
        foreach ($fields as $field){
            $field['code_id'] = $id;
            if ($field['id']) {
                $note = Notes::find($field['id'])->update(['order' => $field['order']]);
            } else {
                $note = Notes::firstOrCreate($field);
            }
        }

    }

    public function getNotes($id)
    {
        return Notes::where('code_id', $id)->get()->sortBy('order')->toArray();
    }

    public function deleteNote($id)
    {
        Notes::find($id)->delete();
    }

    public function all()
    {
//        if ($pagination) {
//            return $this->model->paginate($pagination);
//        }
        $pagination = 40;
        // TODO: Refactor.
        return $this->model->orderBy('created_at', 'desc')
            ->ownedByCurrentUser()
            ->filter(Request::only('tags', 'references', 'search'))
            ->withCount('notes')
            ->with('tags')->paginate($pagination);
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
//        dd($data);
        // TODO: Implement update() method.
        $model = $this->getById($id);

        $model->update(Arr::except($data, ['tags']));

        $model->syncTags($data['tags']);

        return $model;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->model->destroy($id);
    }
}
