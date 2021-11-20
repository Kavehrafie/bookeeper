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

    public function __construct(
        ReferenceRepository $refRepository,
        AuthorRepository $authorRepository
    ) {
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
        return Inertia::render("Reference/Index", [
            "references" => $this->refRepository->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render("Reference/Create", [
            "authors" => $this->authorRepository->asTags(),
            "publishers" => Publisher::all()->pluck("title"),
            "types" => config("settings.types"),
            "tags" => Tag::all()->pluck("name"),
        ]);
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
            "title" => "required|max:250",
            "sub_title" => "nullable|max:250",
            "pages" => "nullable|max:250",
            "year" => "required|integer",
            "type" => "required",
            "city" => "max:250",
            "volume" => "nullable",
            "issue" => "nullable",
            "publisher" => "required|max:250",
            "authors.*" => "required|string|regex:/([^,]+)/",
            "editors.*" => "string|regex:/([^,]+)/",
            "tags" => "nullable",
        ]);

        $reference = $this->refRepository->create($validated);

        return Redirect::route("references.index")->withFlash([
            "banner" => "The reference is successfully created.",
        ]);
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
        return Inertia::render("Reference/Edit", [
            "reference" => $this->refRepository->getById($id, [
                "publisher",
                "tags",
            ]),
            "authors" => $this->authorRepository->asTags(),
            "publishers" => Publisher::all()->pluck("title"),
            "types" => config("settings.types"),
            "tags" => Tag::all()->pluck("name"),
        ]);
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
        $validated = $request->validate([
            "title" => "required|max:250",
            "book_title" => "nullable|max:250",
            "pages" => "nullable|max:250",
            "year" => "required|integer",
            "type" => "required",
            "city" => "max:250",
            "volume" => "nullable",
            "issue" => "nullable",
            "publisher" => "required|max:250",
            "authors.*" => "string|regex:/([^,]+)/",
            "editors.*" => "string|regex:/([^,]+)/",
            "translators.*" => "string|regex:/([^,]+)/",
            "tags" => "nullable",
        ]);

        $reference = $this->refRepository->update($id, $validated);

        return Redirect::route("references.index")->withFlash([
            "banner" => "The reference is successfully created.",
        ]);
    }

    public function createPublisher()
    {
        //        Inertia::modal('Partial/CreatePublisherModal');
        //
        //
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
        $this->refRepository->delete($id);

        return Redirect::back();
    }
}
