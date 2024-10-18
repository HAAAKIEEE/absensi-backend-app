<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // public function show() {
    //     return response(['meesage'=>'hai'],200);
    // }
    public function company()
    {
        // $item = Company::find(1);
        $items = Company::where('id', 1)->get();
        return response()->json($items);
    }
    
}
