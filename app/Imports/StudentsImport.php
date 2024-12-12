<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements ToModel, WithStartRow, WithValidation
{

    protected $schoolId;

    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }

    public function model(array $row)
    {
        $currentYear = date('Y');
        $userdata = User::where('email',$row[5])->where('school_id',$this->schoolId)->first();
        if ($userdata === null) {
            $username = substr($row[5], 0, strpos($row[5], '@'));
            while (User::where('username', $username)->exists()) {
                // If the username exists, append a random number to the end
                $username = $username . rand(1, 9999);
            }
            $user = User::create([
                'name' => $row[3],
                'username' => $username,
                'email' => $row[5],
                'mother_email' => !empty($row[6]) ? $row[6] : null,
                'school_id' => $this->schoolId,
                'password' => Hash::make($username),
            ]);
            $user_id = $user->id;
        } else {
            $user_id = $userdata->id;
        }
        

        $studentdata = Students::where('student_name',$row[0])->where('student_last_name',$row[1])->where('addresse_email',$row[5])->where('classe',$row[2])->where('year', $currentYear)->first();
        if ($studentdata === null) {
            $student = Students::create([
                'school_id' => $this->schoolId,
                'user_id' => $user_id,
                'student_name' => !empty($row[0]) ? $row[0] : null,
                'student_last_name' => !empty($row[1]) ? $row[1] : null,
                'classe' => !empty($row[2]) ? $row[2] : null,
                'father_name' => !empty($row[3]) ? $row[3] : null,
                'last_father_name' => !empty($row[4]) ? $row[4] : null,
                'addresse_email' => !empty($row[5]) ? $row[5] : null,
                'mother_email' => !empty($row[6]) ? $row[6] : null,
                'telephone_mobile' => !empty($row[7]) ? $row[7] : null,
                'year' => $currentYear,
            ]);
        } 
    }

    public function rules(): array
    {
        return [
            'student_name' => Rule::unique('students', 'student_name'),
        ];
    }

    public function startRow(): int
    {
        return 2; // Skip the first row
    }


    /**
     * @return int
     */
    public function chunkSize()
    {
        return 1000; // Adjust the chunk size as needed for large data sets
    }

    /**
     * @return bool
     */
    public function shouldQueue()
    {
        return true; // Optional: Use a queue for processing large data sets
    }

}
