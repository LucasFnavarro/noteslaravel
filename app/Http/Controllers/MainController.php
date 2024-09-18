<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        echo "index maincontroller";
    }

    public function newNote(){
        echo "newNote";
    }
}
