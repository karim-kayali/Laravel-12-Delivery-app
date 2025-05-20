<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class ProfileController extends Controller
{



    public function displayUserProfile($id) {
        $onEdit = false;
        $user = User::find($id);
        if($user->id == Auth::user()->id) {
            return view('ClientViews/ClientProfile', compact('user', 'onEdit'));
        }
        else {
            return abort(403);
        }

    }

    public function UserturnOnEdit($id) {


        $onEdit = true;
        $user = User::findOrFail($id);

        if($user->id == Auth::user()->id) {
            return view('ClientViews/ClientProfile', compact('user', 'onEdit'));
            }
        else {
            return abort(403);
        }




    }

    public function editUserProfile($id, Request $request) {
        $request->validate([
            'userName' => 'required|string|max:255',
            'phoneNumber' => 'nullable|string|max:20',
        ]);


        $user = User::findOrFail($id);

        if($user->id == Auth::user()->id) {
            $user->userName = $request->userName;
            $user->phoneNumber = $request->phoneNumber;
            $user->save();

            return redirect()->route('displayUserProfile', ['id' => $user->id]);
        } else {
            return abort(403);
        }


    }


}
