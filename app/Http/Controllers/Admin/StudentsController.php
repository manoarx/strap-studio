<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Models\Students;
use App\Models\Products;
use App\Models\Schools;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use URL;
use Illuminate\Support\Facades\DB;
//use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class StudentsController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $classe = $schoolid = $division = $service = $filter_range = null;

        $query = Students::orderBy('id','desc');

        if ($request->classe) {
            $classe = $request->classe;
            if($classe == 'All') {

            } else {
                $query->where('classe', '=', $classe); 
            }
            
        }

        if ($request->year) {
            $year = $request->year;
            if($year == 'All') {

            } else {
                $query->where('year', '=', $year); 
            }
            
        }

        if ($request->searchkey) {
            $searchkey = $request->searchkey;

            $query->where('student_name', 'LIKE', '%'.$searchkey.'%')->orWhere('student_last_name', 'LIKE', '%'.$searchkey.'%')->orWhere('classe', 'LIKE', '%'.$searchkey.'%')->orWhere('father_name', 'LIKE', '%'.$searchkey.'%')->orWhere('last_father_name', 'LIKE', '%'.$searchkey.'%')->orWhere('addresse_email', 'LIKE', '%'.$searchkey.'%')->orWhere('mother_email', 'LIKE', '%'.$searchkey.'%'); 
            
            
        }

        if ($request->schoolid) {
            $schoolid = $request->schoolid;
            $query->where('school_id', '=', $schoolid); 
        }

        $students = $query->paginate(30);

        $schools = Schools::get();

        $users = User::where('type',0)->get();

        $classelist = Students::select('classe')->where('school_id',$schoolid)->distinct()->orderBy('classe','asc')->get();

        $years = Students::select('year')->where('school_id',$schoolid)->distinct()->orderBy('year','asc')->get();

        return view('backend.students.index', compact('students','schools','users','year','classe','classelist','schoolid','years'));
    }


    public function getstudents(Request $request)
    {
        ## Read value
     $draw = $request->get('draw');
     $start = $request->get("start");
     $rowperpage = $request->get("length"); // Rows display per page

     $columnIndex_arr = $request->get('order');
     $columnName_arr = $request->get('columns');
     $order_arr = $request->get('order');
     $search_arr = $request->get('search');

     $columnIndex = $columnIndex_arr[0]['column']; // Column index
     $columnName = $columnName_arr[$columnIndex]['data']; // Column name
     $columnSortOrder = $order_arr[0]['dir']; // asc or desc
     $searchValue = $search_arr['value']; // Search value

     // Total records
     $totalRecords = Students::select('count(*) as allcount')->count();
     $totalRecordswithFilter = Students::select('count(*) as allcount')->where('student_name', 'like', '%' .$searchValue . '%')->count();

     // Fetch records
     $records = Students::orderBy($columnName,$columnSortOrder)
       ->where('students.student_name', 'like', '%' .$searchValue . '%')
       ->select('students.*')
       ->skip($start)
       ->take($rowperpage)
       ->get();

     $data_arr = array();
     
     foreach($records as $record){
        $id = $record->id;
        $student_name = $record->student_name;
        $father_name = $record->father_name;
        $addresse_email = $record->addresse_email;
        $mother_email = $record->mother_email;

        $data_arr[] = array(
          "id" => $id,
          "student_name" => $student_name,
          "father_name" => $father_name,
          "addresse_email" => $addresse_email,
          "mother_email" => $mother_email
        );
     }

     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
     );

     return response()->json($response);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schools = Schools::get();

        $users = User::where('type',0)->get();

        return view('backend.students.create', compact('schools','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->addresse_email)) {
            $addresse_email = $request->addresse_email;
            $userdata = User::where('email',$addresse_email)->first();
            if ($userdata === null) {
                $username = substr($request->addresse_email, 0, strpos($request->addresse_email, '@'));
                while (User::where('username', $username)->exists()) {
                    // If the username exists, append a random number to the end
                    $username = $username . rand(1, 9999);
                }
                $user = User::create([
                    'name' => $request->father_name." ".$request->last_father_name,
                    'username' => $username,
                    'email' => $request->addresse_email,
                    'mother_email' => $request->mother_email,
                    'school_id' => $request->school_id,
                    'password' => Hash::make($username),
                ]);
                $user_id = $user->id;
            } else {
                $user_id = $userdata->id;
            }
        }

        $save_url = null;
        $image = $request->file('image');
        if ($request->file('image')) {
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/students/'.$name_gen);
            $save_url = 'upload/students/'.$name_gen;
        }

        Students::insert([
            'school_id' => $request->school_id,
            'user_id' => $user_id,
            'student_name' => $request->student_name,
            'student_last_name' => $request->student_last_name,
            'classe' => $request->classe,
            'father_name' => $request->father_name,
            'last_father_name' => $request->last_father_name,
            'addresse_email' => $request->addresse_email,
            'mother_email' => $request->mother_email,
            'telephone_mobile' => $request->telephone_mobile,
            'image' => $save_url, 
            'year' => date('Y'), 
            'created_at' => Carbon::now(),
        ]);

       $notification = array(
            'message' => 'Student Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.students.index', ['schoolid' => $request->school_id])->with($notification); 
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
    public function edit(Students $student)
    {
        $schools = Schools::get();

        return view('backend.students.edit', compact('student','schools'));
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
        /*if(isset($request->addresse_email)) {
            $addresse_email = $request->addresse_email;
            $userdata = User::where('email',$addresse_email)->first();
            if ($userdata === null) {
                $username = substr($request->addresse_email, 0, strpos($request->addresse_email, '@'));
                while (User::where('username', $username)->exists()) {
                    // If the username exists, append a random number to the end
                    $username = $username . rand(1, 9999);
                }
                $user = User::create([
                    'name' => $request->father_name." ".$request->last_father_name,
                    'email' => $request->addresse_email,
                    'school_id' => $request->school_id,
                ]);
                $user_id = $user->id;
            } else {
                $user_id = $userdata->id;
            }
        }*/

        $id = $request->id;
        $userid = $request->userid;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/students/'.$name_gen);
            $save_url = 'upload/students/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            Students::findOrFail($id)->update([
                'school_id' => $request->school_id,
                'user_id' => $userid,
                'student_name' => $request->student_name,
                'student_last_name' => $request->student_last_name,
                'classe' => $request->classe,
                'father_name' => $request->father_name,
                'last_father_name' => $request->last_father_name,
                'addresse_email' => $request->addresse_email,
                'mother_email' => $request->mother_email,
                'telephone_mobile' => $request->telephone_mobile,
                'image' => $save_url,
                'year' => $request->year,
                'updated_at' => Carbon::now(),
            ]);

           

        } else {

            Students::findOrFail($id)->update([
                'school_id' => $request->school_id,
                'user_id' => $userid,
                'student_name' => $request->student_name,
                'student_last_name' => $request->student_last_name,
                'classe' => $request->classe,
                'father_name' => $request->father_name,
                'last_father_name' => $request->last_father_name,
                'addresse_email' => $request->addresse_email,
                'mother_email' => $request->mother_email,
                'telephone_mobile' => $request->telephone_mobile,
                'year' => $request->year,
                'updated_at' => Carbon::now(),
            ]);

             

        } 

        User::findOrFail($userid)->update([
            'name' => $request->father_name." ".$request->last_father_name,
            'email' => $request->addresse_email,
            'mother_email' => $request->mother_email,
            'school_id' => $request->school_id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Students Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.students.index', ['schoolid' => $request->school_id])->with($notification); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        Students::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Selected rows have been deleted."]);
    }

    public function delete($id)
    {
        $del = Students::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        Students::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Students Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteproduct($id)
    {

        Products::where('student_id',$id)->delete();

        $notification = array(
            'message' => 'Products Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /*public function addproducts(Request $request)
    {
        $products = Products::create(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        foreach ($request->input('photos', []) as $file) {
            $products->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }

        $products->save();

        return redirect()->route('admin.students.index');
    }*/

    public function sendVerificationEmail(Request $request)
    {
        $user = User::find($request->userId);

        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $user->id, 
              'token' => $token
            ]);
        
        $verificationUrl = route('user.verify', $token);
        $userName = $user->username;

        $userType = $user->type;

        

        if(isset($user->mother_email) && $user->mother_email != "")  {
            Mail::to($user->email)
            ->cc($user->mother_email)
            ->send(new VerifyEmail($verificationUrl, $userName, $userType));
        } else {
            Mail::to($user->email)->send(new VerifyEmail($verificationUrl,$userName,$userType));
        }
        

        /*$notification = array(
                'message' => 'Verification email sent',
                'alert-type' => 'success'
            );
        return redirect()->route('admin.students.index')->with($notification);*/

        return response()->json(['message' => 'Email sent successfully']);
            
    }

    public function sendBulkVerificationEmail(Request $request)
    {
        ini_set('memory_limit', '-1');
        $users = User::whereIn('id', $request->selected_items)->get();

        foreach($users as $user) {
            $token = Str::random(64);
      
            UserVerify::create([
                  'user_id' => $user->id, 
                  'token' => $token
                ]);
            
            $verificationUrl = route('user.verify', $token);
            $userName = $user->username;

            $userType = $user->type;

            //Mail::to($user->email)->send(new VerifyEmail($verificationUrl,$userName,$userType));
            if(isset($user->mother_email) && $user->mother_email != "")  {
                Mail::to($user->email)
                ->cc($user->mother_email)
                ->send(new VerifyEmail($verificationUrl, $userName, $userType));
            } else {
                Mail::to($user->email)->send(new VerifyEmail($verificationUrl,$userName,$userType));
            }
        }


        return response()->json(['message' => 'Email sent successfully']);
    }
    
    public function massdelete(Request $request)
    {
        $ids = $request->input('ids');
        Students::whereIn('id', $ids)->delete();
        return response()->json(['success' => true]);
    }
}
