<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

class ProjectController extends Controller
{
    /**
     * Show the form modal for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        Inertia::modal("Project/Create");

        return $this->index();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render("Project/Index", [
            "projects" => Project::orderBy("created_at", "desc")->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Redirect
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "title" => ["max:255", "required"],
            "description" => ["nullable"],
        ]);

        Project::firstOrCreate($validated);

        return Redirect::route("projects.index")
            ->with('flash', [
                'banner' => 'A new project has successfully created.'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return Response
     */
    public function edit(Project $project)
    {
        Inertia::modal("Project/Edit");
        Inertia::share("project", $project);

        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            "title" => ["required", "max:255"],
            "description" => ["nullable"],
        ]);

        $project->update($validated);

        return redirect()->route("projects.index")
            ->with('flash', [
                'banner' => 'The project is successfully created.'
            ]);
    }

    public function showAddToCollection(Request $request, Project $project)
    {
        Inertia::modal("Project/AddToCollection");

        return $this->editCollection($request, $project);
    }

    public function editCollection(Request $request, Project $project)
    {
        return Inertia::render("Project/EditCollection", [
            "project" => $project->append("codes"),
            "codes" => Code::whereDoesntHave("projects", function (
                Builder $query
            ) use ($project) {
                $query->where("id", $project->id);
            })
                ->orderBy("created_at", "desc")
                ->ownedByCurrentUser()
                ->filter($request->only("tags", "references", "search"))
                ->with("tags")
                ->cursorPaginate(5),
        ]);
    }

    public function storeAddToCollection(Request $request, Project $project)
    {
        $field = $request->only(["id"]);
        $project->codes()->attach(Code::findOrFail($field["id"]));
        $project->save();

        return back();
    }

    public function generateWordFile(PhpWord $phpWord, Project $project)
    {
        $section = $phpWord->addSection();
        foreach ($project->codes as $key => $group) {
            $section->addTitle($key, 2);
            foreach ($group as $code) {
                $section->addText(strip_tags($code->body));
                $section->addText($code->referenceTitle, [
                    "name" => "Tahoma",
                    "size" => 8,
                ]);
            }
        }
        $objWriter = IOFactory::createWriter($phpWord, "Word2007");

        try {
            // To escape html
            Settings::setOutputEscapingEnabled(true);

            $objWriter->save(storage_path("app/public/example.docx"));
        } catch (Exception $e) {
        }

        \inertia()->share("download", [
            "title" => "Download the Word File",
            "link" => Storage::disk("public")->url("example.docx"),
        ]);
        \inertia()->modal("Project/Download");

        return $this->editCollection(request(), $project);
    }

    public function updateCollection(
        Request $request,
        Project $project,
        Code    $code
    )
    {
        $fields = $request->only([
            "newGroup",
            "oldGroup",
            "oldIndex",
            "newIndex",
        ]);

        if ($fields["newGroup"] == $fields["oldGroup"]) {
            DB::table("code_project")
                ->where([
                    ["position", $request->input("newIndex")],
                    ["project_id", $project->id],
                ])
                ->update([
                    "position" => $request->input("oldIndex"),
                ]);
        } else {
        }
        DB::table("code_project")
            ->where([["code_id", $code->id], ["project_id", $project->id]])
            ->update([
                "group" => $request->input("newGroup"),
                "position" => $request->input("newIndex"),
            ]);

        return back();
    }

    public function deleteCollection(Project $project, Code $code)
    {
        DB::table("code_project")
            ->where([["code_id", $code->id], ["project_id", $project->id]])
            ->delete();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route("projects.index")
            ->with('flash', [
                'banner' => 'The project is successfully deleted.'
            ]);
    }
}
