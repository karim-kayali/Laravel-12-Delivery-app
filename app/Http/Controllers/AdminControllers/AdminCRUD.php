<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class AdminCRUD extends Controller
{
    public function displayAdminProfile($id) {
        $onEdit = false;
        $user = User::find($id);
        if($user->id == Auth::user()->id) {
            return view('AdminViews/DisplayAdminProfile', compact('user', 'onEdit'));
        }
        else {
            return abort(403);
        }

    }

    public function turnOnEdit($id) {


        $onEdit = true;
        $user = User::findOrFail($id);
    if($user->id == Auth::user()->id) {
        return view('AdminViews/DisplayAdminProfile', compact('user', 'onEdit'));

    }
    else {
        return abort(403);
    }

    }


    public function editAdminProfile($id, Request $request)
    {
        $request->validate([
            'userName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'userName')->ignore($id),
            ],
            'phoneNumber' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phoneNumber')->ignore($id),
            ],
        ]);
        $user = User::findOrFail($id);

        if($user->id == Auth::user()->id) {
            $user->userName = $request->userName;
            $user->phoneNumber = $request->phoneNumber;
            $user->save();

            return redirect()->route('displayAdminProfile', ['id' => $user->id]);
        } else {
            return abort(403);
        }



    }


    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }
}
