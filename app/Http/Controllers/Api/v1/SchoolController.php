<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolCollection;
use App\Http\Resources\Api\SchoolResource;
use App\Models\School;

use Illuminate\Http\Request;

class SchoolController extends Controller
{

    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school = School::with(['branches.schoolLeaders'])->paginate(10);

        return new SchoolCollection($school);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string|max:150',
            'address'=>['required','string',''],
            'email'=>['required','email', 'unique:schools,email'],
            'website' => ['required','string',''],
            'phone_no' => ['required','string',''],
            'grade_division' => ['required','string',''],
            'branch_id' => ['required','string',''],
            ''
        ]);

        $school = School::create($attrs);

       $branch = $school->branches()->create([
        'name'=> '',
        'location'
       ]);

       $branch->gradeDivisions()->create([
        'grade_divisions' => ''
       ]);


        return new SchoolResource($school);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}