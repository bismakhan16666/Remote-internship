<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
   /* protected $name; //Lec 15 Public vs Private vs Constructor Methods in Controllers
    public function __construct()
    {
        $this->name='My Name ';
    }
    //Lec 13 Create controller
    public function index(){
        return'Hello from the Student Controller';
    }
     public function aboutUs($id,$name){   //Lec 14  Passing Route Data to Controllers
        //return'ID no ' . $id . ' Name is ' . $name;
        //Lec 15 Public vs Private vs Constructor Methods in Controllers
        //$name=$this->privateFunction();

        return $this->name;

        return view('aboutus',compact('id','name'));
     }
        private function privateFunction(){
            return'Hello';
        }*/
    // Lec 26 & 27
    public function addData(){
        /*DB::table('students')->insert([
        [
            'name'=>'tester',
            'email'=>'tester@gmail.com',
            'age'=>'20',
            'date_of_birth'=>'2006-01-01',
            'gender'=>'f',
            'user_id' => 1,  
            'score' => 85, //Lec 31 
            'created_at' => now(),
            'updated_at' => now(),    
        ],
        [
            'name'=>'Bisma',
            'email'=>'bisma@gmail.com',
            'age'=>'20',
            'date_of_birth'=>'2004-01-01',
            'gender'=>'f',
            'user_id' => 3,  
            'score' => 80, //Lec 31
            'created_at' => now(),
            'updated_at' => now(),
            
        ]
        ]);*/
        //Lec 32
        $items= new  Student    ();
        $items     ->name = 'Bisma';
        $items     ->email = 'bisma@gmail.com';
        $items     ->age = 22;
        $items     ->date_of_birth = '2004-01-01';
        $items     ->gender = 'f';
        $items     ->user_id = 1;
        $items     ->score = 85;
        $items     ->save();
        return'Add Successfuly';
        }
    //Lec 28 
    public function getData(){
        /*$items=DB::table('students')//->get();
        //->first();
        ->max('score');//Lec 31
        return $items;
        }
        */
        //Lec 33 
        $items = Student::all();
        return $items ;
        }
    // Lec 29 - Update Data
    public function updateData()
    {/*
        DB::table('students')
            ->where('id', 3)
            ->update([
                'name' => 'Updated Name',
                'updated_at' => now(),
            ]);
        */
            //Lec 34
        $items=Student :: find(23);
        $items-> name ='Updated Name';

        return 'Updated Successfully';
    } 
    // Lec 30 
    public function deleteData()
    {/*
        DB::table('students')
            ->where('id', 3)
            ->delete();
        */
        //Lec 35
    
        $items=Student :: find(20); 
        $items->delete();  
        return 'Deleted Successfully';
    }   
}