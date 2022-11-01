<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    /**
     * Index View
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return view('supervisors.index', [
            'supervisors' => User::supervisors()->paginate(20) 
        ]);
    }

    /**
     * See Supervisor Bloggers
     *
     * @param User $user
     * @return void
     */
    public function bloggers(User $user)
    {
        return view('supervisors.bloggers', [
            'supervisor' => $user,
            'users' => $user->bloggers()->paginate(20)
        ]);
    }
}
