<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Students;
use App\Models\Schools;
use App\Models\Products;
use App\Imports\SchoolsImport;
use App\Imports\StudentsImport;
use Illuminate\Support\Str;
use Image;
use Carbon\Carbon;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = Schools::latest()->get();

        $years = Students::select('year')->distinct()->orderBy('year','asc')->get();

        return view('backend.schools.index', compact('schools','years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_url = null;
        $image = $request->file('image');
        if ($request->file('image')) {
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/schools/'.$name_gen);
            $save_url = 'upload/schools/'.$name_gen;
        }

        Schools::insert([
            'school_name' => $request->school_name,
            'slug' => Str::slug($request->school_name),
            'address' => $request->address,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'image' => $save_url, 
            'created_at' => Carbon::now()
        ]);

       $notification = array(
            'message' => 'School Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.schools.index')->with($notification);
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
    public function edit(Schools $school)
    {
        return view('backend.schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/schools/'.$name_gen);
            $save_url = 'upload/schools/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            Schools::findOrFail($id)->update([
                'school_name' => $request->school_name,
                'slug' => Str::slug($request->school_name),
                'address' => $request->address,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'image' => $save_url, 
                'updated_at' => Carbon::now(),
            ]);

           $notification = array(
                'message' => 'Schools Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.schools.index')->with($notification); 

        } else {

            Schools::findOrFail($id)->update([
                'school_name' => $request->school_name,
                'slug' => Str::slug($request->school_name),
                'address' => $request->address,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Schools Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.schools.index')->with($notification); 

        } 
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

    public function delete($id)
    {
        $del = Schools::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        Schools::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Schools Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteproduct($id)
    {


        $students = Students::where('school_id',$id)->get();

        foreach($students as $student) {
            Products::where('student_id',$student->id)->delete();
        }



        $notification = array(
            'message' => 'Products Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function studentsimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($request->hasFile('file')) {

            $schoolId = $request->school_id;

            $file = $request->file('file');
            
            Excel::import(new StudentsImport($schoolId), $file);

            $notification = array(
                'message' => 'Excel file imported successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.schools.index')->with($notification);

        } else {
            $notification = array(
                'message' => 'Please upload an Excel file.',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.schools.index')->with($notification);
        }

        /*$file = $request->file('file');

        Excel::import(new StudentsImport, $file);

        return redirect()->back()->with('success', 'File imported successfully!');*/
    }
}
