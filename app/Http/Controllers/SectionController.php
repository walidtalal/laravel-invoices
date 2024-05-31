<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Section::all();
        return view("sections.sections", compact('sections'));
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
    public function store(Request $request)
    {
//        //
//        $input =$request->all();
//
//        $b_exists = Section::where('section_name','=', $input['section_name'])->exists();
//
//        if($b_exists) {
//            session()->flash('Error', 'حطأ القسم مسجل مسبقاً');
//            return redirect('/sections');
////            return redirect('/sections')->with('Error', 'حطأ القسم مسجل مسبقاً');
//
//        } else {
//            Section::create([
//                'section_name'=>$request->section_name,
//                'description'=>$request->description,
//                'created_by'=> (Auth::user()->name),
//            ]);
//            session()->flash('Add', 'تم إضافة القسم بنجاح');
//            return redirect('/sections');
////            return redirect('/sections')->with('Add', 'تم إضافة القسم بنجsdfgnhjmsfadghjmً');
//        }

        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',


        ]);

        Section::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=> (Auth::user()->name),
            ]);
            session()->flash('Add', 'تم إضافة القسم بنجاح');
            return redirect('/sections');
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
    public function update(Request $request, Section $section)
    {
        //
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
//        return $request;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Section $section)
    {
        //
        $id = $request->id;
        Section::find($id)->delete();
        session()->flash('edit','تم حذف القسم بنجاج');
        return redirect('/sections');
    }
}
