<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }


    public function getUserByEmail(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|max:255']);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $email = $request->input('email');
        $users = User::whereRaw("email LIKE '%" . $email . "%'")->get();
        return $users;
    }


    public function getUserCount()
    {
        return User::all()->count();
    }


    public function updateUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'first_name' => 'min:2',
                'last_name' => 'min:2',
                'email' => 'min:5'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);

        $user = User::where('id', $id)->firstOrFail();
        $user->update($data);
        $user->save();

        return $user;
    }


    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $body = $request->all();

        $user = User::firstOrCreate($body);
        return $user;
    }


    public function removeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $email = $request->input('email');
        $user = User::where('email', $email)->delete();
        if ($user > 0) {
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Not found'], 400);
        }
    }
}
