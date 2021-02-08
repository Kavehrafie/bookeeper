<?php

namespace App\Http\Controllers;


use App\Models\Publisher;
use App\Repositories\AuthorRepository;
use App\Repositories\ReferenceRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Tags\Tag;

class ReferenceController extends Controller
{
    protected $refRepository;

    public function __construct(ReferenceRepository $refRepository, AuthorRepository $authorRepository)
    {
        $this->refRepository = $refRepository;
        $this->authorRepository = $authorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Reference/Index', [
            'references' => $this->refRepository->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return Inertia::render('Reference/Create', [
            'authors' => $this->authorRepository->asTags(),
            'publishers' => Publisher::all()->only('title'),
            'types' => config('settings.types'),
            'tags' => Tag::all()->pluck('name')
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createModal()
    {

        Inertia::modal('Reference/CreateModal');

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:250',
            'sub_title' => 'nullable|max:250',
            'pages' => 'nullable|max:250',
            'year' => 'required|integer',
            'type' => 'required',
            'city' => 'max:250',
            'volume' => 'nullable',
            'issue' => 'nullable',
            'publisher' => 'nullable|max:250',
            'authors.*' => 'string|regex:/([^,]+)/',
            'editors.*' => 'string|regex:/([^,]+)/',
            'tags' => 'nullable'
        ]);

        $reference = $this->refRepository->create($validated);

        return Redirect::route('references.index')->with('banner', 'The reference is successfully created.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
