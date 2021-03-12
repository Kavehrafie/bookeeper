<?php

namespace App\Http\Controllers;


use App\Models\Notes;
use App\Repositories\CodeRepository;
use App\Repositories\ReferenceRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Tags\Tag;

class CodeController extends Controller
{
    /**
     * @var CodeRepository
     */
    protected $codeRepository;
    /**
     * @var int
     */
    private $modalId;

    public function __construct(CodeRepository $codeRepository, ReferenceRepository $referenceRepository)
    {
        $this->codeRepository = $codeRepository;
        $this->referenceRepository = $referenceRepository;
        $this->modalId = 0;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Code/Index', [
            'codes' => $this->codeRepository->all(),
            'references' => $this->referenceRepository->list(),
            'filters' => $request->all('tags', 'references', 'search'),
            'current_id' => $this->modalId
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

    public function editTagsModal(Request $request, $id)
    {
        inertia()->modal('Reference/TagsEdit');
        $this->modalId = $id;
        return $this->index($request);
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
        return Inertia::render('Code/Edit', [
            'code' => $this->codeRepository->getById($id, ['tags']),
            'references' => $this->referenceRepository->all(),
            'tags' => Tag::all()->pluck('name'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reviewEdit($id)
    {
        return Inertia::render('Code/EditNotes', [
            'code' => $this->codeRepository->getById($id, ['tags']),
            'notes' => $this->codeRepository->getNotes($id),
        ]);

    }

    public function reviewUpdate(Request $request, $id)
    {
        $this->codeRepository->notesSync($id, $request->input('notes'));
        return redirect()->route('codes.index')->withFlash(['banner' => 'The notes are updated!']);
    }

    public function reviewDelete($id)
    {
        $this->codeRepository->deleteNote($id);
        return back();
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
        $validated = $request->validate([
            'body' => 'required',
            'reference_id' => 'required',
            'pages' => 'nullable',
            'tags' => 'nullable'
        ]);

        $this->codeRepository->update($id, $validated);

        return redirect()->route('codes.index')->withFlash(['banner' => 'The code is updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->codeRepository->delete($id);
        return back();
    }
}
