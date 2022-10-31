<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Update Account
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                        Rule::unique('users')->ignore($request->user()->id)
                    ],
        ];
        
        if (! empty($request->current_password)) {
            $rules['current_password'] = ['string', 'min:6', function ($attribute, $value, $fail) use ($request) {
                if (! Hash::check($value, $request->user()->password)) {
                    return $fail(__('The current password is incorreect'));
                }
            }];

            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }
        
        Validator::make($request->all(), $rules)->validate();

        $data = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email  
        ];

        if ($request->has('password') && ! empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $request->user()->update($data);

        return response()->json([
            'message' => __('User has been updated successfully!')
        ], 200);
    }
}
