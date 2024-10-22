<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function index($lang){
        if($lang=="en"){
            session()->put('lang','en');
        }else{
            session()->put('lang','ar');
        }
        return redirect()->back();
    }
}
