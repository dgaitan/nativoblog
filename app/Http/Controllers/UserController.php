<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * User Index
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * Show User
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Create new user
     *
     * @param Request $request
     * @return void
     */
    public function new(Request $request)
    {
        return view('users.new', [
            'user_types' => User::getUserTypes()
        ]);
    }

    /**
     * Store New user
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $this->validation($request);

        $user = User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ])->changeUserType($validated['user_type']);

        $request->session()->flash('status', 'User Created Successfully!');

        return redirect($user->getDetailLink());
    }

    /**
     * User Creation validation
     *
     * @param Request $request
     * @return array
     */
    protected function validation(Request $request): array
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'user_type' => ['required', 'integer', function ($attribute, $value, $fail) use ($request) {
                if (! in_array($value, array_keys(User::getUserTypes()))) {
                    return $fail(__('The user type is invalid'));
                }
            }]
        ])->validate();
    }
}
