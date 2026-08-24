<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $name; //Lec 15 Public vs Private vs Constructor Methods in Controllers
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
        }
}
