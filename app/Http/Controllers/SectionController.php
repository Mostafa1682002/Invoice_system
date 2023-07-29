<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::get();
        return view('sections.sections', ['sections' => $sections]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        $section = Section::create($request->all());
        if ($section) {
            return redirect()->back()->with('success_sections', 'تم اضافة القسم بنجاح');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_section = $request->id;
        $request->validate([
            'section_name' => 'required|unique:sections,section_name,' . $id_section,
            'description' => 'required',
        ], [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'هذا الاسم موجود مسبقا',
            'description.required' => 'هذا الحقل مطلوب',
        ]);
        $section_edite = Section::find($id_section);

        if ($section_edite) {
            $section_edite->update($request->only(['section_name', 'description']));
            return redirect()->back()->with('success_sections', 'تم تعديل القسم بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $section_delete = Section::find($request->id);
        if ($section_delete) {
            $section_delete->delete();
            return redirect()->back()->with('success_sections', 'تم حذف القسم بنجاح');
        }
    }
}
