<?php


namespace App\Repositories;


use App\Models\Author;
use App\Models\Publisher;
use App\Models\Reference;
use Illuminate\Support\Arr;

class ReferenceRepository implements Repository
{

    protected $model;
    protected $authorModel;

    public function __construct(Reference $model, Author $authorModel)
    {
        $this->model = $model;
        $this->authorModel = $authorModel;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->orderBy('created_at', 'desc')->whereHas('userables', function ($query) {
            $query->where('id', auth()->id());
        })->with('publisher')->get();
    }

    public function create(array $data)
    {
        // Create or find the first publisher and insert into the data
        if (array_key_exists('publisher', $data)) {
            $data['publisher_id'] = Publisher::firstOrCreate([
                'title' => $data['publisher']
            ])->id;
        }

        // Make sure that these fields are not included for the bulk creation
        $reference = $this->model->firstOrCreate(Arr::except($data, [
            'authors',
            'tags',
            'editors',
            'publisher'
        ]));

        if (array_key_exists ('authors', $data)) {
            $authors = [];
            foreach ($data['authors'] as $authorStr) {
                $name = explode(', ', $authorStr);

                $author = $this->authorModel->firstOrCreate([
                    'first_name' => $name[1],
                    'last_name' => $name[0]
                ]);

                $authors[$author->id] = ['role' => 'author'];
            }

            $reference->people()->attach($authors);
        }

        if (array_key_exists('editors', $data)) {
            $editors = [];
            foreach ($data['editors'] as $editorStr) {
                $name = explode(', ', $editorStr);

                $editor = $this->authorModel->firstOrCreate([
                    'first_name' => $name[1],
                    'last_name' => $name[0]
                ]);

                $editors[$editor->id] = ['role' => 'editor'];
            }

            $reference->people()->attach($editors);
        }



        if (array_key_exists('tags', $data)) {
            $reference->attachTags($data['tags']);
        }

        $reference->userables()->attach(auth()->id());


        return $reference;
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
