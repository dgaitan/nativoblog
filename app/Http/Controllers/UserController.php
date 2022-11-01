<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            $users = $users->where(function($query) use ($request) {
                $query->where('name', 'like', "%$request->q%")
                    ->orWhere('last_name', 'like', "%$request->q%")
                    ->orWhere('email', 'like', "%$request->q%");
            }); 
        }

        if ($request->has('user_type') && ! empty($request->user_type) && $request->user()->hasPermissionTo('filter_user_types')) {
            $users->where('user_type', $request->input('user_type'));
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
            'user_types' => User::getUserTypes(),
            'supervisors' => User::supervisors()->get()
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

        if ($user->isBlogger()) {
            $user->supervisor_id = $validated['supervisor'];
            $user->save();
        }

        $request->session()->flash('status', 'User Created Successfully!');

        return redirect($user->getDetailLink());
    }

    /**
     * Edit User
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'supervisors' => User::supervisors()->get(),
            'user_types' => User::getUserTypes()
        ]);
    }

    /**
     * Perform user update
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $request->user_id = $user->id;
        $validated = $this->validation($request, false);
        
        $user->update($request->except(['password', 'supervisor']));

        if (isset($validated['password']) && ! empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        if ($user->isBlogger()) {

            $user->supervisor_id = (int) $validated['supervisor'];
            $user->save();
        }

        $request->session()->flash('status', 'User Updated Successfully!');

        return redirect($user->getEditLink());
    }

    /**
     * Delete a User
     *
     * @param Request $request
     * @param User $post
     * @return void
     */
    public function delete(Request $request, User $user)
    {
        $user->delete();

        $request->session()->flash('status', 'User Deleted Successfully!');

        return redirect(route('app.users.index'));
    }

    /**
     * User Creation validation
     *
     * @param Request $request
     * @return array
     */
    protected function validation(Request $request, bool $passwordRequired = true): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->user_id)],
            'user_type' => ['required', 'integer', function ($attribute, $value, $fail) {
                if (! in_array($value, array_keys(User::getUserTypes()))) {
                    return $fail(__('The user type is invalid'));
                }
            }]
        ];

        if ($passwordRequired) {
            $rules['password'] = [Rule::requiredIf($passwordRequired), 'string', 'min:6'];
        }

        if ((int) $request->user_type === User::$blogger) {
            $rules['supervisor'] = ['required', 'integer', function ($attr, $val, $fail) {
                $supervisor = User::find($val);

                if (is_null($supervisor) || !$supervisor->isSupervisor()) {
                    return $fail('Invalid supervisor');
                }
            }];
        }
        
        return Validator::make($request->all(), $rules)->validate();
    }
}
