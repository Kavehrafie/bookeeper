<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Reference;
use App\Repositories\CodeRepository;
use App\Repositories\ReferenceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Tags\Tag;

class CodeController extends Controller
{
    /**
     * @var CodeRepository
     */
    protected $codeRepository;

    public function __construct(CodeRepository $codeRepository, ReferenceRepository $referenceRepository)
    {
        $this->codeRepository = $codeRepository;
        $this->referenceRepository = $referenceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Code/Index', [
            'codes' => $this->codeRepository->all(20),
            'references' => Reference::all(),
        ]);
    }

    public function createModal()
    {
//        inertia()->modal();
//        Inertia::modal('??');
        inertia()->modal('Code/CreateModal');

        return $this->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($oldForm = null)
    {
        return Inertia::render('Code/Create', [
            'references' => $this->referenceRepository->all(),
            'tags' => Tag::all()->pluck('name'),
            'oldForm' => $oldForm
        ]);
    }

    public function createReferenceModal(Request $request)
    {
        inertia()->modal('Reference/CreateModal');

        return $this->create($request->all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'body' => 'required',
            'reference_id' => 'required',
            'pages' => 'nullable',
            'tags' => 'nullable'
        ]);

        $this->codeRepository->create($validated);

        return redirect()->route('codes.index')->withFlash(['banner' => 'The code is saved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
