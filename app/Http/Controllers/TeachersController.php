<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    //Lec 22
   public function index()
    {
        return Teachers::all();
    } 
    public function add()
    {
        //Lec23 Understanding Invoke & Resource Controllers
        $items=new Teachers();
        $items->name='Test Name';
        $items->save();

        Return'Added Successfully';
        }
    public function show($id)
    {
        //
        $items=Teachers::findOrfail($id);
        return $items;
    }
    public function update($id)
    {
        //
        $items=Teachers::findOrfail($id);
        $items->name='Updated Teacher';
        $items->update();
        return'Updated Successfully';
    }
    public function delete($id)
    {
        //
        $items=Teachers::findOrfail($id);
        $items->delete();
        return'Deleted Successfully';
    }
}