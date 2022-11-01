<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'desc');

        if ($request->user()->isSupervisor()) {
            $users->whereSupervisorId($request->user()->id);
        }


        if ($request->has('q')) {
            $users->where(function($query) use ($request) {
                $query->where('name', 'like', "%$request->q%")
                    ->orWhere('last_name', 'like', "%$request->q%")
                    ->orWhere('email', 'like', "%$request->q%");
            }); 
        }

        return view('users.list', [
            'users' => $users->paginate(20),
            'q' => $request->has('q') ? $request->q : ''
        ]);
    }
}
