<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'date' => 'required',
            'reason' => 'required',
        ]);

        $permission = new Permission();
        $permission->user_id = $request->user()->id;
        $permission->date_permission = $request->date;
        $permission->reason = $request->reason;
        $permission->is_approved = 0;

        if ($request->hasFile(key: 'image')) {
            $image = $request->file('image');
            // $image->storeAs('public/permissions', $image->hashName());
            $image->store('permissions', 'public');
            $permission->image = $image->hashName();
        }

        // return response()->json(['message' =>  $permission->image ], 201);
        $permission->save();

        return response()->json(['message' => 'Permission created successfully'], 201);
    }
    //
}
