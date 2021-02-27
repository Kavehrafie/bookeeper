<?php


namespace App\Repositories;


use App\Models\Author;
use App\Models\Publisher;
use App\Models\Reference;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        return $this->model->orderBy('created_at', 'desc')
            ->ownedByCurrentUser()
            ->with('publisher')
            ->get();
    }

    public function list()
    {
        return $this->model->orderBy('title', 'desc')
            ->ownedByCurrentUser()
            ->get(['id', 'title', 'year']);
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

        $people = [];
        if (array_key_exists ('authors', $data)) {
            $people = ($this->associatePeople($data, 'authors'));
        }

        if (array_key_exists('editors', $data)) {
            $people += ($this->associatePeople($data, 'editors')) ;
        }

        if (array_key_exists('translators', $data)) {
            $people += ($this->associatePeople($data, 'translators')) ;
        }

        if (!empty($people)) {
            $reference->people()->attach($people);
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
        //
        if (array_key_exists('publisher', $data)) {
            $data['publisher_id'] = Publisher::firstOrCreate([
                'title' => $data['publisher']
            ])->id;
        }

        // Make sure that these fields are not included for the bulk creation
        $reference = $this->getById($id);


        if (!$reference->update(Arr::except($data, [
            'authors',
            'translators',
            'tags',
            'editors',
            'publisher'
        ]))) {
            dd('something went wrong!');
        };

        $people = [];
        if (array_key_exists ('authors', $data)) {
             $people = ($this->associatePeople($data, 'authors'));
        }

        if (array_key_exists('editors', $data)) {
             $people += ($this->associatePeople($data, 'editors')) ;
        }

        if (array_key_exists('translators', $data)) {
             $people += ($this->associatePeople($data, 'translators')) ;
        }

        if (!empty($people)) {
            $reference->people()->sync($people);
        }

        if (array_key_exists('tags', $data)) {
            $reference->attachTags($data['tags']);
        }


        return $reference;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->model->find($id)->delete();
    }

    public function getById($id, $with = [])
    {
        return $this->model->with($with)->where('id', $id)->firstOrFail();
    }

    /**
     * @param $authors
     * @param array $people
     * @return array
     */
    private function associatePeople($authors, $assoc): array
    {
        $people = [];
        foreach ($authors[$assoc] as $authorStr) {
            $name = explode(', ', $authorStr);

            $author = $this->authorModel->firstOrCreate([
                'first_name' => $name[1],
                'last_name' => $name[0]
            ]);

            $people[$author->id] = ['role' => Str::singular($assoc)];
        }
        return $people;
    }
}
