<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetail;
use Illuminate\Validation\Rule;
use Illuminate\Http\Middleware\HandleCors;

class UserDetailController extends Controller
{
    public function index()
    {
        return UserDetail::paginate(10);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:user_details,email',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pics', 'public');
        }

        return UserDetail::create($validated);
    }

    public function show(UserDetail $userDetail)
    {
        return $userDetail;
    }

    public function update(Request $request, UserDetail $userDetail)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('user_details')->ignore($userDetail->id)],
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pics', 'public');
        }

        $userDetail->update($validated);
        return $userDetail;
    }

    public function destroy(UserDetail $userDetail)
    {
        $userDetail->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
